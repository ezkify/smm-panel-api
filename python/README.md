# Ezkify Python Client

Official **Python** client for the [Ezkify Global SMM Panel API](https://ezkify.com).

```
pip install ezkify-smm-panel-api
```

```python
from ezkify_smm import Ezkify

api = Ezkify("YOUR_API_KEY")

balance = api.balance()
services = api.services()
order = api.add(service=1, link="https://instagram.com/yourprofile", quantity=1000)
```

Requires `requests`.
