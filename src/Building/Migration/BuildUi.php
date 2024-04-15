<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildUi
 */
trait BuildUi
{
    protected function buildClass_ui(): void
    {
        $ui = $this->model?->create()?->ui();
        if (! $ui) {
            return;
        }

        $this->searches['table_ui'] = PHP_EOL.PHP_EOL;

        $this->searches['table_ui'] .= sprintf(
            '%1$s// Ui',
            str_repeat(' ', 12)
        );

        $this->searches['table_ui'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_ui'] .= PHP_EOL;
        // }

        $i = 0;
        foreach ($ui as $column => $createUi) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createUi' => $createUi,
            // ]);

            if (empty($createUi->column()) || $createUi->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createUi->column(): %s] - group [%s]',
                    $column,
                    $createUi->column(),
                    'table_ui'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_ui'
                ));

                continue;
            }

            $this->columns[] = $column;

            if (in_array($createUi->type(), [
                'JSON_OBJECT',
                'JSON_ARRAY',
            ])) {
                $this->searches['table_ui'] .= $this->buildClass_json_column(
                    $column,
                    $createUi->properties(),
                    'table_ui'
                );
            } else {
                $this->searches['table_ui'] .= $this->buildClass_column(
                    $column,
                    $createUi->properties(),
                    'table_ui'
                );
            }

            $i++;
        }
    }
}
