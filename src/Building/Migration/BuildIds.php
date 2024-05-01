<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

use Playground\Stub\Configuration\Model\CreateId;

/**
 * \Playground\Stub\Building\Migration\BuildIds
 */
trait BuildIds
{
    protected function buildClass_ids(): void
    {
        $ids = $this->model?->create()?->ids();
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$ids' => $ids,
        // ]);
        if (! $ids) {
            return;
        }

        $this->searches['table_ids'] = PHP_EOL.PHP_EOL;

        $this->searches['table_ids'] .= sprintf(
            '%1$s// IDs',
            str_repeat(' ', 12)
        );

        $this->searches['table_ids'] .= PHP_EOL;

        $i = 0;
        foreach ($ids as $column => $createId) {
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createId' => $createId,
            // ]);

            if (empty($createId->column()) || $createId->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createId->column(): %s] - group [%s]',
                    $column,
                    $createId->column(),
                    'table_ids'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_ids'
                ));

                continue;
            }

            $this->columns[] = $column;

            $this->searches['table_ids'] .= $this->buildClass_column_id($createId);

            $i++;
        }
    }

    protected function buildClass_column_id(CreateId $createId): string
    {
        $column = sprintf(
            '%1$s%2$s$table->%3$s(\'%4$s\')',
            PHP_EOL,
            str_repeat(' ', 12),
            $createId->type() ?: 'string',
            $createId->column()
        );

        if ($createId->nullable()) {
            // $column .= '->nullable()->default(null)';
            $column .= '->nullable()';
        }

        if ($createId->hasDefault) {
            $default = $createId->default();
            if (is_null($default)) {
                $column .= '->default(null)';
            } elseif (is_bool($default)) {
                $column .= sprintf('->default(%1$d)', $default ? 1 : 0);
            } elseif (is_numeric($default)) {
                $column .= sprintf('->default(%1$d)', $default);
            } elseif (is_string($default)) {
                $column .= sprintf('->default(\'%1$s\')', $default);
            }
        }

        if ($createId->unsigned()) {
            $column .= '->unsigned()';
        }

        if ($createId->index()) {
            $column .= '->index()';
        }

        $column .= ';';

        return $column;
    }
}
