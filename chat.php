<?php
require_once 'config/api_config.php';

header('Content-Type: application/json');

// 加载配置
require_once 'config.php';

// 检查请求方法
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// 获取并验证输入
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['message']) || !isset($input['ai']) || !isset($input['model'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// 清理和验证输入
$message = htmlspecialchars(trim($input['message']), ENT_QUOTES, 'UTF-8');
$ai = htmlspecialchars(trim($input['ai']), ENT_QUOTES, 'UTF-8');
$model = htmlspecialchars(trim($input['model']), ENT_QUOTES, 'UTF-8');

// 验证消息长度
if (strlen($message) > 2000) {
    http_response_code(400);
    echo json_encode(['error' => 'Message too long']);
    exit;
}

// 验证AI和模型
$valid_ais = ['ChatGPT', 'Claude', 'Qwen', 'Grok', 'DeepSeek'];
if (!in_array($ai, $valid_ais)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid AI selection']);
    exit;
}

// 根据选择的AI和模型处理请求
try {
    switch ($ai) {
        case 'ChatGPT':
            // 处理ChatGPT请求
            $response = handleChatGPT($message, $model);
            break;
        case 'Claude':
            // 处理Claude请求
            $response = handleClaude($message, $model);
            break;
        case 'Qwen':
            // 处理Qwen请求
            $response = handleQwen($message, $model);
            break;
        case 'Grok':
            // 处理Grok请求
            $response = handleGrok($message, $model);
            break;
        case 'DeepSeek':
            // 处理DeepSeek请求
            $response = handleDeepSeek($message, $model);
            break;
        default:
            throw new Exception('Unsupported AI');
    }
    
    echo json_encode(['response' => $response]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

// 根据AI类型选择API和Key
switch ($ai) {
    case 'ChatGPT':
        $api_url = CHATGPT_API;
        $api_key = CHATGPT_KEY;
        break;
    case 'Qwen':
        $api_url = QWEN_API;
        $api_key = TONGYI_KEY;
        break;
    case 'Grok':
        $api_url = GROK_API;
        $api_key = GROK_KEY;
        break;
    case 'DeepSeek':
        $api_url = DEEPSEEK_API;
        $api_key = DEEPSEEK_KEY;
        break;
    default:
        die(json_encode(['error' => 'Invalid AI service']));
}

// 准备请求数据
$data = [
    'model' => $model,
    'messages' => [
        [
            'role' => 'user',
            'content' => $message
        ]
    ]
];

// 发送API请求
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    die(json_encode(['error' => 'API request failed']));
}

// 解析响应
$result = json_decode($response, true);

// 记录聊天历史
$log_entry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'ai' => $ai,
    'model' => $model,
    'question' => $message,
    'answer' => $result['choices'][0]['message']['content'] ?? 'No response'
];

file_put_contents('chat_history.log', json_encode($log_entry) . "\n", FILE_APPEND);

// 返回响应
echo json_encode([
    'response' => $result['choices'][0]['message']['content'] ?? 'No response'
]);
?> 