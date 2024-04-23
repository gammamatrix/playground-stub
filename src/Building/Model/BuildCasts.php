<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

/**
 * \Playground\Stub\Building\Model\BuildCasts
 */
trait BuildCasts
{
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
}
