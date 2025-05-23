import requests
import os

token = os.getenv("SONAR_TOKEN")
project = "azohan79_fortesting"  # замените при необходимости
org = "azohan79"                 # замените при необходимости

url = f"https://sonarcloud.io/api/issues/search?organization={org}&componentKeys={project}&ps=500"
resp = requests.get(url, headers={"Authorization": f"Bearer {token}"})
resp.raise_for_status()

with open("sonar-report.json", "w") as f:
    f.write(resp.text)

print("✅ sonar-report.json saved.")
