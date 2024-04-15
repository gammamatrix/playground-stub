<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildJson
 */
trait BuildJson
{
    protected function buildClass_json(): void
    {
        $json = $this->model?->create()?->json();

        if (! $json) {
            return;
        }

        $this->buildClass_uses_add('Illuminate\Database\Query\Expression');

        $allowed = [
            'JSON_OBJECT',
            'JSON_ARRAY',
        ];

        $this->searches['table_json'] = PHP_EOL.PHP_EOL;

        $this->searches['table_json'] .= sprintf(
            '%1$s// JSON',
            str_repeat(' ', 12)
        );

        $this->searches['table_json'] .= PHP_EOL;

        $i = 0;

        foreach ($json as $attribute => $meta) {

            $this->searches['table_json'] .= $this->buildClass_json_column(
                $attribute,
                $meta->properties(),
                'table_json'
            );

            $i++;
        }
    }
}
