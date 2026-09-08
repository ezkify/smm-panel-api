# Ezkify Node.js Client

Official **Node.js** client for the [Ezkify Global SMM Panel API](https://ezkify.com).

```
npm install @ezkify/smm-panel-api
```

```js
const Ezkify = require('@ezkify/smm-panel-api');

const api = new Ezkify('YOUR_API_KEY');

const balance = await api.balance();
const order = await api.add(1, 'https://instagram.com/yourprofile', 1000);
```

Requires `axios`.
