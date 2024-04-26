<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildStatus
 */
trait BuildStatus
{
    protected function buildClass_status(): void
    {
        $status = $this->model?->create()?->status();
        if (! $status) {
            return;
        }

        $this->searches['table_status'] = PHP_EOL.PHP_EOL;

        $this->searches['table_status'] .= sprintf(
            '%1$s// Status',
            str_repeat(' ', 12)
        );

        $this->searches['table_status'] .= PHP_EOL;

        $i = 0;
        foreach ($status as $column => $createStatus) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createStatus->toArray()' => $createStatus->toArray(),
            //     '$createStatus->properties()' => $createStatus->properties(),
            // ]);

            if (empty($createStatus->column()) || $createStatus->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createStatus->column(): %s] - group [%s]',
                    $column,
                    $createStatus->column(),
                    'table_status'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_status'
                ));

                continue;
            }

            $this->columns[] = $column;

            $this->searches['table_status'] .= $this->buildClass_column(
                $column,
                $createStatus->properties(),
                'table_status'
            );

            $i++;
        }
    }
}
