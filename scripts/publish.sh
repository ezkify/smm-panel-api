#!/usr/bin/env bash
# Publish all Ezkify SMM Panel API SDKs to their package registries.
# Run from the repo root. Requires registry auth to be pre-configured:
#   npm   : npm login (publish scope @ezkify)
#   PyPI  : ~/.pypirc  or  export TWINE_USERNAME / TWINE_PASSWORD
#   Packagist : export PACKAGIST_API_TOKEN  (https://packagist.org/profile/api-tokens)
set -euo pipefail

VERSION=$(git describe --tags --abbrev=0 2>/dev/null || echo "1.0.0")
echo "==> Publishing $VERSION"

# --- Node.js (npm) ---------------------------------------------------------
if command -v npm >/dev/null; then
  echo "==> npm (node/): @ezkify/smm-panel-api@$VERSION"
  (cd node && npm publish --access public)
else
  echo "!! npm not found, skipping Node publish"
fi

# --- Python (PyPI via twine) ------------------------------------------------
if command -v python3 >/dev/null && command -v twine >/dev/null; then
  echo "==> PyPI (python/): ezkify-smm-panel-api@$VERSION"
  (cd python && python3 -m build && twine upload dist/*)
elif command -v python3 >/dev/null; then
  echo "!! twine not installed; run:  pip install build twine  then re-run"
fi

# --- PHP (Packagist) ---------------------------------------------------------
if [ -n "${PACKAGIST_API_TOKEN:-}" ]; then
  echo "==> Packagist (php/): ezkify/smm-panel-api@$VERSION"
  curl -sS -X POST -H "Content-Type: application/json" \
    -H "Authorization: Bearer $PACKAGIST_API_TOKEN" \
    -d '{"repository":{"url":"https://repo.packagist.org/p2/ezkify/smm-panel-api.json","display_name":"ezkify/smm-panel-api"}}' \
    https://packagist.org/api/packages -o /dev/null
  echo "   (Packagist update pinged; verify at https://packagist.org/packages/ezkify/smm-panel-api)"
else
  echo "!! PACKAGIST_API_TOKEN not set; add the GitHub->Packagist webhook or run Packagist API update manually"
fi

echo "==> Done. Follow each registry's confirmation URL."