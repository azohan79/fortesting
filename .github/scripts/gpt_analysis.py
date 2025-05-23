import os
import json
from openai import OpenAI
from junitparser import JUnitXml
from pathlib import Path
from xml.etree.ElementTree import ParseError

TEST_XML_PATH = "pytest_results.xml"
ZAP_REPORT_PATH = "zap_report.json"
SONAR_REPORT_PATH = "sonar-report.json"
OUTPUT_PATH = "gpt_report.html"


def extract_pytest_summary(xml_path):
    path = Path(xml_path)
    if not path.exists():
        return "<h2>Pytest</h2><p>❌ pytest_results.xml not found.</p>"
    try:
        xml = JUnitXml.fromfile(xml_path)
        total = sum(suite.tests for suite in xml)
        failures = sum(suite.failures for suite in xml)
        errors = sum(suite.errors for suite in xml)
        return f"<h2>Pytest</h2><ul><li>Total: {total}</li><li>Failures: {failures}</li><li>Errors: {errors}</li></ul>"
    except ParseError:
        return "<h2>Pytest</h2><p>❌ Failed to parse pytest_results.xml.</p>"


def extract_zap_summary(path):
    try:
        with open(path, "r", encoding="utf-8") as f:
            data = json.load(f)
        alerts = data.get("site", [])[0].get("alerts", [])
        html = f"<h2>ZAP Scan</h2><ul>"
        for alert in alerts[:10]:
            html += f"<li>{alert['alert']} - Risk: {alert['riskdesc']}</li>"
        html += "</ul>"
        return html
    except:
        return "<h2>ZAP Scan</h2><p>❌ Failed to load zap_report.json</p>"


def extract_sonar_issues(path):
    if not Path(path).exists():
        return "<h2>SonarCloud</h2><p>❌ sonar-report.json not found</p>"
    data = json.loads(Path(path).read_text())
    html = "<h2>SonarCloud</h2><ul>"
    for issue in data.get("issues", [])[:10]:
        html += f"<li><b>{issue['severity']}</b> in <code>{issue['component'].split(':')[-1]}</code> (line {issue.get('textRange', {}).get('startLine', '?')}): {issue['message']}</li>"
    html += "</ul>"
    return html


def generate_html_report():
    pytest = extract_pytest_summary(TEST_XML_PATH)
    zap = extract_zap_summary(ZAP_REPORT_PATH)
    sonar = extract_sonar_issues(SONAR_REPORT_PATH)

    html = f"""<html><head><meta charset="UTF-8"><title>CI QA Report</title></head><body>
    <h1>🔒 Automated QA Security Report</h1>
    {pytest}
    {sonar}
    {zap}
    </body></html>
    """
    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        f.write(html)
    print("✅ Report saved to", OUTPUT_PATH)


if __name__ == "__main__":
    generate_html_report()
