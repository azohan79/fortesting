import requests

def test_main_page_status():
    response = requests.get("http://test.anywatt.es")
    assert response.status_code == 200


