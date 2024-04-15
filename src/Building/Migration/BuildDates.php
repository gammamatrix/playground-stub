<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildDates
 */
trait BuildDates
{
    protected function buildClass_dates(): void
    {
        $dates = $this->model?->create()?->dates();
        if (! $dates) {
            return;
        }

        $this->searches['table_dates'] .= PHP_EOL;

        $i = 0;
        foreach ($dates as $attribute => $createDate) {
            $column = '';

            $column .= sprintf(
                '%1$s%2$s$table->dateTime(\'%3$s\')',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute
            );

            if ($createDate->nullable()) {
                // $column .= '->nullable()->default(null)';
                $column .= '->nullable()';
            }

            if ($createDate->index()) {
                $column .= '->index()';
            }

            $column .= ';';

            $this->searches['table_dates'] .= $column;
            $i++;
        }
    }

    protected function buildClass_timestamps(): void
    {
        if (! $this->model?->create()?->timestamps()) {
            return;
        }

        $this->searches['table_timestamps'] = PHP_EOL.PHP_EOL;

        $this->searches['table_timestamps'] .= sprintf(
            '%1$s// Dates',
            str_repeat(' ', 12)
        );

        $this->searches['table_timestamps'] .= PHP_EOL.PHP_EOL;

        $this->searches['table_timestamps'] .= sprintf(
            '%1$s$table->timestamps();',
            str_repeat(' ', 12)
        );
    }

    protected function buildClass_softDeletes(): void
    {
        if (! $this->model?->create()?->softDeletes()) {
            return;
        }

        $this->searches['table_softDeletes'] = PHP_EOL.PHP_EOL;

        $this->searches['table_softDeletes'] .= sprintf(
            '%1$s$table->softDeletes();',
            str_repeat(' ', 12)
        );
    }
}
