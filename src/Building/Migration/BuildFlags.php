<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\trait BuildFlags
 */
trait BuildFlags
{
    protected function buildClass_flags(): void
    {
        $flags = $this->model?->create()?->flags();
        if (! $flags) {
            return;
        }

        $this->searches['table_flags'] = PHP_EOL.PHP_EOL;

        $this->searches['table_flags'] .= sprintf(
            '%1$s// Flags',
            str_repeat(' ', 12)
        );

        $this->searches['table_flags'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_flags'] .= PHP_EOL;
        // }

        $i = 0;
        foreach ($flags as $column => $createFlag) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createFlag' => $createFlag,
            // ]);

            if (empty($createFlag->column()) || $createFlag->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createFlag->column(): %s] - group [%s]',
                    $column,
                    $createFlag->column(),
                    'table_flags'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_flags'
                ));

                continue;
            }

            $this->columns[] = $column;

            $this->searches['table_flags'] .= $this->buildClass_column(
                $column,
                $createFlag->properties(),
                'table_flags'
            );

            $i++;
        }
    }
}
