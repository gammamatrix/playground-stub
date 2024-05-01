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

        // $this->buildClass_uses_add('Illuminate\Database\Query\Expression');

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

    /**
     * @param array<string, mixed> $meta
     */
    protected function buildClass_json_column(string $attribute, array $meta, string $group): string
    {
        $allowed = [
            'JSON_OBJECT',
            'JSON_ARRAY',
        ];

        $type = empty($meta['type'])
            || ! is_string($meta['type'])
            || ! in_array($meta['type'], $allowed)
            ? '' : $meta['type'];

        if (! $type) {
            $this->components->error(sprintf(
                '[%s]: Invalid column [%s] type: %s',
                $group,
                $attribute,
                $type
            ));

            return sprintf(
                '%1$s%2$s// SKIPPED: invalid column [%3$s] type: [%4$s]',
                PHP_EOL,
                str_repeat(' ', 12),
                $attribute,
                $type
            );
        }

        $column = '';

        $column .= sprintf(
            '%1$s%2$s$table->json(\'%3$s\')',
            PHP_EOL,
            str_repeat(' ', 12),
            $attribute
        );

        if (! empty($meta['nullable'])) {
            // $column .= '->nullable()->default(null)';
            $column .= '->nullable()';
        }

        $column .= sprintf(
            '->default(new Expression(\'(%1$s())\'))',
            $type
        );

        if (! empty($meta['comment']) && is_string($meta['comment'])) {
            $column .= sprintf('->comment(\'%1$s\')', addslashes($meta['comment']));
        }

        $column .= ';';

        return $column;
    }
}
