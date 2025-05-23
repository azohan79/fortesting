<?php
use PHPUnit\Framework\TestCase;

class IndexPageTest extends TestCase
{
    public function testHomePageLoadsSuccessfully()
    {
        $url = 'http://test.anywatt.es/';
        $context = stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => "User-Agent: PHPUnit-Test\r\n"
            ]
        ]);
        $content = @file_get_contents($url, false, $context);

        $this->assertNotFalse($content, "Главная страница не загрузилась.");
        $this->assertStringContainsString('<html', $content, "Ответ не содержит HTML-разметки.");
    }
}
