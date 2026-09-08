"""Ezkify SMM Panel API — Python usage example.

Run:  python examples/order_example.py
Get your key at https://ezkify.com/account
"""
import os
import sys

sys.path.insert(0, os.path.join(os.path.dirname(__file__), "..", "python"))
from ezkify_smm import Ezkify

api = Ezkify(os.environ.get("EZKIFY_API_KEY", "YOUR_API_KEY"))

balance = api.balance()
print(f"Balance: ${balance['balance']} {balance['currency']}")

order = api.add(service=1, link="https://instagram.com/yourprofile", quantity=1000)
print(f"Order ID: {order['order']}")

status = api.status(order["order"])
print(f"Status: {status['status']}")
