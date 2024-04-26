<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildMatrix
 */
trait BuildMatrix
{
    protected function buildClass_matrix(): void
    {
        $matrix = $this->model?->create()?->matrix();
        if (! $matrix) {
            return;
        }

        $this->searches['table_matrix'] = PHP_EOL.PHP_EOL;

        $this->searches['table_matrix'] .= sprintf(
            '%1$s// Matrix',
            str_repeat(' ', 12)
        );

        $this->searches['table_matrix'] .= PHP_EOL;

        $i = 0;
        foreach ($matrix as $column => $createMatrix) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createMatrix->toArray()' => $createMatrix->toArray(),
            //     '$createMatrix->properties()' => $createMatrix->properties(),
            // ]);

            if (empty($createMatrix->column()) || $createMatrix->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createMatrix->column(): %s] - group [%s]',
                    $column,
                    $createMatrix->column(),
                    'table_matrix'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_matrix'
                ));

                continue;
            }

            $this->columns[] = $column;

            if (in_array($createMatrix->type(), [
                'JSON_OBJECT',
                'JSON_ARRAY',
            ])) {
                $this->searches['table_matrix'] .= $this->buildClass_json_column(
                    $column,
                    $createMatrix->properties(),
                    'table_matrix'
                );
            } else {
                $this->searches['table_matrix'] .= $this->buildClass_column(
                    $column,
                    $createMatrix->properties(),
                    'table_matrix'
                );
            }

            $i++;
        }
    }
}
