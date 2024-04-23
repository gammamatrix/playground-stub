<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Concerns;

/**
 * \Playground\Stub\Building\Concerns\BuildUses
 */
trait BuildUses
{
    protected function buildClass_uses(string $name): void
    {
        if (! method_exists($this->c, 'uses')) {
            return;
        }

        $use = '';
        $use_class = '';
        $this->searches['use'] = '';
        $this->searches['use_class'] = '';

        $extends_use = $this->c->extends_use();

        if (! empty($extends_use)) {
            $this->buildClass_uses_add($extends_use);
        }

        foreach ($this->c->uses() as $key => $value) {
            if (is_string($key)) {
                if ($key) {
                    $use_class .= sprintf(
                        '    use %2$s;%1$s',
                        PHP_EOL,
                        $key
                    );
                }
            }
            if ($value) {
                $use .= sprintf(
                    'use %2$s;%1$s',
                    PHP_EOL,
                    $this->parseClassInput($value)
                );
            }
        }

        if (! empty($use)) {
            $this->searches['use'] = PHP_EOL.trim($use).PHP_EOL;
        }
        if (! empty($use_class)) {
            $this->searches['use_class'] = '    '.trim($use_class).PHP_EOL;
        }
    }

    protected function buildClass_uses_add(string $use, string $use_class = ''): void
    {
        if (empty($use_class)) {
            if (method_exists($this->c, 'addToUse')) {
                $this->c->addToUse($this->parseClassConfig($use));
            }
            // if ($use && ! in_array($use, $this->configuration['uses'])) {
            //     // $this->configuration['uses'][] = ltrim($this->parseClassInput($use), '\\');
            //     // $this->configuration['uses'][] = $this->parseClassInput($use);
            //     $this->configuration['uses'][] = $this->parseClassConfig($use);
            // }
        } else {
            if (method_exists($this->c, 'addToUse')) {
                $this->c->addToUse($this->parseClassConfig($use), $use_class);
            }
            // if (! array_key_exists($use, $this->configuration['uses'])) {
            //     $this->configuration['uses'][$use_class] = ltrim($this->parseClassConfig($use), '/');
            //     $this->configuration['uses'][$use_class] = $this->parseClassInput($use);
            //     $this->configuration['uses'][$use_class] = $this->parseClassConfig($use);
            // }
        }
    }
}
