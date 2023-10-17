<?php declare(strict_types=1);

namespace PetrKnap\Shorts;

function array_key_map(callable $callback, array $array, mixed $key, array ...$keys): array
{
    foreach ([$key] + $keys as $k) {
        $array[$k] = $callback($array[$k] ?? null, $k);
    }

    return $array;
}

function md_extract_examples(string $path): iterable
{
    $readme = file_get_contents($path);
    $examples = explode('```', $readme);
    for ($i = 1; $i < count($examples); $i += 2) {
        list($language, $example) = explode(PHP_EOL, $examples[$i], 2);
        if ($language === 'php') {
            yield $example;
        }
    }
}

function md_evaluate_example(string $example): string
{
    ob_start();
    eval($example);
    return ob_get_clean();
}
