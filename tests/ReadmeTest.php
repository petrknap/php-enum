<?php declare(strict_types=1);

namespace PetrKnap\Enum\Test;

use PHPUnit\Framework\TestCase;
use function PetrKnap\Shorts\md_evaluate_example;
use function PetrKnap\Shorts\md_extract_examples;

class ReadmeTest extends TestCase
{
    /** @dataProvider dataExampleWorks */
    public function testExampleWorks(string $example, int $index)
    {
        $this->assertEquals(
            file_get_contents(__DIR__ . "/Readme/output_{$index}.txt"),
            md_evaluate_example($example)
        );
    }

    public function dataExampleWorks()
    {
        $i = 0;
        foreach (md_extract_examples(__DIR__ . '/../README.md') as $example) {
            yield $i => [$example, $i];
            $i++;
        }
    }
}
