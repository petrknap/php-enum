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
        ];
    }
}
