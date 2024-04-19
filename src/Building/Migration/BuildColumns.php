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
    /**
     * @param array<string, mixed> $meta
     */
    protected function buildClass_column(string $attribute, array $meta, string $group): string
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$attribute' => $attribute,
        //     '$meta' => $meta,
        //     '$group' => $group,
        // ]);
        $allowed = [
            'uuid',
            'ulid',
            'string',
            'mediumText',
            'boolean',
            'integer',
            'bigInteger',
            'mediumInteger',
            'smallInteger',
            'tinyInteger',
            'dateTime',
            'decimal',
            'float',
            'double',
        ];

        $type = empty($meta['type']) || ! is_string($meta['type']) ? '' : $meta['type'];

        if (! $type || ! in_array($meta['type'], $allowed)) {
            $this->components->error(sprintf(
                '[%s]: Invalid column [%s] type: [%s] ',
                $group,
                $attribute,
                $type
            ));

            return sprintf(
                '%1$s%2$s// SKIPPED: invalid column [%3$s] type: %4$s',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute,
                $type
            );
        }

        if (in_array($type, [
            'decimal',
            'float',
            'double',
        ])) {
            $column = sprintf(
                '%1$s%2$s$table->%3$s(\'%4$s\', %5$d, %6$d)',
                PHP_EOL,
                str_repeat(' ', 12),
                $type,
                $attribute,
                empty($meta['precision']) || ! is_numeric($meta['precision']) || $meta['precision'] < 1 ? 8 : intval($meta['precision']),
                empty($meta['scale']) || ! is_numeric($meta['scale']) || $meta['scale'] < 1 ? 2 : intval($meta['scale'])
            );
        } else {
            $column = sprintf(
                '%1$s%2$s$table->%3$s(\'%4$s\')',
                PHP_EOL,
                str_repeat(' ', 12),
                $type,
                $attribute
            );
        }

        if (! empty($meta['nullable'])) {
            // $column .= '->nullable()->default(null)';
            $column .= '->nullable()';
        }

        if (array_key_exists('default', $meta)) {
            if (is_null($meta['default'])) {
                $column .= '->default(null)';
            } elseif (is_bool($meta['default'])) {
                $column .= sprintf('->default(%1$d)', $meta['default'] ? 1 : 0);
            } elseif (is_numeric($meta['default'])) {
                $column .= sprintf('->default(%1$d)', $meta['default']);
            } elseif (is_string($meta['default'])) {
                $column .= sprintf('->default(\'%1$s\')', $meta['default']);
            }
        }

        if (! empty($meta['unsigned'])) {
            $column .= '->unsigned()';
        }

        if (! empty($meta['index'])) {
            $column .= '->index()';
        }

        $column .= ';';

        return $column;
    }

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
