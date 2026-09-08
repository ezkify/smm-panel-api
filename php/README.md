# Ezkify PHP Client

Official **PHP** client for the [Ezkify Global SMM Panel API](https://ezkify.com).

```
composer require ezkify/smm-panel-api
```

```php
use Ezkify\Client;

$api = new Client('YOUR_API_KEY');

// Check balance
$balance = $api->balance();

// Place an order
$order = $api->order([
    'service'  => 1,   // service ID from services()
    'link'     => 'https://instagram.com/yourprofile',
    'quantity' => 1000,
]);

// Check status
$status = $api->status($order->order);
```

**[Packagist](https://packagist.org/)** · Requires PHP >= 7.2, ext-curl.
