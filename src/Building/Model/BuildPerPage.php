<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

/**
 * \Playground\Stub\Building\Model\BuildPerPage
 */
trait BuildPerPage
{
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
}
