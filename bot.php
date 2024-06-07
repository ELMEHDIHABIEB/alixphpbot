<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$botToken = getenv('TELEGRAM_BOT_TOKEN');
$chatId = getenv('TELEGRAM_CHAT_ID');
$client = new Client();

function sendMessage($client, $botToken, $chatId, $message) {
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $response = $client->post($url, [
        'form_params' => [
            'chat_id' => $chatId,
            'text' => $message
        ]
    ]);

    return $response;
}

$message = "Hello from PHP bot!";
$response = sendMessage($client, $botToken, $chatId, $message);
echo $response->getBody();
