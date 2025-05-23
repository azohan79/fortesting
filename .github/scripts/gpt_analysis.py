import os
import json
from pathlib import Path
from junitparser import JUnitXml
from openai import OpenAI
from xml.etree.ElementTree import ParseError

TEST_XML_PATH = "pytest_results.xml"
SONAR_JSON_PATH = "sonar-report.json"
ZAP_JSON_PATH = "zap_report.json"
OUTPUT_PATH = "gpt_report.html"


def extract_pytest_summary(xml_path):
    path = Path(xml_path)
    if not path.exists() or path.stat().st_size == 0:
        return "<h2>Pytest Summary</h2><p>❌ No valid pytest results found.</p>", ""
    try:
        xml = JUnitXml.fromfile(xml_path)
        total = errors = failures = skips = 0
        for suite in xml:
            total += suite.tests
            errors += suite.errors
            failures += suite.failures
            skips += suite.skipped
        html = f"""
        <h2>Pytest Summary</h2>
        <ul>
            <li>Total: {total}</li>
            <li>Failures: {failures}</li>
            <li>Errors: {errors}</li>
            <li>Skipped: {skips}</li>
        </ul>
        """
        return html, f"Total={total}, Failures={failures}, Errors={errors}, Skipped={skips}"
    except ParseError:
        return "<h2>Pytest Summary</h2><p>❌ Failed to parse pytest_results.xml</p>", "ParseError"


def extract_zap_summary(zap_path):
    path = Path(zap_path)
    if not path.exists():
        return "<h2>ZAP Summary</h2><p>❌ zap_report.json not found.</p>", ""
    if path.stat().st_size == 0:
        return "<h2>ZAP Summary</h2><p>❌ zap_report.json is empty.</p>", ""
    try:
        with open(zap_path, "r") as f:
            data = json.load(f)
        alerts = data.get("site", [])[0].get("alerts", [])
        html = f"<h2>ZAP Alerts</h2><p>{len(alerts)} alerts found</p>"
        detail = ""
        for alert in alerts[:10]:
            html += f"""
            <details><summary>{alert['alert']} (Risk: {alert['riskdesc']})</summary>
            <ul>
                <li><strong>URL:</strong> {alert.get('url', 'N/A')}</li>
                <li><strong>Param:</strong> {alert.get('param', 'N/A')}</li>
                <li><strong>Evidence:</strong> {alert.get('evidence', 'N/A')}</li>
                <li><strong>Description:</strong> {alert.get('desc', 'N/A')}</li>
                <li><strong>Recommendation:</strong> {alert.get('solution', 'N/A')}</li>
            </ul></details>"""
            detail += f"\n- {alert['alert']} ({alert['riskdesc']}) @ {alert.get('url', '')}"
        return html, detail
    except Exception as e:
        return f"<h2>ZAP Summary</h2><p>❌ Error parsing ZAP: {e}</p>", "Error"


def extract_sonar_summary(sonar_path):
    path = Path(sonar_path)
    if not path.exists():
        return "<h2>SonarCloud Summary</h2><p>❌ sonar-report.json not found.</p>", ""
    try:
        with open(sonar_path, "r") as f:
            data = json.load(f)
        issues = data.get("issues", [])
        bugs = [i for i in issues if i.get("type") == "BUG"]
        vulns = [i for i in issues if i.get("type") == "VULNERABILITY"]
        smells = [i for i in issues if i.get("type") == "CODE_SMELL"]

        html = f"<h2>SonarCloud Summary</h2><ul><li>Bugs: {len(bugs)}</li><li>Vulnerabilities: {len(vulns)}</li><li>Code Smells: {len(smells)}</li></ul>"
        detail = ""
        for issue in issues[:10]:
            component = issue.get("component", "")
            message = issue.get("message", "")
            severity = issue.get("severity", "")
            line = issue.get("line", "")
            typ = issue.get("type", "")
            html += f"""
            <details><summary>{typ} ({severity}) in {component}:{line}</summary>
            <p>{message}</p>
            </details>"""
            detail += f"\n- {typ} [{severity}] {component}:{line} – {message}"
        return html, detail
    except Exception as e:
        return f"<h2>SonarCloud Summary</h2><p>❌ Error parsing SonarCloud report: {e}</p>", "Error"


def generate_gpt_report(context):
    client = OpenAI()
    system_prompt = "You are a senior security analyst. Analyze the following scan results and provide commentary with specific technical suggestions for improving the security and quality of the codebase."

    response = client.chat.completions.create(
        model="gpt-4",
        messages=[
            {"role": "system", "content": system_prompt},
            {"role": "user", "content": context},
        ]
    )
    return response.choices[0].message.content


def main():
    pytest_html, pytest_detail = extract_pytest_summary(TEST_XML_PATH)
    zap_html, zap_detail = extract_zap_summary(ZAP_JSON_PATH)
    sonar_html, sonar_detail = extract_sonar_summary(SONAR_JSON_PATH)

    base_html = f"""
    <html><head><meta charset='utf-8'><title>Security & QA Report</title></head><body>
    <h1>Security & Quality Analysis Report</h1>
    {pytest_html}
    {sonar_html}
    {zap_html}
    <hr><h2>AI-Assisted Summary</h2><p>Generating...</p>
    </body></html>
    """

    context = f"""
    PYTEST RESULTS:
    {pytest_detail}

    SONARCLOUD ISSUES:
    {sonar_detail}

    ZAP ALERTS:
    {zap_detail}
    """

    gpt_response = generate_gpt_report(context)
    full_html = base_html.replace("<p>Generating...</p>", f"<div>{gpt_response}</div>")

    with open(OUTPUT_PATH, "w") as f:
        f.write(full_html)
    print("✅ Enhanced GPT Report generated at", OUTPUT_PATH)


if __name__ == "__main__":
    main()
