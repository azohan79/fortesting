#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import json
import openai
import os
from junitparser import JUnitXml

# 1) Настройка API-ключа
openai.api_key = os.getenv("OPENAI_API_KEY")

def load_text(path):
    with open(path, encoding='utf-8') as f:
        return f.read()

def parse_pytest(xml_path):
    xml = JUnitXml.fromfile(xml_path)
    total = sum(suite.testsuite_tests for suite in xml)
    failures = sum(suite.testsuite_failures for suite in xml)
    errors = sum(suite.testsuite_errors for suite in xml)
    skipped = sum(suite.testsuite_skipped for suite in xml)
    return f"Total: {total}, Failures: {failures}, Errors: {errors}, Skipped: {skipped}"

def summarize_sonar(sonar_path, max_items=10):
    data = json.load(open(sonar_path, encoding='utf-8'))
    issues = data.get("issues", [])[:max_items]
    lines = []
    for i, iss in enumerate(issues, 1):
        lines.append(f"{i}. {iss['rule']} ({iss['severity']}): {iss.get('message','')}")
    return "\n".join(lines) or "Нет новых проблем."

def build_prompt(pytest_summary, sonar_summary, zap_html):
    return f"""
You are a senior Security QA engineer. Generate a full HTML report with sections:

<h1>1. Pytest Results</h1>
<pre>{pytest_summary}</pre>

<h1>2. SonarCloud Analysis</h1>
<pre>
{sonar_summary}
</pre>

<h1>3. OWASP ZAP Findings</h1>
Please parse this HTML and list each finding with its risk and recommendation:
<details><summary>ZAP Report HTML</summary>
{zap_html}
</details>

<h1>4. AI-Assisted Summary & Recommendations</h1>
Provide a concise executive summary and prioritized next steps.
"""

def main():
    # Пути к файлам в рабочей директории
    pytest_xml = "pytest_results.xml"
    sonar_json = "sonar-report.json"
    zap_html   = "zap_report.html"

    # Загружаем и парсим
    pytest_summary = parse_pytest(pytest_xml)
    sonar_summary  = summarize_sonar(sonar_json)
    zap_content    = load_text(zap_html)

    prompt = build_prompt(pytest_summary, sonar_summary, zap_content)

    response = openai.ChatCompletion.create(
        model="gpt-4o-mini",
        messages=[{"role":"user","content":prompt}],
        temperature=0.2,
    )

    report_html = response.choices[0].message.content

    # Сохраняем итоговый HTML
    with open("gpt_report.html", "w", encoding='utf-8') as f:
        f.write(report_html)

if __name__ == "__main__":
    main()
