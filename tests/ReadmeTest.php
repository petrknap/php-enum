<?php declare(strict_types=1);

namespace PetrKnap\Enum;

use PetrKnap\Shorts\PhpUnit\MarkdownFileTestInterface;
use PetrKnap\Shorts\PhpUnit\MarkdownFileTestTrait;
use PHPUnit\Framework\TestCase;

class ReadmeTest extends TestCase implements MarkdownFileTestInterface
{
    use MarkdownFileTestTrait;

    public static function getPathToMarkdownFile(): string
    {
        return __DIR__ . '/../README.md';
    }

    public static function getExpectedOutputsOfPhpExamples(): iterable
    {
        $expect = static fn(int $i): string => file_get_contents(__DIR__ . "/Readme/output_{$i}.txt");
        return [
            'why-constants' => $expect(0),
            'why-enum' => $expect(1),
            'usage-declaration' => $expect(2),
            'usage-condition' => $expect(3),
            'usage-switch' => $expect(4),
            'usage-date' => $expect(5),
            'tips-mixed' => $expect(6),
            'tips-entity' => $expect(7),
        ];
    }
}
