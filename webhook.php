<?php
// GitHub Webhook Secret (如果设置了的话)
$secret = "Secret-"; 

// 获取 GitHub 发来的签名
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

// 获取 POST 数据
$payload = file_get_contents('php://input');

// 计算我们服务器的签名
$hash = 'sha1=' . hash_hmac('sha1', $payload, $secret);

// 验证签名
if (hash_equals($signature, $hash)) {
    // 签名验证通过，执行 `git pull`
    shell_exec('cd /var/www/html/cloudflare && git pull origin main');
    http_response_code(200);
    echo 'Webhook executed';
} else {
    // 签名验证失败
    http_response_code(403);
    echo 'Forbidden';
}
?>