<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Building\Model\BuildTable
 */
trait BuildTable
{
    protected function buildClass_model_table(
        string $name,
        string $type,
        string $module_slug
    ): void {

        // $config_columns = config('playground-stub.columns');

        // namespace
        // $this->configuration['namespace'] = $this->parseClassConfig($this->configuration['namespace']);
        $options = [];

        if (! $this->c->model()) {
            $options['model'] = $name;
        }

        if (! $this->c->table()) {
            $table = '';

            if (! empty($module_slug)) {
                $table .= Str::of($module_slug)->snake()->finish('_')->toString();
            }

            $table .= Str::of($name)->plural()->snake()->toString();

            $options['table'] = $table;
        }

        if (! $this->c->extends()) {
            if (in_array($type, [
                'playground-abstract',
            ])) {
                $options['extends'] = 'Playground/Models/Model';
            } elseif (in_array($type, [
                'playground-resource',
                'playground-api',
            ])) {
                $options['extends'] = 'AbstractModel';
            } else {
                $options['extends'] = 'Illuminate/Database/Eloquent/Model';
            }
        }

        if (! $this->c->fqdn()) {
            $options['fqdn'] = sprintf(
                '%1$s/Models/%2$s',
                $this->c->namespace(),
                Str::of($name)->studly()->toString()
            );
        }

        if (in_array($type, [
            'model',
            'resource',
            'api',
            'playground-resource',
            'playground-api',
        ])) {
            $this->c->create()?->setOptions([
                'factory' => true,
                'migration' => true,
            ]);
        }

        if ($options) {
            $this->c->setOptions($options);
        }
    }

    protected function buildClass_table_property(): void
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
}
