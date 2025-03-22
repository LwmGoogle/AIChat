<?php
require_once 'models/ai_models.php';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI聊天系统</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-robot"></i> AI聊天系统</h1>
        </div>
        
        <div class="controls">
            <div class="select-group">
                <label for="ai-select">
                    <i class="fas fa-brain"></i> 选择AI：
                </label>
                <select id="ai-select" required>
                    <option value="" disabled selected>请选择AI</option>
                    <?php foreach (array_keys($AI_MODELS) as $ai): ?>
                        <option value="<?php echo htmlspecialchars($ai); ?>">
                            <?php 
                            $icon = '';
                            switch($ai) {
                                case 'ChatGPT':
                                    $icon = 'fa-comment-dots';
                                    break;
                                case 'Qwen':
                                    $icon = 'fa-dragon';
                                    break;
                                case 'Grok':
                                    $icon = 'fa-bolt';
                                    break;
                                case 'DeepSeek':
                                    $icon = 'fa-magnifying-glass';
                                    break;
                            }
                            ?>
                            <i class="fas <?php echo $icon; ?>"></i>
                            <?php echo htmlspecialchars($ai); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="select-group">
                <label for="model-select">
                    <i class="fas fa-microchip"></i> 选择模型：
                </label>
                <select id="model-select" required>
                    <option value="" disabled selected>请先选择AI</option>
                </select>
            </div>
        </div>

        <div class="chat-container">
            <div class="input-area">
                <textarea 
                    id="user-input" 
                    placeholder="请输入您的问题..."
                    rows="4"
                ></textarea>
                <div class="buttons">
                    <button id="send-btn" class="send-btn" title="发送消息">
                        <i class="fas fa-paper-plane"></i>
                        <span>发送</span>
                    </button>
                    <button id="clear-btn" class="clear-btn" title="清空聊天记录">
                        <i class="fas fa-eraser"></i>
                        <span>清空</span>
                    </button>
                    <button id="end-btn" class="end-btn" title="结束聊天">
                        <i class="fas fa-times"></i>
                        <span>结束聊天</span>
                    </button>
                </div>
            </div>
            
            <div id="chat-history" class="chat-history"></div>
            <div class="export-container">
                <button id="export-btn" class="export-btn" title="导出聊天记录">
                    <i class="fas fa-download"></i>
                    <span>导出聊天</span>
                </button>
            </div>
        </div>
    </div>
    
    <script src="js/chat.js"></script>
</body>
</html> 