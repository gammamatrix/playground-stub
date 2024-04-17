<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Playground\Stub\Building;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Swagger as Configuration;
// use Symfony\Component\Yaml\Exception\ParseException;
// use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * \Playground\Stub\Console\Commands\SwaggerMakeCommand
 */
#[AsCommand(name: 'playground:make:swagger')]
class SwaggerMakeCommand extends GeneratorCommand
{
    use Building\Swagger\BuildController;
    use Building\Swagger\BuildModel;
    use Building\Swagger\BuildRequest;
    use Building\Swagger\BuildSwagger;

    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    // const CONFIGURATION = [
    //     // 'class' => '',
    //     // 'controller' => '',
    //     // 'extends' => '',
    //     'name' => '',
    //     // 'folder' => '',
    //     'namespace' => 'App',
    //     // 'model' => '',
    //     // 'model_column' => '',
    //     // 'model_label' => '',
    //     // 'model_slug_plural' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'organization' => '',
    //     'package' => '',
    //     'config' => '',
    //     'type' => '',
    //     // 'docs' => '',
    //     // 'docs_prefix' => '',
    //     // 'base_docs' => 'welcome',
    //     // 'title' => '',
    //     // stubs/docs/playground/resource-index-section.stub
    // ];

    const SEARCH = [
        'docs' => '',
        // 'base_docs' => 'welcome',
        'extends' => '',
        'class' => '',
        'controller' => '',
        'folder' => '',
        'namespace' => '',
        'organization' => '',
        // 'namespacedModel' => '',
        // 'NamespacedDummyUserModel' => '',
        // 'namespacedUserModel' => '',
        // 'user' => '',
        // 'model' => '',
        // 'modelVariable' => '',
        // 'model_column' => '',
        // 'model_label' => '',
        // 'model_slug_plural' => '',
        'module' => '',
        'module_slug' => '',
        'title' => '',
        'package' => '',
        'config' => '',
        // 'docs_prefix' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:swagger';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new docs group';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Docs';

    protected string $path_destination_folder = 'docs';

    protected function getConfigurationFilename(): string
    {
        $type = $this->getConfigurationType();

        if ($type === 'api') {
            return 'api.json';
        }

        return sprintf(
            '%1$s/%2$s.%3$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
            Str::of($this->getConfigurationType())->kebab()
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        // $options[] = ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the docs applies to'],;
        $options[] = ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the docs'];
        $options[] = ['prefix', null, InputOption::VALUE_OPTIONAL, 'The prefix slug for the docs.'];
        $options[] = ['controller-type', null, InputOption::VALUE_OPTIONAL, 'The controller type for the docs.'];
        // $options[] = ['roles-action', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles for action.'];
        // $options[] = ['roles-view', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles to view.'];

        return $options;
    }

    protected function getStub()
    {
        return '';
    }

    /**
     * Execute the console command.
     *
     * Types:
     * - model
     * - controller
     * - info
     * - request
     * - response
     * - security
     * - externalDocs
     * - servers
     * - paths
     * - component: securitySchemes, parameters, responses, schemas
     * - tags
     */
    public function handle()
    {
        $this->reset();

        $name = $this->getNameInput();

        $type = $this->getConfigurationType();

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$type' => $type,
        //     '$name' => $name,
        //     '$this->model' => $this->model,
        //     '$this->c' => $this->c,
        //     '$this->searches' => $this->searches,
        //     '$this->arguments()' => $this->arguments(),
        //     '$this->options()' => $this->options(),
        // ]);

        $this->load_base_file();

        if ($type === 'api') {
            $this->save_base_file();
        } elseif (in_array($type, [
            'controller',
            'playground-api',
            'playground-resource',
        ])) {

            if ($this->hasOption('controller-type') && is_string($this->option('controller-type')) ) {
                $this->c->setOptions([
                    'controller_type' => $this->option('controller-type'),
                ]);
            }

            if (! empty($this->model?->create())) {
                $this->doc_model();
            }

            $this->doc_controller();

            $this->save_base_file();

        } elseif ($type === 'model') {

            if (empty($this->model?->create())) {
                $this->components->error('Provide a [--model-file] with a [create] section.');

                return true;
            }

            $this->doc_model();

            $this->save_base_file();
        }

        $this->saveConfiguration();

    }

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();

        $this->initModel($this->c->skeleton());

        // dump([
        //     '__METHOD__' => __METHOD__,
        //     // '$options' => $options,
        //     '$type' => $type,
        //     // '$this->model' => $this->model,
        //     '!empty($this->model)' => !empty($this->model),
        //     // '$this->c' => $this->c,
        //     '$this->c->class()' => $this->c->class(),
        //     '$this->c->table()' => $this->c->table(),
        // ]);
    }
}
