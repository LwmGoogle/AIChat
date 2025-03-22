document.addEventListener('DOMContentLoaded', function() {
    const aiSelect = document.getElementById('ai-select');
    const modelSelect = document.getElementById('model-select');
    const userInput = document.getElementById('user-input');
    const chatHistory = document.getElementById('chat-history');
    const sendBtn = document.getElementById('send-btn');
    const clearBtn = document.getElementById('clear-btn');
    const endBtn = document.getElementById('end-btn');
    const exportBtn = document.getElementById('export-btn');

    // 存储聊天记录
    let chatMessages = [];

    // 更新选择框图标
    function updateSelectIcon() {
        const selectedOption = aiSelect.options[aiSelect.selectedIndex];
        const icon = selectedOption.getAttribute('data-icon');
        const selectGroup = aiSelect.closest('.select-group');
        selectGroup.setAttribute('data-ai', aiSelect.value);
    }

    // AI选择改变时更新模型列表和图标
    aiSelect.addEventListener('change', function() {
        updateSelectIcon();
        fetch('get_models.php?ai=' + this.value)
            .then(response => response.json())
            .then(models => {
                modelSelect.innerHTML = '';
                models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('获取模型列表失败:', error);
                modelSelect.innerHTML = '<option value="">获取模型失败</option>';
            });
    });

    // 初始化图标
    updateSelectIcon();

    // 发送消息
    function sendMessage() {
        const message = userInput.value.trim();
        
        // 输入验证
        if (!message) {
            alert('请输入消息内容');
            return;
        }

        if (message.length > 2000) {
            alert('消息长度不能超过2000个字符');
            return;
        }

        if (!aiSelect.value) {
            alert('请选择AI');
            return;
        }

        if (!modelSelect.value) {
            alert('请选择模型');
            return;
        }

        // 添加用户消息到聊天历史
        addMessage(message, true);

        // 发送到服务器
        fetch('chat.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                message: message,
                ai: aiSelect.value,
                model: modelSelect.value
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('网络响应错误');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            addMessage(data.response, false);
        })
        .catch(error => {
            console.error('发送消息失败:', error);
            addMessage('发送消息失败: ' + error.message, false);
        })
        .finally(() => {
            // 清空输入框
            userInput.value = '';
        });
    }

    // 添加消息到聊天历史
    function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'ai-message'}`;
        
        const timestamp = document.createElement('div');
        timestamp.className = 'timestamp';
        timestamp.textContent = new Date().toLocaleString();
        
        const messageContent = document.createElement('div');
        messageContent.className = 'message-content';
        messageContent.textContent = content;
        
        messageDiv.appendChild(timestamp);
        messageDiv.appendChild(messageContent);
        
        chatHistory.appendChild(messageDiv);
        chatHistory.scrollTop = chatHistory.scrollHeight;

        // 保存消息到数组
        chatMessages.push({
            type: isUser ? 'user' : 'ai',
            content: content,
            timestamp: new Date().toLocaleString(),
            meta: null
        });
    }

    // 清空聊天记录
    function clearChat() {
        if (confirm('确定要清空聊天记录吗？')) {
            chatHistory.innerHTML = '';
            chatMessages = [];
        }
    }

    // 结束对话
    function endChat() {
        if (confirm('确定要结束对话吗？')) {
            clearChat();
            aiSelect.value = '';
            modelSelect.innerHTML = '<option value="">请先选择 AI</option>';
            updateSelectIcon();
        }
    }

    // 导出聊天记录
    function exportChat() {
        if (chatMessages.length === 0) {
            alert('没有可导出的聊天记录');
            return;
        }

        const exportData = {
            timestamp: new Date().toLocaleString(),
            messages: chatMessages
        };

        const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `chat_history_${new Date().toISOString().slice(0,10)}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    // 事件监听器
    sendBtn.addEventListener('click', sendMessage);
    clearBtn.addEventListener('click', clearChat);
    endBtn.addEventListener('click', endChat);
    exportBtn.addEventListener('click', exportChat);

    // 按Enter发送消息
    userInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
}); 