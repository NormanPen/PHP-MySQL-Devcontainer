<?php

namespace App\Repository;

interface ExerciseRepositoryInterface
{
    /**
     * Liefert die Übungskonfiguration zur gegebenen ID
     * oder null, wenn keine Übung existiert.
     *
     * Struktur des Arrays entspricht einem Eintrag aus config/exercises.php.
     */
    public function find(string $id): ?array;
}
