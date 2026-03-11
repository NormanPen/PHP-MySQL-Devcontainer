<?php

return [
    'title'          => 'Übung 1 – PHP-Eingabe',
    'initial_code'   => <<<'PHP'
<?php

function greet(string $name): string {
    return 'Hallo ' . $name;
}

$greeting = greet('Welt');
echo $greeting;

PHP,
    'expected_output' => "Hallo Welt",
    'checker'         => 'simple_output',
];
