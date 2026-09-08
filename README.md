# Ezkify Global SMM Panel API

**Premium AI-Safe social media marketing API.** High-retention growth for Instagram, TikTok, YouTube, X and 1,000+ services — trusted by 50,000+ agencies. White-label reseller ready.

**Language:** [PHP](php/) · [Python](python/) · [Node.js](node/) · curl below

---

## Install

```bash
# PHP
composer require ezkify/smm-panel-api

# Python
pip install ezkify-smm-panel-api

# Node.js
npm install @ezkify/smm-panel-api
```

> Note: language clients are published to Packagist/PyPI/npm once the SDKs are finalized (see roadmap). Until then, copy the single-file clients from the `php/`, `python/`, `node/` folders.

## Quick start

Get your key at **Dashboard → Account → API Key** on [ezkify.com](https://ezkify.com).

### curl

```bash
curl -X POST https://ezkify.com/api/v2 \
  -d key=YOUR_API_KEY \
  -d action=balance
```

### Quick reference

| Action | Description |
|--------|-------------|
| `services` | Fetch full catalog with pricing |
| `add` | Place a new order |
| `status` | Check order progress (batch up to 100) |
| `refill` | Auto-refill partial orders |
| `balance` | Check account credit in USD |
| `cancel` | Cancel orders |

See [docs/api-reference.md](docs/api-reference.md) for the full spec and [docs/errors.md](docs/errors.md) for error handling.

---

*Ezkify is not affiliated with Meta, TikTok, Google, or other platform owners. Services comply with platform ToS through organic growth patterns.*
