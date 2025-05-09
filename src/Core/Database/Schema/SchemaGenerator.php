<?php

declare(strict_types=1);

namespace App\Core\Database\Schema;

use App\Core\Database\Attributes\Column;
use ReflectionClass;

/**
 * Class SchemaGenerator
 *
 * Generates a database schema from a model class.
 */
class SchemaGenerator
{
    /**
     * Generate a schema array from a model class.
     *
     * @param string $modelClass The fully qualified name of the model class.
     * @return array The generated schema.
     */
    public function generateFromModel(string $modelClass): array
    {
        $reflection = new ReflectionClass($modelClass);
        $schema = [
            'table' => $modelClass::getTableName(),
            'columns' => []
        ];

        foreach ($reflection->getProperties() as $property) {
            $attributes = $property->getAttributes(Column::class);
            if (!empty($attributes)) {
                $column = $attributes[0]->newInstance();
                $schema['columns'][$property->getName()] = [
                    'type' => $column->type,
                    'nullable' => $column->nullable,
                    'primary' => $column->primary,
                    'foreignKey' => $column->foreignKey
                ];
            }
        }

        return $schema;
    }
}
