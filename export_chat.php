<?php
header('Content-Type: application/json');

// 获取POST数据
$chatHistory = json_decode(file_get_contents('php://input'), true);

if (!$chatHistory) {
    die(json_encode(['error' => 'No chat history provided']));
}

// 创建ChatRecord目录（如果不存在）
$dir = 'ChatRecord';
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

// 生成文件名（日期+时间）
$filename = date('Y-m-d_H-i-s') . '.txt';
$filepath = $dir . '/' . $filename;

// 创建文本内容
$content = "聊天记录 - " . date('Y-m-d H:i:s') . "\n\n";

for ($i = 0; $i < count($chatHistory); $i++) {
    $message = $chatHistory[$i];
    
    if ($message['type'] === 'user') {
        $content .= "问题时间：" . $message['timestamp'] . "\n";
        $content .= "问题内容：" . $message['content'] . "\n";
    } else if ($message['type'] === 'ai') {
        $content .= "回答模型：" . $message['meta'] . "\n";
        $content .= "回答时间：" . $message['timestamp'] . "\n";
        $content .= "回答内容：" . $message['content'] . "\n\n\n";
    }
}

// 保存文件
if (file_put_contents($filepath, $content) === false) {
    die(json_encode(['error' => 'Failed to save chat history']));
}

echo json_encode([
    'success' => true,
    'filename' => $filename,
    'path' => $filepath
]);
?> 