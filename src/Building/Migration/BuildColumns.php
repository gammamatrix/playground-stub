<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildColumns
 */
trait BuildColumns
{
    protected function buildClass_columns(): void
    {
        $columns = $this->model?->create()?->columns();
        if (! $columns) {
            return;
        }

        $this->searches['table_columns'] = PHP_EOL.PHP_EOL;

        $this->searches['table_columns'] .= sprintf(
            '%1$s// Columns',
            str_repeat(' ', 12)
        );

        $this->searches['table_columns'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_columns'] .= PHP_EOL;
        // }

        $i = 0;
        foreach ($columns as $column => $createColumn) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createColumn' => $createColumn,
            // ]);

            if (empty($createColumn->column()) || $createColumn->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createColumn->column(): %s] - group [%s]',
                    $column,
                    $createColumn->column(),
                    'table_columns'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_columns'
                ));

                continue;
            }

            $this->columns[] = $column;

            $this->searches['table_columns'] .= $this->buildClass_column(
                $column,
                $createColumn->properties(),
                'table_columns'
            );

            $i++;
        }
    }
}
