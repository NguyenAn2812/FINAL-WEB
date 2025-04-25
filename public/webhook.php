<?php
$secret = '2F4O1YBEYCC7YFH464YY6PF021Q2CRZY'; 

$headers = getallheaders();
$payload = file_get_contents('php://input');
$signature = hash_hmac('sha256', $payload, $secret);


$output = shell_exec('cd /var/www/FINAL-WEB && git pull 2>&1');

file_put_contents('/tmp/webhook.log', $output . PHP_EOL, FILE_APPEND);

shell_exec('cd /var/www/FINAL-WEB && composer install');
shell_exec('sudo systemctl reload apache2');
echo "Pull thành công!";
