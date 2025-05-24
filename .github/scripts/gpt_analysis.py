#!/usr/bin/env python3
import os
import json
import datetime
import xml.etree.ElementTree as ET
from openai import OpenAI

# Initialize new OpenAI client
client = OpenAI()

def parse_pytest(xml_path):
    tree = ET.parse(xml_path)
    root = tree.getroot()
    total = int(root.attrib.get("tests", 0))
    failures = int(root.attrib.get("failures", 0))
    errors = int(root.attrib.get("errors", 0))
    skipped = int(root.attrib.get("skipped", 0))
    passed = total - failures - errors - skipped
    return {
        "total": total,
        "passed": passed,
        "failures": failures,
        "errors": errors,
        "skipped": skipped
    }

def load_sonar(sonar_path):
    with open(sonar_path, encoding="utf-8") as f:
        data = json.load(f)
    # filter only MAJOR|CRITICAL
    issues = [i for i in data.get("issues", []) if i["severity"] in ("MAJOR", "CRITICAL")]
    return issues

def load_zap(zap_path):
    with open(zap_path, encoding="utf-8") as f:
        data = json.load(f)
    # filter only High|Medium risk
    return [a for a in data.get("alerts", []) if a.get("risk").lower() in ("high", "medium")]

def build_prompt(pytest_summary, sonar_issues, zap_alerts):
    now = datetime.datetime.now().strftime("%d.%m.%Y %H:%M")
    return f"""
Сформируй подробный отчёт по результатам CI/CD анализа веб-приложения.

📌 Заголовок:
Отчет по результатам CI/CD-пайплайна "fortesting" (https://github.com/azohan79/fortesting)

1. Дата и время анализа: {now}

2. Результаты Pytest:
- Всего тестов: {pytest_summary["total"]}
- Пройдено: {pytest_summary["passed"]}
- Провалено: {pytest_summary["failures"]}
- Ошибок: {pytest_summary["errors"]}
- Пропущено: {pytest_summary["skipped"]}

3. Проблемы кода по данным SonarCloud (MAJOR и CRITICAL):
"""
    # list each sonar issue
    for i in sonar_issues:
        build = (
            f"- <code>{i['rule']}</code> | {i['severity']} | строка {i['textRange']['startLine']}  \n"
            f"  Сообщение: {i['message']}  \n"
            f"  Комментарий: {', '.join(i.get('tags', []))}  \n"
            f"  Рекомендация: Исправить согласно рекомендациям SonarCloud.\n"
        )
        build += "\n"
        yield build

    yield "\n4. OWASP ZAP-алерты (High и Medium):\n"
    for a in zap_alerts:
        part = (
            f"<details><summary>{a['alert']}</summary><ul>\n"
            f"<li>Риск: {a['risk']}</li>\n"
            f"<li>Количество: {a.get('instances', 1)}</li>\n"
            f"<li>URL: {a.get('url')}</li>\n"
            f"<li>Параметр: {a.get('param')}</li>\n"
            f"<li>Метод: {a.get('method')}</li>\n"
            f"<li>Пример атаки: {a.get('evidence')}</li>\n"
            f"<li>Рекомендация: {a.get('solution')}</li>\n"
            "</ul></details>\n"
        )
        yield part

    yield """
5. Итоговое заключение:
- Подведи итоги по всем найденным проблемам.
- Перечисли ключевые проблемы безопасности, качества кода и конфигурации.
- Дай конкретные рекомендации: что исправить в первую очередь, что улучшить.
"""

def main():
    # load all inputs
    pytest_xml   = "pytest_results.xml"
    sonar_json   = "sonar-report.json"
    zap_json     = "zap_report.json"

    pytest_summary = parse_pytest(pytest_xml)
    sonar_issues   = load_sonar(sonar_json)
    zap_alerts     = load_zap(zap_json)

    # assemble prompt
    prompt_parts = list(build_prompt(pytest_summary, sonar_issues, zap_alerts))
    full_prompt = "".join(prompt_parts)

    # call OpenAI
    resp = client.chat.completions.create(
        model="gpt-4",
        messages=[{"role":"user","content":full_prompt}],
        temperature=0.2
    )

    # write out HTML
    html = resp.choices[0].message.content
    with open("gpt_report.html", "w", encoding="utf-8") as f:
        f.write(html)
    print("✅ gpt_report.html generated.")

if __name__ == "__main__":
    main()
