<?php

declare(strict_types=1);

namespace App\Core\Model;

/**
 * Interface ModelInterface
 *
 * This interface defines the contract that any model should implement.
 *
 * @package App\Models
 */
interface ModelInterface
{
    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string;

    /**
     * Get the ID of the model.
     *
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * Convert the model to an array representation.
     *
     * @return array
     */
    public function toArray(): array;
}
