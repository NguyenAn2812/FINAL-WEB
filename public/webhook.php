<?php
// webhook.php
$secret = '2F4O1YBEYCC7YFH464YY6PF021Q2CRZY'; // Giống secret bên GitHub webhook

$headers = getallheaders();
$payload = file_get_contents('php://input');
$signature = hash_hmac('sha256', $payload, $secret);

//if (!hash_equals('sha256=' . $signature, $headers['X-Hub-Signature-256'] ?? '')) {
//    http_response_code(403);
//    exit('Invalid signature');
//}

// Tiến hành pull code
$output = shell_exec('cd /var/www/FINAL-WEB && git pull 2>&1');

// Ghi log nếu cần
file_put_contents('/tmp/webhook.log', $output . PHP_EOL, FILE_APPEND);

// Composer install (tuỳ chọn)
shell_exec('cd /var/www/FINAL-WEB && composer install');
shell_exec('sudo systemctl reload apache2'); // nếu dùng Apache
echo "✅ Pull thành công!";
