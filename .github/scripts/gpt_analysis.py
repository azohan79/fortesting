#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import json
import os
from openai import OpenAI
from junitparser import JUnitXml

def parse_pytest(xml_path):
    xml = JUnitXml.fromfile(xml_path)
    total    = sum(suite.tests    for suite in xml)
    failures = sum(suite.failures for suite in xml)
    errors   = sum(suite.errors   for suite in xml)
    skipped  = sum(suite.skipped  for suite in xml)
    return f"Total: {total}, Failures: {failures}, Errors: {errors}, Skipped: {skipped}"

def summarize_sonar(sonar_path, max_items=10):
    data = json.load(open(sonar_path, encoding='utf-8'))
    issues = data.get("issues", [])[:max_items]
    if not issues:
        return "Нет новых проблем."
    lines = []
    for i, iss in enumerate(issues, 1):
        rule = iss.get("rule")
        sev  = iss.get("severity")
        msg  = iss.get("message","").split("\n")[0]
        comp = iss.get("component","").split(":")[-1]
        lines.append(f"{i}. [{comp}] {rule} ({sev}): {msg}")
    return "\n".join(lines)

def summarize_zap(zap_json_path, max_items=10):
    data = json.load(open(zap_json_path, encoding='utf-8'))
    alerts = []
    for site in data.get("site", []):
        alerts.extend(site.get("alerts", []))
    alerts = alerts[:max_items]
    if not alerts:
        return "Уязвимости не найдены."
    lines = []
    for i, a in enumerate(alerts, 1):
        name = a.get("name", "N/A")
        risk = a.get("risk", "UNKNOWN")
        url  = a.get("uri", a.get("url", ""))
        lines.append(f"{i}. {name} (Risk: {risk}) — {url}")
    return "\n".join(lines)

def build_prompt(pytest_summary, sonar_summary, zap_summary):
    return f"""
<h2>1. Pytest Results</h2>
<pre>{pytest_summary}</pre>

<h2>2. SonarCloud Top Issues</h2>
<pre>{sonar_summary}</pre>

<h2>3. OWASP ZAP Top Alerts</h2>
<pre>{zap_summary}</pre>

<h2>4. Executive Summary and Prioritization</h2>
Сделайте краткий executive summary и приоритизацию исправлений в формате HTML.
"""

def main():
    pytest_xml = "pytest_results.xml"
    sonar_json = "sonar-report.json"
    zap_json   = "zap_report.json"

    pytest_summary = parse_pytest(pytest_xml)
    sonar_summary  = summarize_sonar(sonar_json)
    zap_summary    = summarize_zap(zap_json)

    prompt = build_prompt(pytest_summary, sonar_summary, zap_summary)

    client = OpenAI()
    response = client.chat.completions.create(
        model="gpt-4",           # <-- используем именно эту модель
        messages=[{"role":"user","content":prompt}],
        temperature=0.2,
    )

    report_html = response.choices[0].message.content

    with open("gpt_report.html", "w", encoding='utf-8') as f:
        f.write(report_html)

if __name__ == "__main__":
    main()
