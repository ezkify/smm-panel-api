<?php
/**
 * Ezkify SMM Panel API — PHP usage example
 *
 * Run:  php examples/order-example.php
 * Get your key at https://ezkify.com/account
 */

require_once __DIR__ . '/../php/src/Client.php';

use Ezkify\Client;

$api = new Client(getenv('EZKIFY_API_KEY') ?: 'YOUR_API_KEY');

// 1. Balance
$balance = $api->balance();
echo "Balance: \${$balance->balance} {$balance->currency}\n";

// 2. Place an order
$order = $api->order([
    'service'  => 1,   // use a real service ID from services()
    'link'     => 'https://instagram.com/yourprofile',
    'quantity' => 1000,
]);
echo "Order ID: {$order->order}\n";

// 3. Status
$status = $api->status($order->order);
echo "Status: {$status->status}\n";
