#!/usr/bin/env python3
import os
import json
import datetime
import xml.etree.ElementTree as ET
from openai import OpenAI

# Имена моделей можно менять через переменную окружения OPENAI_MODEL
MODEL = os.getenv("OPENAI_MODEL", "gpt-3.5-turbo")
client = OpenAI()

def parse_pytest(xml_path):
    tree = ET.parse(xml_path)
    root = tree.getroot()
    total   = int(root.attrib.get("tests", 0))
    failures= int(root.attrib.get("failures", 0))
    errors  = int(root.attrib.get("errors", 0))
    skipped = int(root.attrib.get("skipped", 0))
    passed  = total - failures - errors - skipped
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
    # фильтруем только MAJOR и CRITICAL
    return [
        issue for issue in data.get("issues", [])
        if issue["severity"] in ("MAJOR", "CRITICAL")
    ]

def load_zap(zap_path):
    with open(zap_path, encoding="utf-8") as f:
        data = json.load(f)
    # фильтруем только High и Medium
    return [
        alert for alert in data.get("alerts", [])
        if alert.get("risk", "").lower() in ("high", "medium")
    ]

def build_prompt(pytest_summary, sonar_issues, zap_alerts):
    now = datetime.datetime.now().strftime("%d.%m.%Y %H:%M")
    parts = []

    # 1. Header & pytest summary
    parts.append(f"""
Сформируй подробный отчёт по результатам CI/CD анализа веб-приложения.

📌 Отчет по результатам CI/CD-пайплайна "fortesting" (https://github.com/azohan79/fortesting)

1. Дата и время анализа: {now}

2. Результаты Pytest:
- Всего тестов: {pytest_summary["total"]}
- Пройдено: {pytest_summary["passed"]}
- Провалено: {pytest_summary["failures"]}
- Ошибок: {pytest_summary["errors"]}
- Пропущено: {pytest_summary["skipped"]}

3. Проблемы кода по данным SonarCloud (MAJOR и CRITICAL):
""")

    # 2. Sonar issues — только первые 10
    MAX_SONAR = 10
    top_sonar = sonar_issues[:MAX_SONAR]
    parts.append(f"Найдено {len(sonar_issues)} проблем MAJOR/CRITICAL, показаны первые {len(top_sonar)}:\n")
    for i in top_sonar:
        parts.append(
            f"- Правило: `<code>{i['rule']}</code>` | Уровень: {i['severity']} | "
            f"Строка: {i['textRange']['startLine']}  \n"
            f"  Сообщение: {i['message']}  \n"
            f"  Теги: {', '.join(i.get('tags', [])) or '–'}  \n"
            f"  Рекомендация: Проверьте документацию по правилу {i['rule']} на sonarcloud.io\n\n"
        )
    if len(sonar_issues) > MAX_SONAR:
        parts.append(f"... и ещё {len(sonar_issues)-MAX_SONAR} подобных проблем опущено для краткости\n\n")

    # 3. ZAP alerts — только топ-5 по риску
    parts.append(f"4. OWASP ZAP-алерты (High/Medium), показаны 5 самых рискованных из {len(zap_alerts)}:\n")
    top_zap = sorted(zap_alerts, key=lambda a: a.get("risk"), reverse=True)[:5]
    for a in top_zap:
        parts.append(
            f"<details><summary>{a.get('alert')}</summary>\n"
            "<ul>\n"
            f"  <li>Риск: {a.get('risk')}</li>\n"
            f"  <li>URL: {a.get('url', '–')}</li>\n"
            f"  <li>Параметр: {a.get('param', '–')}</li>\n"
            f"  <li>Метод: {a.get('method', '–')}</li>\n"
            f"  <li>Пример атаки (evidence): <code>{a.get('evidence', '–')}</code></li>\n"
            f"  <li>Рекомендация: {a.get('solution', '–')}</li>\n"
            "</ul>\n"
            "</details>\n\n"
        )
    if len(zap_alerts) > 5:
        parts.append(f"... и ещё {len(zap_alerts)-5} алертов опущено для краткости\n\n")

    # 4. Conclusion
    parts.append("""
5. Итоговое заключение:
- Подведите итоги по всем найденным проблемам.
- Перечислите ключевые проблемы безопасности, качества кода и конфигурации.
- Дайте конкретные рекомендации: что исправить в первую очередь, что улучшить.
""")
    return "".join(parts)

def main():
    pytest_xml  = "pytest_results.xml"
    sonar_json  = "sonar-report.json"
    zap_json    = "zap_report.json"

    pytest_summary = parse_pytest(pytest_xml)
    sonar_issues   = load_sonar(sonar_json)
    zap_alerts     = load_zap(zap_json)

    prompt = build_prompt(pytest_summary, sonar_issues, zap_alerts)

    resp = client.chat.completions.create(
        model=MODEL,
        messages=[{"role": "user", "content": prompt}],
        temperature=0.2,
    )

    html = resp.choices[0].message.content
    with open("gpt_report.html", "w", encoding="utf-8") as f:
        f.write(html)

    print("✅ gpt_report.html generated.")

if __name__ == "__main__":
    main()
