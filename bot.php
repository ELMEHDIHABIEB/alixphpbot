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
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]
    ]);

    return $response;
}

function sendPhoto($client, $botToken, $chatId, $photoUrl) {
    $url = "https://api.telegram.org/bot{$botToken}/sendPhoto";
    $response = $client->post($url, [
        'form_params' => [
            'chat_id' => $chatId,
            'photo' => $photoUrl,
            'caption' => 'Sample Image from Google'
        ]
    ]);

    return $response;
}

$message = "Hello World!";
$photoUrl = "https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png";

$responseMessage = sendMessage($client, $botToken, $chatId, $message);
$responsePhoto = sendPhoto($client, $botToken, $chatId, $photoUrl);

echo "Message response: " . $responseMessage->getBody();
echo "Photo response: " . $responsePhoto->getBody();
