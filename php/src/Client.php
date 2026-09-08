<?php

/**
 * Ezkify Global SMM Panel API — Official PHP Client
 *
 * Premium AI-Safe SMM Panel API. Instagram, TikTok, YouTube growth services
 * with high-retention delivery. Trusted by 50,000+ agencies.
 *
 * @see https://ezkify.com
 * @license MIT
 */

namespace Ezkify;

class Client
{
    /** API endpoint. */
    public string $apiUrl;

    /** API key from the Ezkify dashboard. */
    public string $apiKey;

    /**
     * @param string $apiKey  Your Ezkify API key.
     * @param string $apiUrl  API endpoint (defaults to production v2).
     */
    public function __construct(string $apiKey, string $apiUrl = 'https://ezkify.com/api/v2')
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    /** Fetch the full service catalog with pricing. */
    public function services(): object
    {
        return $this->request(['action' => 'services']);
    }

    /** Place a new order. */
    public function order(array $data): object
    {
        return $this->request(array_merge(['action' => 'add'], $data));
    }

    /** Get a single order status. */
    public function status(int $orderId): object
    {
        return $this->request(['action' => 'status', 'order' => $orderId]);
    }

    /** Get status for up to 100 orders. */
    public function multiStatus(array $orderIds): object
    {
        return $this->request(['action' => 'status', 'orders' => implode(',', $orderIds)]);
    }

    /** Trigger a refill for a partial order. */
    public function refill(int $orderId): object
    {
        return $this->request(['action' => 'refill', 'order' => $orderId]);
    }

    /** Get account balance. */
    public function balance(): object
    {
        return $this->request(['action' => 'balance']);
    }

    /** Cancel orders. */
    public function cancel(array $orderIds): object
    {
        return $this->request(['action' => 'cancel', 'orders' => implode(',', $orderIds)]);
    }

    /** Core request handler. */
    protected function request(array $payload): object
    {
        $payload = array_merge(['key' => $this->apiKey], $payload);

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $code     = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \RuntimeException('Ezkify API connection error: ' . $error);
        }

        $decoded = json_decode($response);
        if ($code >= 400) {
            throw new \RuntimeException('Ezkify API returned HTTP ' . $code . ': ' . $response);
        }

        return $decoded ?: (object) ['raw' => $response];
    }
}
