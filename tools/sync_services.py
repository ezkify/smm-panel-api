#!/usr/bin/env python3
"""
Ezkify service catalog sync.

Fetches the live service catalog from the Ezkify API and writes
docs/services.json so the repo always shows the current 1,000+ services
without manual maintenance.

Run with an API key:
    python3 tools/sync_services.py --key YOUR_API_KEY [--out docs/services.json]
"""
import argparse
import json
import os
import sys

import requests

API_URL = "https://ezkify.com/api/v2"


def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("--key", required=True, help="Ezkify API key")
    ap.add_argument("--out", default="docs/services.json")
    args = ap.parse_args()

    try:
        resp = requests.post(
            API_URL,
            data={"key": args.key, "action": "services"},
            timeout=60,
        )
        resp.raise_for_status()
        services = resp.json()
    except Exception as exc:  # pragma: no cover
        print(f"sync failed: {exc}", file=sys.stderr)
        return 1

    os.makedirs(os.path.dirname(args.out) or ".", exist_ok=True)
    with open(args.out, "w", encoding="utf-8") as fh:
        json.dump(
            {
                "generated_at": __import__("datetime").datetime.utcnow().isoformat() + "Z",
                "count": len(services) if isinstance(services, list) else None,
                "services": services,
            },
            fh,
            indent=2,
        )
    print(f"synced {len(services) if isinstance(services, list) else '?'} services -> {args.out}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
