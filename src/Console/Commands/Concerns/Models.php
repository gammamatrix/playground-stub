<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands\Concerns;

/**
 * \Playground\Stub\Console\Commands\Concerns\Models
 *
 * Order
 * {{ use_class }}{{ attributes }}{{ casts }}{{ fillable }}{{ perPage }}{{ table }}{{ HasOne }}{{ HasMany }}{{ scopes }}{{ filters }}
 */
trait Models
{
    protected function buildClass_perPage(): void
    {
        $perPage = 0;

        if (! empty($this->configuration['perPage'])
            && is_numeric($this->configuration['perPage'])
        ) {
            $perPage = intval(abs($this->configuration['perPage']));
        }

        $add_new_line = ! empty($this->searches['use_class'])
            || ! empty($this->searches['table']);

        if (! empty($perPage)) {

            $this->searches['perPage'] = $add_new_line ? PHP_EOL : '';

            $this->searches['perPage'] .= sprintf(
                '%1$s    protected $perPage = %2$d;',
                empty($this->searches['use_class']) ? '' : PHP_EOL,
                $perPage
            );
        } else {
            $this->searches['perPage'] = '';
        }
    }

    protected function buildClass_table(): void
    {
        $table = '';

        $this->searches['property_table'] = ! empty($this->searches['use_class']) ? PHP_EOL : '';

        if (! empty($this->configuration['table'])
            && is_string($this->configuration['table'])
        ) {
            $table = $this->configuration['table'];
        }

        if (! empty($table)) {
            $this->searches['table'] = $table;

            $this->searches['property_table'] = sprintf(
                '    protected $table = \'%1$s\';',
                $table
            );
            $this->searches['property_table'] .= PHP_EOL;
        } else {
            $this->searches['property_table'] = '';
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$config' => $config,
        //     // '$config_columns' => $config_columns,
        //     // '$this->configuration[table]' => $this->configuration['table'],
        //     // '$this->searches[table]' => $this->searches['table'],
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        // ]);
    }

    protected function buildClass_attributes(): void
    {
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$config' => $config,
        //     // '$config_columns' => $config_columns,
        //     // '$this->configuration[table]' => $this->configuration['table'],
        //     // '$this->searches[table]' => $this->searches['table'],
        //     '$this->configuration' => $this->configuration,
        //     '$this->searches' => $this->searches,
        // ]);
        if (empty($this->configuration['attributes'])
            || ! is_array($this->configuration['attributes'])
        ) {
            return;
        }

        if (! empty($this->searches['table'])) {
            $this->searches['attributes'] .= PHP_EOL;
        } elseif (! empty($this->configuration['uses']) && empty($this->searches['table'])) {
            $this->searches['attributes'] .= PHP_EOL;
        }

        $attributes = PHP_EOL;

        foreach ($this->configuration['attributes'] as $attribute => $value) {
            $attributes .= str_repeat(' ', 8);

            if (is_bool($value)) {
                $attributes .= sprintf('\'%1$s\' => %2$s,', $attribute, ($value ? 'true' : 'false'));
            } elseif (is_null($value)) {
                $attributes .= sprintf('\'%1$s\' => null,', $attribute);
            } elseif (is_numeric($value)) {
                $attributes .= sprintf('\'%1$s\' => %2$d,', $attribute, $value);
            } else {
                $attributes .= sprintf('\'%1$s\' => \'%2$s\',', $attribute, $value);
            }
            $attributes .= PHP_EOL;
        }

        $attributes .= str_repeat(' ', 4);

        $this->searches['attributes'] .= sprintf(
            '    protected $attributes = [%1$s];',
            $attributes
        );

        $this->searches['attributes'] .= PHP_EOL;
    }

    protected function buildClass_casts(): void
    {
        if (empty($this->configuration['casts'])
            || ! is_array($this->configuration['casts'])
        ) {
            return;
        }

        if (! empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        } elseif (! empty($this->searches['table']) && empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        } elseif (! empty($this->searches['use_class']) && empty($this->searches['table']) && empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        }

        $casts = PHP_EOL;

        foreach ($this->configuration['casts'] as $attribute => $cast) {
            $casts .= str_repeat(' ', 8);
            $casts .= sprintf('\'%1$s\' => \'%2$s\',', $attribute, $cast);
            $casts .= PHP_EOL;
        }

        $casts .= str_repeat(' ', 4);

        $this->searches['casts'] .= sprintf(
            '    protected $casts = [%1$s];',
            $casts
        );

        $this->searches['casts'] .= PHP_EOL;
    }

    protected function buildClass_fillable(): void
    {
        if (empty($this->configuration['fillable'])
            || ! is_array($this->configuration['fillable'])
        ) {
            return;
        }

        if (! empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['use_class']) && empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        }

        $fillable = PHP_EOL;

        foreach ($this->configuration['fillable'] as $attribute) {
            $fillable .= str_repeat(' ', 8);
            $fillable .= sprintf('\'%1$s\',', $attribute);
            $fillable .= PHP_EOL;
        }

        $fillable .= str_repeat(' ', 4);

        $this->searches['fillable'] .= sprintf(
            '    protected $fillable = [%1$s];',
            $fillable
        );

        $this->searches['fillable'] .= PHP_EOL;
    }
}
