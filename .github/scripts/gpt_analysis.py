#!/usr/bin/env python3
import os
import json
import datetime
import xml.etree.ElementTree as ET
from openai import OpenAI

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
    # only MAJOR and CRITICAL
    return [i for i in data.get("issues", []) if i["severity"] in ("MAJOR", "CRITICAL")]

def load_zap(zap_path):
    with open(zap_path, encoding="utf-8") as f:
        data = json.load(f)
    # only High and Medium
    return [a for a in data.get("alerts", []) if a.get("risk", "").lower() in ("high", "medium")]

def build_prompt(pytest_summary, sonar_issues, zap_alerts):
    now = datetime.datetime.now().strftime("%d.%m.%Y %H:%M")
    parts = []

    # Header & pytest
    parts.append(f"""
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
""")

    # Sonar issues
    for i in sonar_issues:
        parts.append(
            f"- Правило: `<code>{i['rule']}</code>` | Уровень: {i['severity']} | "
            f"Строка: {i['textRange']['startLine']}  \n"
            f"  Сообщение: {i['message']}  \n"
            f"  Теги: {', '.join(i.get('tags', [])) or '–'}  \n"
            f"  Рекомендация: {i.get('debt') and 'Уменьшить технический долг согласно SonarCloud'}\n\n"
        )

    # ZAP alerts
    parts.append("4. OWASP ZAP-алерты (High и Medium):\n")
    for a in zap_alerts:
        parts.append(
            "<details><summary>{}</summary>\n<ul>\n"
            "<li>Риск: {}</li>\n"
            "<li>URL: {}</li>\n"
            "<li>Параметр: {}</li>\n"
            "<li>Метод: {}</li>\n"
            "<li>Пример атаки: {}</li>\n"
            "<li>Рекомендация: {}</li>\n"
            "</ul>\n</details>\n"
            .format(
                a.get("alert"),
                a.get("risk"),
                a.get("url", "–"),
                a.get("param", "–"),
                a.get("method", "–"),
                a.get("evidence", "–"),
                a.get("solution", "–"),
            )
        )

    # Conclusion
    parts.append("""
5. Итоговое заключение:
- Подведи итоги по всем найденным проблемам.
- Перечисли ключевые проблемы безопасности, качества кода и конфигурации.
- Дай конкретные рекомендации: что исправить в первую очередь, что улучшить.
""")
    return "".join(parts)

def main():
    pytest_xml = "pytest_results.xml"
    sonar_json = "sonar-report.json"
    zap_json   = "zap_report.json"

    pytest_summary = parse_pytest(pytest_xml)
    sonar_issues   = load_sonar(sonar_json)
    zap_alerts     = load_zap(zap_json)

    prompt = build_prompt(pytest_summary, sonar_issues, zap_alerts)

    resp = client.chat.completions.create(
        model="gpt-4",
        messages=[{"role": "user", "content": prompt}],
        temperature=0.2,
    )

    html = resp.choices[0].message.content
    with open("gpt_report.html", "w", encoding="utf-8") as f:
        f.write(html)
    print("✅ gpt_report.html generated.")

if __name__ == "__main__":
    main()
