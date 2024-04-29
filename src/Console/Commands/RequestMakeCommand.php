<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

// use Illuminate\Routing\Console\ControllerMakeCommand as BaseControllerMakeCommand;
use Illuminate\Support\Str;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\PrimaryConfiguration as PrimaryConfigurationContract;
use Playground\Stub\Configuration\Request as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\RequestMakeCommand
 */
#[AsCommand(name: 'playground:make:request')]
class RequestMakeCommand extends GeneratorCommand
{
    use Building\Concerns\BuildImplements;
    use Building\Concerns\BuildModel;
    use Building\Concerns\BuildUses;
    use Building\Request\BuildIndex;
    use Building\Request\BuildRequest;
    // use Building\Request\BuildStore;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var PrimaryConfigurationContract&Configuration
     */
    protected PrimaryConfigurationContract $c;

    // const CONFIGURATION = [
    //     'abstract' => false,
    //     'class' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'name' => '',
    //     'namespace' => 'App',
    //     'model' => '',
    //     'organization' => '',
    //     'package' => 'app',
    //     'type' => '',
    //     'extends' => 'FormRequest',
    //     'extends_use' => 'Illuminate\Foundation\Http\FormRequest',
    // ];

    const SEARCH = [
        'abstract' => '',
        'namespace' => '',
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'name' => '',
        'extends' => '',
        'extends_use' => '',
        'implements' => '',
        'use' => '',
        'use_class' => '',
        'constants' => '',
        'properties' => '',
        'authorize' => '',
        'messages' => '',
        'rules' => '',
        'rules_method' => '',
        'methods' => '',
        'organization' => '',
        'namespacedModel' => '',
        'namespacedRequest' => '',
        'namespacedResource' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelLabel' => '',
        'modelVariable' => '',
        'modelVariablePlural' => '',
        'modelSlugPlural' => '',
        'table' => '',
        'format_sql' => 'Y-m-d H:i:s',
        'slug_column' => 'slug',
        'slug_source' => 'label',
        'prepareForValidation' => '',
        'passedValidation' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new form request class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    protected string $path_destination_folder = 'src/Http/Requests';

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();

        // Extends

        if (! empty($options['extends']) && is_string($options['extends'])) {

            $extends_use = $this->parseClassInput($options['extends']);
            $extends = class_basename($extends_use);

            if ($extends_use === $extends) {
                $this->c->setOptions([
                    'extends' => $extends,
                    'extends_use' => '',
                ]);
            } else {
                $this->c->setOptions([
                    'extends' => $extends,
                    'extends_use' => $extends_use,
                ]);
            }
        }

        if (! $this->c->extends()) {
            $this->c->setOptions([
                'extends' => 'FormRequest',
                'extends_use' => 'Illuminate/Foundation/Http/FormRequest',
            ]);
        }

        $this->searches['extends_use'] = $this->parseClassInput($this->c->extends_use());
        $this->searches['extends'] = $this->parseClassInput($this->c->extends());

        $this->initModel($this->c->skeleton());
    }

    protected function getConfigurationFilename(): string
    {
        $this->configurationType = $this->getConfigurationType();

        if ($this->useSubfolder) {
            return sprintf(
                '%1$s/%2$s%3$s.json',
                Str::of($this->c->name())->kebab(),
                Str::of($this->getType())->kebab(),
                $this->configurationType ? '.'.Str::of($this->configurationType)->kebab() : ''
            );
        } else {
            return sprintf(
                '%1$s.%2$s.json',
                Str::of($this->getType())->kebab(),
                Str::of($this->c->name())->kebab(),
            );
        }
    }

    /**
     * @var array<int, string>
     */
    protected array $options_type_suggested = [
        'abstract',
        'abstract-index',
        'abstract-store',
        'destroy',
        'index',
        'store',
        'update',
    ];

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        $template = 'request/default.stub';

        $this->configurationType = $this->getConfigurationType();

        if ($this->configurationType === 'abstract') {
            $template = 'request/abstract.stub';
            $this->c->setOptions([
                'abstract' => true,
            ]);
        } elseif (in_array($this->configurationType, [
            'abstract-index',
        ])) {
            $template = 'request/abstract.index.stub';
        } elseif (in_array($this->configurationType, [
            'abstract-store',
        ])) {
            $template = 'request/abstract.store.stub';
        } elseif (in_array($this->configurationType, [
            'destroy',
        ])) {
            $template = 'request/destroy.stub';
        } elseif (in_array($this->configurationType, [
            'index',
        ])) {
            $template = 'request/index.stub';
        } elseif (in_array($this->configurationType, [
            'store',
        ])) {
            $template = 'request/store.stub';
        } elseif (in_array($this->configurationType, [
            'update',
        ])) {
            $template = 'request/update.stub';
        } elseif (! empty($this->configurationType)) {
            $template = 'request/request.stub';
            // $this->useSubfolder = true;
        }

        return $this->resolveStubPath($template);
    }

    protected bool $useSubfolder = false;

    protected function folder(): string
    {
        if (empty($this->folder)) {

            if (! empty($this->c->class())
                && $this->c->class() === $this->c->name()
            ) {
                $this->useSubfolder = false;
                // $this->c->class() = $this->c->name();
                // $this->searches['class'] = $this->c->name();
            } else {
                $this->useSubfolder = true;
            }

            if ($this->useSubfolder) {
                $this->folder = sprintf(
                    '%1$s/%2$s',
                    $this->getDestinationPath(),
                    Str::of($this->c->name())->studly()
                );
            } else {
                $this->folder = $this->getDestinationPath();
            }
        }

        return $this->folder;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        $this->useSubfolder = $this->c->class() !== $this->c->name();

        if ($this->useSubfolder) {
            return rtrim(sprintf(
                '%1$s\\Http\\Requests\\%2$s',
                rtrim($rootNamespace, '\\'),
                $this->c->name()
            ), '\\');
        } else {
            return rtrim(sprintf(
                '%1$s\\Http\\Requests',
                $rootNamespace
            ), '\\');
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        $options[] = ['with-pagination', null, InputOption::VALUE_NONE, 'Create the pagination traits along with the request type'];
        $options[] = ['with-store', null, InputOption::VALUE_NONE, 'Create the store slug traits along with the request type'];
        $options[] = ['skeleton', null, InputOption::VALUE_NONE, 'Create the skeleton for the request type'];
        $options[] = ['type', null, InputOption::VALUE_OPTIONAL, 'Specify the request type.'];
        $options[] = ['abstract', null, InputOption::VALUE_NONE, 'Make the request abstract.'];

        return $options;
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in the base namespace.
     *
     * @param  string  $name
     */
    protected function buildClass($name): string
    {
        $model = $this->c->model();
        $model = class_basename($model);

        $this->c->setOptions([
            'model' => $model,
        ]);

        if ($this->hasOption('abstract') && $this->option('abstract')) {
            $this->c->setOptions([
                'abstract' => true,
            ]);
        }

        if ($this->c->abstract()) {
            $this->searches['abstract'] = 'abstract ';
        }

        $this->buildClass_model($name);

        $this->searches['namespacedRequest'] = sprintf(
            '%1$s\Http\Requests\%2$s',
            rtrim($this->c->namespace(), '\\'),
            rtrim($this->c->name(), '\\')
        );

        if (in_array($this->c->type(), [
            'index',
            'abstract-index',
        ])) {
            $this->buildClass_index($name);
        }

        $this->buildClass_form($name);
        // dd([
        //     '__METHOD__' => __METHOD__,
        //     '$this->searches' => $this->searches,
        //     '$name' => $name,
        // ]);

        return parent::buildClass($name);
    }
}
