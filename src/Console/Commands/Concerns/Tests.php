<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Console\Commands\Concerns;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Console\Commands\Concerns\TestMakeTrait
 */
trait Tests
{
    protected function buildClass_hasOne(string $type, string $suite): void
    {
        $this->searches['hasOne_properties'] = '';

        if (empty($this->model) || empty($this->model->HasOne())) {
            return;
        }

        /**
         * @var array<string, array<string, string>> $hasOnes
         */
        $hasOnes = [];

        if (in_array($type, [
            'playground-api',
            'playground-resource',
        ])) {

            /**
             * @var class-string<\Illuminate\Contracts\Auth\Authenticatable>
             */
            $uc = config('auth.providers.users.model', '\\App\\Models\\User');

            $hasOnes = [
                'creator' => [
                    'localKey' => 'created_by_id',
                    'rule' => 'first',
                    'related' => $uc,
                ],
                'modifier' => [
                    'localKey' => 'modified_by_id',
                    'rule' => 'first',
                    'related' => $uc,
                ],
                'owner' => [
                    'localKey' => 'owned_by_id',
                    'rule' => 'first',
                    'related' => $uc,
                ],
                'parent' => [
                    'localKey' => 'parent_id',
                    'rule' => 'create',
                    'related' => $this->model->class(),
                ],
            ];
        }

        foreach ($this->model->HasOne() as $HasOne) {
            if ($HasOne->accessor()) {
                $hasOnes[$HasOne->accessor()] = [
                    'localKey' => $HasOne->localKey(),
                    'rule' => 'first',
                    'related' => $HasOne->related(),
                ];
            }
        }

        $hasOne_properties = PHP_EOL;

        if (in_array($suite, [
            'unit',
        ])) {
            foreach ($hasOnes as $accessor => $meta) {
                $hasOne_properties .= sprintf('%1$s\'%2$s\',%3$s', str_repeat(' ', 8), $accessor, PHP_EOL);
            }
        } else {
            foreach ($hasOnes as $accessor => $meta) {
                $localKey = '';
                if (! empty($meta['localKey']) && is_string($meta['localKey'])) {
                    $localKey = $meta['localKey'];
                }
                $rule = 'create';
                if (! empty($meta['rule']) && is_string($meta['rule'])) {
                    $rule = $meta['rule'];
                }
                $related = '';
                if (! empty($meta['related']) && is_string($meta['related'])) {
                    $related = $meta['related'];
                }
                $related_base = $related ? class_basename($related) : '';
                if (! empty($related_base) && ! empty($related)) {
                    if ($related_base === $related) {
                        $related = sprintf(
                            '\\%1$s\Models\\%2$s::class',
                            $this->parseClassInput($this->model->namespace()),
                            $this->parseClassInput($related)
                        );
                    } else {
                        if (Str::of($related)->endsWith('::class')) {
                            $related = '\\'.$this->parseClassInput($related);
                        } else {
                            $related = sprintf(
                                '\\%1$s::class',
                                $this->parseClassInput($related)
                            );
                        }
                    }
                } else {
                    $related = $this->parseClassInput($related);
                }
                $hasOne_properties .= sprintf('%1$s\'%2$s\' => [%3$s', str_repeat(' ', 8), $accessor, PHP_EOL);
                $hasOne_properties .= sprintf('%1$s\'key\'        => \'%2$s\',%3$s', str_repeat(' ', 12), $localKey, PHP_EOL);
                $hasOne_properties .= sprintf('%1$s\'rule\'       => \'%2$s\',%3$s', str_repeat(' ', 12), $rule, PHP_EOL);
                $hasOne_properties .= sprintf('%1$s\'modelClass\' => %2$s,%3$s', str_repeat(' ', 12), $related, PHP_EOL);
                $hasOne_properties .= sprintf('%1$s],%2$s', str_repeat(' ', 8), PHP_EOL);

            }
        }
        $hasOne_properties .= str_repeat(' ', 4);

        $this->searches['hasOne_properties'] = sprintf(
            '%3$s%3$s%1$sprotected array $hasOne = [%2$s];',
            str_repeat(' ', 4),
            $hasOne_properties,
            PHP_EOL
        );

        $this->searches['hasRelationships'] = 'true';
    }

    protected function buildClass_hasMany(string $type, string $suite): void
    {
        $this->searches['hasMany_properties'] = '';

        if (empty($this->model) || empty($this->model->HasMany())) {
            return;
        }

        $hasMany_properties = PHP_EOL;

        foreach ($this->model->HasMany() as $HasMany) {
            $hasMany_properties .= sprintf('%1$s\'%2$s\',%3$s', str_repeat(' ', 8), $HasMany->accessor(), PHP_EOL);
        }

        $hasMany_properties .= str_repeat(' ', 4);

        $this->searches['hasMany_properties'] = sprintf(
            '%3$s%3$s%1$sprotected array $hasMany = [%2$s];',
            str_repeat(' ', 4),
            $hasMany_properties,
            PHP_EOL
        );

        $this->searches['hasRelationships'] = 'true';
    }
}
