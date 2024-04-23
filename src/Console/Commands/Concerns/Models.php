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
    protected function buildClass_table(): void
    {
        $table = $this->c->table();

        $this->searches['property_table'] = ! empty($this->searches['use_class']) ? PHP_EOL : '';

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
    }

    protected function buildClass_perPage(): void
    {
        $perPage = $this->c->perPage();

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

    protected function buildClass_attributes(): void
    {
        $attributes = $this->c->attributes();
        if (! $attributes) {
            return;
        }

        if (! empty($this->searches['table'])) {
            $this->searches['attributes'] .= PHP_EOL;
        } elseif (! empty($this->configuration['uses']) && empty($this->searches['table'])) {
            $this->searches['attributes'] .= PHP_EOL;
        }

        $code = PHP_EOL;

        foreach ($attributes as $attribute => $value) {
            $code .= str_repeat(' ', 8);

            if (is_bool($value)) {
                $code .= sprintf('\'%1$s\' => %2$s,', $attribute, ($value ? 'true' : 'false'));
            } elseif (is_null($value)) {
                $code .= sprintf('\'%1$s\' => null,', $attribute);
            } elseif (is_numeric($value)) {
                $code .= sprintf('\'%1$s\' => %2$d,', $attribute, $value);
            } elseif (is_string($value)) {
                $code .= sprintf('\'%1$s\' => \'%2$s\',', $attribute, $value);
            }
            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['attributes'] .= sprintf('    /**
     * The default values for attributes.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [%1$s];',
            $code
        );

        $this->searches['attributes'] .= PHP_EOL;
    }

    protected function buildClass_casts(): void
    {
        if (! $this->c->casts()) {
            return;
        }

        if (! empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        } elseif (! empty($this->searches['table']) && empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        } elseif (! empty($this->searches['use_class']) && empty($this->searches['table']) && empty($this->searches['attributes'])) {
            $this->searches['casts'] .= PHP_EOL;
        }

        $code = PHP_EOL;

        foreach ($this->c->casts() as $attribute => $cast) {
            $code .= str_repeat(' ', 12);
            $code .= sprintf('\'%1$s\' => \'%2$s\',', $attribute, (is_string($cast) ? $cast : ''));
            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 8);

        $this->searches['casts'] .= sprintf('    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [%1$s];
    }',
            $code
        );

        $this->searches['casts'] .= PHP_EOL;
    }

    protected function buildClass_fillable(): void
    {
        $fillable = $this->c->fillable();
        if (! $fillable) {
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

        $code = PHP_EOL;

        foreach ($fillable as $attribute) {
            $code .= str_repeat(' ', 8);
            $code .= sprintf('\'%1$s\',', $attribute);
            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['fillable'] .= sprintf('    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [%1$s];',
            $code
        );

        $this->searches['fillable'] .= PHP_EOL;
    }
}
