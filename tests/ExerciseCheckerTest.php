<?php

namespace App\Tests;

use App\Service\ExerciseChecker;
use App\Repository\ExerciseRepositoryInterface;
use PHPUnit\Framework\TestCase;

class ExerciseCheckerTest extends TestCase
{
    public function testReturnsErrorForUnknownExercise(): void
    {
        $repository = new class implements ExerciseRepositoryInterface {
            public function find(string $id): ?array
            {
                return null;
            }
        };

        $checker = new ExerciseChecker($repository);

        $result = $checker->check('unknown', '<?php echo "Hi";', 'Hi');

        $this->assertFalse($result['passed']);
        $this->assertSame('Unbekannte Übung.', $result['message']);
    }

    public function testSimpleOutputStrategyPassesOnExactMatch(): void
    {
        $repository = new class implements ExerciseRepositoryInterface {
            public function find(string $id): ?array
            {
                return [
                    'checker'         => 'simple_output',
                    'expected_output' => 'Hallo Welt',
                ];
            }
        };

        $checker = new ExerciseChecker($repository);

        $result = $checker->check('exercise1', '<?php echo "Hallo Welt";', "Hallo Welt\n");

        $this->assertTrue($result['passed']);
        $this->assertStringContainsString('Super, die Ausgabe stimmt genau', $result['message']);
    }

    public function testSimpleOutputStrategyFailsOnMismatch(): void
    {
        $repository = new class implements ExerciseRepositoryInterface {
            public function find(string $id): ?array
            {
                return [
                    'checker'         => 'simple_output',
                    'expected_output' => 'Hallo Welt',
                ];
            }
        };

        $checker = new ExerciseChecker($repository);

        $result = $checker->check('exercise1', '<?php echo "Hallo";', 'Hallo');

        $this->assertFalse($result['passed']);
        $this->assertStringContainsString('Erwartet: "Hallo Welt", erhalten: "Hallo"', $result['message']);
    }

    public function testSimpleOutputStrategyFailsWhenNoExpectedOutputDefined(): void
    {
        $repository = new class implements ExerciseRepositoryInterface {
            public function find(string $id): ?array
            {
                return [
                    'checker' => 'simple_output',
                ];
            }
        };

        $checker = new ExerciseChecker($repository);

        $result = $checker->check('exercise1', '<?php echo "Hallo";', 'Hallo');

        $this->assertFalse($result['passed']);
        $this->assertSame('Keine erwartete Ausgabe definiert.', $result['message']);
    }

    public function testUnknownStrategyReturnsError(): void
    {
        $repository = new class implements ExerciseRepositoryInterface {
            public function find(string $id): ?array
            {
                return [
                    'checker' => 'unknown_strategy',
                ];
            }
        };

        $checker = new ExerciseChecker($repository);

        $result = $checker->check('exercise1', '<?php echo "Hallo";', 'Hallo');

        $this->assertFalse($result['passed']);
        $this->assertSame('Keine bekannte Prüfstrategie für diese Übung.', $result['message']);
    }
}
