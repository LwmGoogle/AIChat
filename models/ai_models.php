<?php
// AI Models Configuration
$AI_MODELS = [
    'ChatGPT' => [
        'gpt-3.5-turbo',
        'gpt-3.5-turbo-1106',
        'gpt-3.5-turbo-0125',
        'gpt-3.5-turbo-16k',
        'gpt-3.5-turbo-instruct',
        'gpt-4.5-preview',
        'gpt-4.5-preview-2025-02-27',
        'o1-mini',
        'o1-preview',
        'o3-mini [5]',
        'o1 [5]',
        'gpt-4o-search-preview',
        'gpt-4o-search-preview-2025-03-11',
        'gpt-4o-mini-search-preview',
        'gpt-4o-mini-search-preview-2025-03-11',
        'gpt-4',
        'gpt-4o',
        'gpt-4o-2024-05-13',
        'gpt-4o-2024-08-06',
        'gpt-4o-2024-11-20',
        'chatgpt-4o-latest',
        'gpt-4o-mini',
        'gpt-4-0613',
        'gpt-4-turbo-preview',
        'gpt-4-0125-preview',
        'gpt-4-1106-preview',
        'gpt-4-vision-preview',
        'gpt-4-turbo',
        'gpt-4-turbo-2024-04-09',
        'gpt-3.5-turbo-ca',
        'gpt-4-ca',
        'gpt-4-turbo-ca',
        'gpt-4o-ca',
        'gpt-4o-mini-ca',
        'chatgpt-4o-latest-ca',
        'o1-mini-ca',
        'o1-preview-ca',
        'deepseek-reasoner',
        'deepseek-r1',
        'deepseek-v3',
        'claude-3-7-sonnet-20250219',
        'claude-3-5-sonnet-20240620',
        'claude-3-5-sonnet-20241022',
        'claude-3-5-haiku-20241022',
        'gemini-1.5-flash-latest',
        'gemini-1.5-pro-latest',
        'gemini-exp-1206',
        'gemini-2.0-flash-exp',
        'gemini-2.0-pro-exp-02-05',
        'gemini-2.0-flash',
        'grok-3',
        'grok-3-reasoner',
        'grok-3-deepsearch',
        'dall-e-3 1024×1024',
        'dall-e-3 1024×1792',
        'dall-e-3-hd 1024×1024',
        'dall-e-3-hd 1024×1792',
        'dall-e-2 1024×1024',
        'dall-e-2 512x512',
        'dall-e-2 256x256',
        'tts-1',
        'tts-1-hd',
        'Whisper',
        'text-embedding-ada-002',
        'text-embedding-3-small',
        'text-embedding-3-large'
    ],
    'Qwen' => [
        'qwen-max',
        'qwen-plus',
        'qwem-turbo',
        'qwen-2.5-coder-32b-instruct',
        'qwen-2.5-coder-72b-instruct',
        'qwen-2.5-coder-14b-instruct',
        'qwen-2.5-coder-7b-instruct',
        'qwen-2.5-coder-32b-instruct',
        'qwen-2.5-coder-72b-instruct',
        'qwen-2.5-coder-14b-instruct',
        'qwen-2.5-coder-7b-instruct',
        'qwen-2.5-coder-32b-instruct',
        'qwen-2.5-coder-72b-instruct',
        'qwen-2.5-coder-14b-instruct',
        'qwen-2.5-coder-7b-instruct',
        'qwen-2.5-coder-32b-instruct',
        'qwen-2.5-coder-72b-instruct',
    ],
    'Grok' => [
        'grok-2-1212',
        'grok-2',
        'grok-2-latest',
        'grok-3',
        'grok-3-reasoner',
        'grok-3-deepsearch'
    ],
    'DeepSeek' => [
        'deepseek-reasoner',
        'deepseek-chat',
        'deepseek-coder',
        'deepseek-coder-plus',
        'deepseek-coder-plus-12b',
        'deepseek-coder-plus-12b-instruct',
        'deepseek-coder-plus-12b-instruct',
        'deepseek-coder-plus-12b-instruct',
        'deepseek-coder-plus-12b-instruct',
    ]
];

function getModels($ai) {
    global $AI_MODELS;
    return isset($AI_MODELS[$ai]) ? $AI_MODELS[$ai] : [];
}
?> 