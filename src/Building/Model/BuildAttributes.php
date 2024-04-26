<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

/**
 * \Playground\Stub\Building\Model\BuildAttributes
 */
trait BuildAttributes
{
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
            // dump($attribute);
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
}
