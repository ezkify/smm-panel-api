/**
 * Ezkify Global SMM Panel API — Official Node.js Client
 *
 * Premium AI-Safe SMM panel. Instagram, TikTok, YouTube growth.
 */
const axios = require('axios');

const API_URL = 'https://ezkify.com/api/v2';

class Ezkify {
  constructor(apiKey, apiUrl = API_URL) {
    this.apiKey = apiKey;
    this.apiUrl = apiUrl;
  }

  async _request(action, params = {}) {
    const body = new URLSearchParams({ key: this.apiKey, action, ...params });
    const { data } = await axios.post(this.apiUrl, body.toString(), {
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    });
    return data;
  }

  services() {
    return this._request('services');
  }

  add(service, link, quantity = null) {
    const params = { service, link };
    if (quantity) params.quantity = quantity;
    return this._request('add', params);
  }

  status(order) {
    return this._request('status', { order });
  }

  balance() {
    return this._request('balance');
  }
}

module.exports = Ezkify;
