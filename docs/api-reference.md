# Ezkify API v2 – Full Reference

Official reference for all endpoints of the Ezkify Global API (v2).

**Base URL**  
`https://ezkify.com/api/v2`

**HTTP Method**  
`POST`

**Content-Type**  
`application/x-www-form-urlencoded`

**Authentication**  
Include your API key in every request:  
`key=YOUR_API_KEY`

All responses are JSON.

## Actions Overview

| Action          | Description                              | Main Parameters                     | Response Type          |
|-----------------|------------------------------------------|-------------------------------------|------------------------|
| `balance`       | Get account balance                      | —                                   | Object                 |
| `services`      | List all available services              | —                                   | Array of objects       |
| `add`           | Create new order                         | service, link, quantity, …          | Object (order ID)      |
| `status`        | Check status (single order)              | order                               | Object                 |
| `status`        | Check status (multiple orders)           | orders (comma-separated)            | Object (map)           |
| `refill`        | Request refill                           | order or orders                     | Object (refill ID)     |
| `refill_status` | Check refill status                      | refill or refills                   | Object or map          |
| `cancel`        | Cancel orders                            | orders (comma-separated)            | Object (map)           |

## Detailed Endpoints

### balance

**Parameters**  
- `key` (required)  
- `action=balance`

**Example Request**  
```
key=abc123def456
action=balance
```

**Success Response**  
```json
{
  "balance": "142.80",
  "currency": "USD"
}
```

### services

**Parameters**  
- `key` (required)  
- `action=services`

**Success Response**  
```json
[
  {
    "service": 142,
    "name": "Instagram - Premium Followers",
    "rate": "0.95",
    "min": "50",
    "max": "15000",
    "refill": true,
    "category": "Instagram"
  },
  {
    "service": 289,
    "name": "TikTok - Real Likes",
    "rate": "2.10",
    "min": "100",
    "max": "100000",
    "refill": false
  }
  // ... more services
]
```

### add (Place Order)

**Common Parameters**  
- `key` (required)  
- `action=add`  
- `service` (required) – service ID from `services`  
- `link` (usually required) – URL or username

**Type-specific parameters**

| Order Type            | Required / Common Fields                              | Notes                              |
|-----------------------|-------------------------------------------------------|------------------------------------|
| Default               | `quantity`                                            | Followers, likes, views            |
| Custom Comments       | `comments` (newline-separated)                        | `\n` between comments              |
| Package / Auto        | — (quantity taken from service package)               | No `quantity` needed               |
| Drip-feed / Subscription | `min`, `max`, `delay`, `posts`, `expiry`            | `expiry` format: MM/DD/YYYY        |
| Poll Votes            | `answer_number`                                       | Poll option index                  |

**Success Response**  
```json
{
  "order": 567890123
}
```

**Error Example**  
```json
{
  "error": "Quantity less than minimum"
}
```

### status (Single Order)

**Parameters**  
- `key`  
- `action=status`  
- `order` (required) – order ID

**Success Response**  
```json
{
  "status": "Completed",
  "remains": "0",
  "start_count": "1240",
  "charge": "1.85"
}
```

Possible `status` values:  
`Pending`, `In progress`, `Completed`, `Partial`, `Canceled`, `Processing`

### status (Multiple Orders)

**Parameters**  
- `action=status`  
- `orders` – comma-separated IDs (max ~100)

**Success Response**  
```json
{
  "567890123": {
    "status": "Partial",
    "remains": "450",
    "start_count": "550",
    "charge": "0.90"
  },
  "567890124": {
    "status": "Completed",
    "remains": "0",
    ...
  }
}
```

### refill & refill_status

**refill Parameters**  
- `action=refill`  
- `order` (single) **or** `orders` (comma-separated)

**Success Response**  
```json
{
  "refill": 901234
}
```

**refill_status Parameters**  
- `action=refill_status`  
- `refill` (single) **or** `refills` (comma-separated)

**Success Response**  
```json
{
  "status": "Completed"
}
```

### cancel

**Parameters**  
- `action=cancel`  
- `orders` – comma-separated IDs

**Success Response**  
```json
{
  "567890123": "Canceled",
  "567890124": "Already completed"
}
```

## Error Handling

All errors follow this format:

```json
{
  "error": "Error message here"
}
```

Common messages:
- `Invalid API key`
- `Invalid service`
- `Insufficient balance`
- `Invalid link`
- `Quantity less than minimum`
- `Quantity more than maximum`
- `Order not found`
- `Service is not available`

## See Also

- Working PHP client: [`/example.php`](../example.php)
- Common errors & fixes: [`errors.md`](errors.md)
- Usage examples: [`../examples/`](../examples/)

Questions? Contact support via your dashboard or Telegram.
