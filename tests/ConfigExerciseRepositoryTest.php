<?php

namespace App\Tests;

use App\Repository\ConfigExerciseRepository;
use PHPUnit\Framework\TestCase;

class ConfigExerciseRepositoryTest extends TestCase
{
    public function testFindReturnsExerciseArrayWhenConfigExists(): void
    {
        $configFile = __DIR__ . '/fixtures/exercises_single.php';

        $repository = new ConfigExerciseRepository($configFile);

        $exercise = $repository->find('exercise1');

        $this->assertNotNull($exercise);
        $this->assertSame('Übung 1 – PHP-Eingabe', $exercise['title']);
        $this->assertSame('simple_output', $exercise['checker']);
        $this->assertSame('Hallo Welt', $exercise['expected_output']);
    }

    public function testFindReturnsNullWhenExerciseDoesNotExist(): void
    {
        $configFile = __DIR__ . '/fixtures/exercises_single.php';

        $repository = new ConfigExerciseRepository($configFile);

        $exercise = $repository->find('unknown');

        $this->assertNull($exercise);
    }

    public function testFindReturnsNullWhenConfigFileIsMissing(): void
    {
        $configFile = __DIR__ . '/fixtures/does_not_exist.php';

        $repository = new ConfigExerciseRepository($configFile);

        $exercise = $repository->find('exercise1');

        $this->assertNull($exercise);
    }
}
