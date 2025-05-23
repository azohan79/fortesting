
import requests

def test_site_responds_200():
    response = requests.get("http://test.anywatt.es", timeout=10)
    assert response.status_code == 200

