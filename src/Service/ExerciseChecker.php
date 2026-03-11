<?php

namespace App\Service;

use App\Repository\ExerciseRepositoryInterface;

class ExerciseChecker
{
    private ExerciseRepositoryInterface $repository;

    public function __construct(ExerciseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function check(string $exerciseId, string $code, ?string $output): array
    {
        $exercise = $this->repository->find($exerciseId);

        if ($exercise === null) {
            return [
                'passed'  => false,
                'message' => 'Unbekannte Übung.',
            ];
        }

        $strategy = $exercise['checker'] ?? 'simple_output';

        if ($strategy === 'simple_output') {
            $expected = trim((string)($exercise['expected_output'] ?? ''));
            $actual   = trim((string)($output ?? ''));

            if ($expected === '') {
                return [
                    'passed'  => false,
                    'message' => 'Keine erwartete Ausgabe definiert.',
                ];
            }

            if ($actual === $expected) {
                return [
                    'passed'  => true,
                    'message' => 'Super, die Ausgabe stimmt genau mit der Erwartung überein.',
                ];
            }

            return [
                'passed'  => false,
                'message' => sprintf('Erwartet: "%s", erhalten: "%s"', $expected, $actual),
            ];
        }

        return [
            'passed'  => false,
            'message' => 'Keine bekannte Prüfstrategie für diese Übung.',
        ];
    }
}
