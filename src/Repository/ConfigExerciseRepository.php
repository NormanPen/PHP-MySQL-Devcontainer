<?php

namespace App\Repository;

class ConfigExerciseRepository implements ExerciseRepositoryInterface
{
    private string $configFile;

    public function __construct(?string $configFile = null)
    {
        $this->configFile = $configFile ?? __DIR__ . '/../../config/exercises.php';
    }

    public function find(string $id): ?array
    {
        if (!is_file($this->configFile)) {
            return null;
        }

        /** @var array<string, array> $exercises */
        $exercises = require $this->configFile;

        return $exercises[$id] ?? null;
    }
}
