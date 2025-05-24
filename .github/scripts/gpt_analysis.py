#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import json
import os
from openai import OpenAI
from junitparser import JUnitXml

def load_text(path):
    with open(path, encoding='utf-8') as f:
        return f.read()

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
        lines.append(f"{i}. {iss['rule']} ({iss['severity']}): {iss.get('message','')}")
    return "\n".join(lines)

def summarize_zap(zap_json_path, max_items=10):
    data = json.load(open(zap_json_path, encoding='utf-8'))
    alerts = data.get("alerts", [])[:max_items]
    if not alerts:
        return "Уязвимости не найдены."
    lines = []
    for i, a in enumerate(alerts, 1):
        name = a.get("name", "N/A")
        risk = a.get("risk", "UNKNOWN")
        url  = a.get("url", "")
        lines.append(f"{i}. {name} (Risk: {risk}) — {url}")
    return "\n".join(lines)

def build_prompt(pytest_summary, sonar_summary, zap_summary):
    return f"""
<h1>1. Pytest Results</h1>
<pre>{pytest_summary}</pre>

<h1>2. SonarCloud Analysis</h1>
<pre>{sonar_summary}</pre>

<h1>3. OWASP ZAP Summary (top 10)</h1>
<pre>{zap_summary}</pre>

<h1>4. AI-Assisted Summary & Recommendations</h1>
Сделайте краткий executive summary и приоритизацию исправлений.
"""

def main():
    # Пути к артефактам
    pytest_xml   = "pytest_results.xml"
    sonar_json   = "sonar-report.json"
    zap_json     = "zap_report.json"

    # Парсим
    pytest_summary = parse_pytest(pytest_xml)
    sonar_summary  = summarize_sonar(sonar_json)
    zap_summary    = summarize_zap(zap_json)

    # Собираем промпт
    prompt = build_prompt(pytest_summary, sonar_summary, zap_summary)

    # Инициализируем клиента
    client = OpenAI()

    # Отправляем запрос
    response = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[{"role":"user","content":prompt}],
        temperature=0.2,
    )

    # Получаем HTML из ответа
    report_html = response.choices[0].message.content

    # Сохраняем результат
    with open("gpt_report.html", "w", encoding='utf-8') as f:
        f.write(report_html)

if __name__ == "__main__":
    main()
