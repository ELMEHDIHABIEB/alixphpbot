<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$botToken = getenv('TELEGRAM_BOT_TOKEN');
$chatId = getenv('TELEGRAM_CHAT_ID');
$client = new Client();

function getRandomProduct($client) {
    $url = "https://www.aliexpress.com/wholesale?catId=0&initiative_id=SB_20220101000000&SearchText=smartphone";
    $response = $client->get($url);
    $html = $response->getBody()->getContents();

    $crawler = new Crawler($html);
    $products = $crawler->filter('.manhattan--container--1lP57Ag');
    
    if ($products->count() == 0) {
        return null;
    }
    
    $randomIndex = rand(0, $products->count() - 1);
    $product = $products->eq($randomIndex);
    
    $productLink = "https:" . $product->filter('a')->attr('href');
    $productTitle = $product->filter('h1')->text();
    $productImage = $product->filter('img')->attr('src');
    
    return [
        'title' => $productTitle,
        'link' => $productLink,
        'image' => $productImage
    ];
}

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

$product = getRandomProduct($client);

if ($product) {
    $message = "*{$product['title']}*\n\nCheck it out [here]({$product['link']})!\n\n![Product Image]({$product['image']})";
    $response = sendMessage($client, $botToken, $chatId, $message);
    echo $response->getBody();
} else {
    echo "No products found.";
}
