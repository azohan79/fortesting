import os
import json
from openai import OpenAI
from junitparser import JUnitXml
from pathlib import Path
from xml.etree.ElementTree import ParseError

TEST_XML_PATH = "pytest_results.xml"
ZAP_REPORT_PATH = "zap_report.json"
OUTPUT_PATH = "gpt_report.html"


def extract_pytest_summary(xml_path):
    path = Path(xml_path)
    if not path.exists() or path.stat().st_size == 0:
        return "<h2>Pytest Summary</h2><p>❌ No valid pytest results found.</p>"
    try:
        xml = JUnitXml.fromfile(xml_path)
        total = errors = failures = skips = 0
        for suite in xml:
            total += suite.tests
            errors += suite.errors
            failures += suite.failures
            skips += suite.skipped
        return f"""
        <h2>Pytest Summary</h2>
        <ul>
            <li>Total: {total}</li>
            <li>Failures: {failures}</li>
            <li>Errors: {errors}</li>
            <li>Skipped: {skips}</li>
        </ul>
        """
    except ParseError:
        return "<h2>Pytest Summary</h2><p>❌ Failed to parse pytest_results.xml</p>"


def extract_zap_summary(zap_json_path):
    path = Path(zap_json_path)
    if not path.exists():
        return "<h2>ZAP Summary</h2><p>❌ zap_report.json not found.</p>"
    if path.stat().st_size == 0:
        return "<h2>ZAP Summary</h2><p>❌ zap_report.json is empty.</p>"
    try:
        with open(zap_json_path, 'r') as f:
            zap_data = json.load(f)
        alerts = zap_data.get("site", [])[0].get("alerts", [])
        summary = f"<h2>ZAP Alerts</h2><p>{len(alerts)} alerts found for http://test.anywatt.es</p><ul>"
        for alert in alerts:
            summary += f"<li>{alert['alert']} (Risk: {alert['riskdesc']})</li>"
        summary += "</ul>"
        return summary
    except json.JSONDecodeError:
        return "<h2>ZAP Summary</h2><p>❌ Failed to parse zap_report.json (invalid JSON).</p>"


def extract_sonar_summary():
    # TODO: Реальное чтение sonar-report.json при наличии
    return """
    <h2>SonarCloud Summary</h2>
    <ul>
        <li>Coverage: 78%</li>
        <li>Code Smells: 5</li>
        <li>Bugs: 2</li>
        <li>Vulnerabilities: 1</li>
    </ul>
    """


def generate_gpt_report(context):
    client = OpenAI()  # автоматически использует OPENAI_API_KEY
    system_prompt = (
        "You are a software quality and security analyst. "
        "Summarize and assess the following scan/test results. "
        "Provide a structured and concise report in valid HTML with recommended improvements."
    )

    response = client.chat.completions.create(
        model="gpt-4",
        messages=[
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": context},
        ]
    )
    return response.choices[0].message.content


def main():
    pytest_summary = extract_pytest_summary(TEST_XML_PATH)
    zap_summary = extract_zap_summary(ZAP_REPORT_PATH)
    sonar_summary = extract_sonar_summary()

    full_context = f"""
    <html>
    <head><meta charset='UTF-8'><title>Security & QA Report</title></head>
    <body>
        <h1>Automated Security & QA Analysis for http://test.anywatt.es</h1>
        {pytest_summary}
        {sonar_summary}
        {zap_summary}
    </body>
    </html>
    """

    report = generate_gpt_report(full_context)

    with open(OUTPUT_PATH, "w", encoding="utf-8") as f:
        f.write(report)
    print("✅ GPT HTML report generated: gpt_report.html")


if __name__ == "__main__":
    main()
