#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import os
import json
from datetime import datetime
import openai
from junitparser import JUnitXml

# --- Настройка API-ключа ---
openai.api_key = os.getenv("OPENAI_API_KEY")

# --- Парсинг Pytest XML ---
def parse_pytest(xml_path):
    xml = JUnitXml.fromfile(xml_path)
    total    = sum(suite.tests    for suite in xml)
    failures = sum(suite.failures for suite in xml)
    errors   = sum(suite.errors   for suite in xml)
    skipped  = sum(suite.skipped  for suite in xml)
    passed   = total - failures - errors - skipped
    return {
        "total": total,
        "passed": passed,
        "failures": failures,
        "errors": errors,
        "skipped": skipped
    }

# --- Загрузка SonarCloud JSON ---
def load_sonar(sonar_path):
    return json.load(open(sonar_path, encoding="utf-8"))

# --- Загрузка ZAP JSON ---
def load_zap(zap_path):
    return json.load(open(zap_path, encoding="utf-8"))

# --- Сборка prompt ---
def build_prompt(pytest, sonar, zap):
    now = datetime.now().strftime("%d.%m.%Y %H:%M")
    repo = os.getenv("GITHUB_REPOSITORY")
    repo_url = f"https://github.com/{repo}"
    return f"""
Сформируй подробный отчет по результатам CI/CD анализа веб-приложения. У тебя есть три источника:

1. Результаты unit-тестирования Pytest в виде XML.
2. Отчет SonarCloud в формате JSON с анализом исходного кода.
3. Отчет OWASP ZAP в формате JSON с результатами сканирования веб-приложения.

📌 Заголовок:
Отчет по результатам CI/CD-пайплайна <a href="{repo_url}">{repo}</a>

📌 Структура:
1. Дата и время анализа: {now}
2. Результаты Pytest: общее количество тестов — {pytest["total"]}, пройдено — {pytest["passed"]}, провалено — {pytest["failures"]}, ошибок — {pytest["errors"]}, пропущено — {pytest["skipped"]}.
3. Проблемы кода по данным SonarCloud:
   - Покажи только MAJOR и CRITICAL ошибки.
   - Для каждой: правило, уровень серьезности, строка, сообщение, пояснение, пример кода (если есть).
   - Добавь комментарий SonarCloud и рекомендацию.
4. OWASP ZAP-алерты:
   - Выведи только High и Medium риски.
   - Для каждого: название, риск, количество инстансов, URL, параметр, метод, пример атаки, рекомендация.
   - Оберни каждую уязвимость в тег <details><summary>Название</summary><ul>…</ul></details>
5. Итоговое заключение:
   - Подведи итоги по всем найденным проблемам.
   - Перечисли ключевые проблемы безопасности, качества кода и конфигурации.
   - Дай конкретные рекомендации: что исправить в первую очередь, что улучшить по безопасности и качеству.

📌 Формат вывода:
HTML-страница со структурированными разделами и понятными подзаголовками. Используй теги <ul>, <li>, <code>, <div class="example">, <details>, <summary>.

📌 Язык: Русский.
"""

def main():
    # Пути к артефактам
    pytest_xml = "pytest_results.xml"
    sonar_json = "sonar-report.json"
    zap_json   = "zap_report.json"

    # Читаем данные
    pytest_summary = parse_pytest(pytest_xml)
    sonar_data     = load_sonar(sonar_json)
    zap_data       = load_zap(zap_json)

    # Формируем prompt
    prompt = build_prompt(pytest_summary, sonar_data, zap_data)

    # Вызываем API
    response = openai.ChatCompletion.create(
        model="gpt-4",
        messages=[{"role": "user", "content": prompt}],
        temperature=0.2,
    )

    # Пишем результат
    html = response.choices[0].message.content
    with open("gpt_report.html", "w", encoding="utf-8") as f:
        f.write(html)

if __name__ == "__main__":
    main()
