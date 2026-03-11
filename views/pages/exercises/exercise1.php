<?php

use App\Repository\ConfigExerciseRepository;

$exerciseId = 'exercise1';

$repository = new ConfigExerciseRepository();
$exercise   = $repository->find($exerciseId) ?? [];

$heading     = $exercise['title'] ?? 'Übung';
$initialCode = $exercise['initial_code'] ?? '';

require __DIR__ . '/../../components/php_exercise.php';