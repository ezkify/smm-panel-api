# Common API Errors & Solutions

This document lists the most frequent error messages returned by the Ezkify API v2, their meanings, and practical ways to resolve them.

All error responses follow this format:

```json
{
  "error": "Error message text"
}
```

## Error List

| Error Message                        | Meaning                                           | Common Causes                                      | How to Fix                                                                 |
|--------------------------------------|---------------------------------------------------|----------------------------------------------------|----------------------------------------------------------------------------|
| `Invalid API key`                    | The provided API key is incorrect or expired      | Typo, key revoked, wrong account                   | Verify key in dashboard → regenerate if needed                             |
| `Invalid service`                    | The service ID does not exist                     | Wrong ID used, service removed                     | Call `action=services` and use a valid service ID                          |
| `Insufficient balance`               | Account does not have enough funds                | Balance too low for order amount + fees            | Top up account via dashboard                                               |
| `Invalid link`                       | Link/URL format is incorrect                      | Missing https://, wrong username, invalid post ID  | Use full valid URL or correct username format                              |
| `Quantity less than minimum`         | Ordered quantity below service minimum            | Quantity < service.min                             | Increase quantity or choose different service                              |
| `Quantity more than maximum`         | Ordered quantity exceeds service maximum          | Quantity > service.max                             | Decrease quantity or choose different service                              |
| `Order not found`                    | The specified order ID does not exist             | Wrong ID, order deleted/canceled                   | Double-check order ID; use `status` only on valid orders                   |
| `Service is not available`           | Service is temporarily disabled                   | Maintenance, out of stock, restricted              | Try again later or select another similar service                          |
| `Already completed`                  | Order cannot be canceled/refilled (already done)  | Attempting action on finished order                | No action possible – order is final                                        |
| `Already refunded`                   | Order was refunded – no further actions allowed   | Previous refund processed                          | No action possible                                                         |
| `Invalid comments`                   | Comments format incorrect (custom comments order) | Empty, too long, bad characters                    | Ensure comments are newline-separated and within limits                    |
| `Invalid parameters`                 | Missing or wrong combination of parameters        | Required field missing for order type              | Check required fields for your order type (see api-reference.md)           |

## Best Practices to Avoid Errors

1. Always call `action=services` first to get current service IDs, min/max, rates.
2. Validate `quantity` against `min` and `max` before placing order.
3. Check `balance` before submitting large orders.
4. Use correct link format:
   - Followers: `https://instagram.com/username`
   - Post engagement: `https://instagram.com/p/POST_ID/`
5. Implement error checking in your code:

   ```php
   $response = $api->order([...]);
   if (isset($response->error)) {
       // handle error
       echo "API Error: " . $response->error;
       return;
   }
   ```

6. For batch operations (`multiStatus`, `multiRefill`, `cancel`), check each result individually as some may succeed while others fail.

## Debugging Tips

- Log the full POST data and response for every request.
- Test small orders first (minimum quantity).
- Use `action=balance` frequently in development.
- If issue persists → contact support with:
  - Your API key (via private message)
  - Exact request parameters
  - Full error response
  - Order ID (if applicable)

For more technical details see:  
- [`api-reference.md`](api-reference.md)  
- [`../example.php`](../example.php)

Last updated: 2025
```
