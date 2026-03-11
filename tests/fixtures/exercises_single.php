<?php

return [
    'exercise1' => [
        'title'           => 'Übung 1 – PHP-Eingabe',
        'initial_code'    => <<<'PHP'
<?php

echo 'Hallo Welt';

PHP,
        'expected_output' => 'Hallo Welt',
        'checker'         => 'simple_output',
    ],
];
