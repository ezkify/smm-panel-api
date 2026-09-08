"""Ezkify Global SMM Panel API — Official Python Client.

Premium AI-Safe SMM panel. Instagram, TikTok, YouTube growth services with
high-retention delivery. Trusted by 50,000+ agencies.

Install:  pip install ezkify-smm-panel-api
"""

import requests

API_URL = "https://ezkify.com/api/v2"


class Ezkify:
    """Thin client for the Ezkify API."""

    def __init__(self, api_key: str, api_url: str = API_URL):
        self.api_key = api_key
        self.api_url = api_url
        self.session = requests.Session()

    def _request(self, action: str, **params) -> dict:
        payload = {"key": self.api_key, "action": action, **params}
        resp = self.session.post(self.api_url, data=payload, timeout=60)
        resp.raise_for_status()
        return resp.json()

    def services(self) -> dict:
        """Fetch the full service catalog with pricing."""
        return self._request("services")

    def add(self, service: int, link: str, quantity: int | None = None, **extra) -> dict:
        """Place a new order."""
        data = {"service": service, "link": link}
        if quantity:
            data["quantity"] = quantity
        data.update(extra)
        return self._request("add", **data)

    def status(self, order: int) -> dict:
        """Get order status."""
        return self._request("status", order=order)

    def refill(self, order: int) -> dict:
        """Trigger a refill."""
        return self._request("refill", order=order)

    def balance(self) -> dict:
        """Get account balance."""
        return self._request("balance")


# Example usage
if __name__ == "__main__":
    api = Ezkify("YOUR_API_KEY")
    print(api.balance())
    print(api.services())
