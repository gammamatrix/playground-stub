<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Console\Commands;

use Illuminate\Support\Str;
use Playground\Stub\Configuration\Contracts\Configuration as ConfigurationContract;
use Playground\Stub\Configuration\Policy as Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

use function Laravel\Prompts\suggest;

/**
 * \GammaMatrix\Playground\Stub\Console\Commands\PolicyMakeCommand
 */
#[AsCommand(name: 'playground:make:policy')]
class PolicyMakeCommand extends GeneratorCommand
{
    /**
     * @var class-string<Configuration>
     */
    public const CONF = Configuration::class;

    /**
     * @var ConfigurationContract&Configuration
     */
    protected ConfigurationContract $c;

    // const CONFIGURATION = [
    //     'class' => '',
    //     'module' => '',
    //     'module_slug' => '',
    //     'name' => '',
    //     'namespace' => 'App',
    //     'model' => '',
    //     'organization' => '',
    //     'package' => 'app',
    //     'type' => '',
    //     'rolesForAction' => [],
    //     'rolesToView' => [],
    // ];

    const SEARCH = [
        'class' => '',
        'module' => '',
        'module_slug' => '',
        'namespace' => '',
        'organization' => '',
        'namespacedModel' => '',
        'NamespacedDummyUserModel' => '',
        'namespacedUserModel' => '',
        'user' => '',
        'model' => '',
        'modelVariable' => '',
        'rolesForAction' => '',
        'rolesToView' => '',
    ];

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'playground:make:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    protected string $path_destination_folder = 'src/Policies';

    public function prepareOptions(): void
    {
        $options = $this->options();

        $type = $this->getConfigurationType();

        if (! empty($options['roles-action'])) {
            foreach ($options['roles-action'] as $role) {
                if (is_string($role)
                    && $role
                    && ! in_array($role, $this->c->rolesForAction())
                ) {
                    $this->c->addRoleForAction($role);
                }
            }
        }
        if (! empty($options['roles-view'])) {
            foreach ($options['roles-view'] as $role) {
                if (is_string($role)
                    && $role
                    && ! in_array($role, $this->c->rolesToView())
                ) {
                    $this->c->addRoleToView($role);
                }
            }
        }
        // dump([
        //     '__METHOD__' => __METHOD__,
        //     '$this->c' => $this->c,
        //     '$this->options()' => $this->options(),
        // ]);
    }

    protected function getConfigurationFilename(): string
    {
        return sprintf(
            '%1$s/%2$s.json',
            Str::of($this->c->name())->kebab(),
            Str::of($this->getType())->kebab(),
        );
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     */
    protected function buildClass($name): string
    {
        $this->buildClass_user_model();

        $this->buildClass_model($name);

        $this->make_roles_to_view($this->searches);
        $this->make_roles_for_action($this->searches);

        return parent::buildClass($name);

        // $stub = $this->replaceUserNamespace(
        //     parent::buildClass($name)
        // );

        // return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    protected function buildClass_user_model(): void
    {
        $upm = $this->userProviderModel();
        if (empty($this->searches[$this->laravel->getNamespace().'User'])) {
            $this->searches[$this->laravel->getNamespace().'User'] = $upm;
        }

        $this->searches['NamespacedDummyUserModel'] = $upm;
        $this->searches['namespacedUserModel'] = $upm;
    }

    // /**
    //  * Replace the User model namespace.
    //  *
    //  * @param  string  $stub
    //  * @return string
    //  */
    // protected function replaceUserNamespace($stub)
    // {
    //     $model = $this->userProviderModel();

    //     if (! $model) {
    //         return $stub;
    //     }

    //     return str_replace(
    //         $this->laravel->getNamespace().'User',
    //         $model,
    //         $stub
    //     );
    // }

    protected function userProviderModelGuard(mixed $guard): string
    {
        $guardProvider = is_string($guard) && $guard ? config('auth.guards.'.$guard.'.provider') : null;

        if (! $guard || ! $guardProvider) {

            throw new \RuntimeException(__('playground-stub::stub.Policy.guard.required', [
                'guard' => is_string($guard) ? $guard : gettype($guard),
            ]));
        }

        return is_string($guardProvider) ? $guardProvider : '';
    }

    /**
     * Get the model for the guard's user provider.
     *
     * @throws \RuntimeException
     */
    protected function userProviderModel(): string
    {
        $guard = $this->option('guard') ?: config('auth.defaults.guard');
        $guardProvider = $this->userProviderModelGuard($guard);

        $upm = $guardProvider ? config('auth.providers.'.$guardProvider.'.model') : null;

        return $upm && is_string($upm) ? $upm : 'App\\Models\\User';
    }

    // /**
    //  * Replace the model for the given stub.
    //  *
    //  * @param  string  $stub
    //  * @param  string  $model
    //  * @return string
    //  */
    // protected function replaceModel($stub, $model)
    // {
    //     $model = str_replace('/', '\\', $model);
    //     dd([
    //         '__METHOD__' => __METHOD__,
    //         '$model' => $model,
    //     ]);

    //     if (str_starts_with($model, '\\')) {
    //         $namespacedModel = trim($model, '\\');
    //     } else {
    //         $namespacedModel = $this->qualifyModel($model);
    //     }

    //     $model = class_basename(trim($model, '\\'));

    //     $dummyUser = class_basename($this->userProviderModel());

    //     $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

    //     $replace = [
    //         'NamespacedDummyModel' => $namespacedModel,
    //         '{{ namespacedModel }}' => $namespacedModel,
    //         '{{namespacedModel}}' => $namespacedModel,
    //         'DummyModel' => $model,
    //         '{{ model }}' => $model,
    //         '{{model}}' => $model,
    //         'dummyModel' => Str::camel($dummyModel),
    //         '{{ modelVariable }}' => Str::camel($dummyModel),
    //         '{{modelVariable}}' => Str::camel($dummyModel),
    //         'DummyUser' => $dummyUser,
    //         '{{ user }}' => $dummyUser,
    //         '{{user}}' => $dummyUser,
    //         '$user' => '$'.Str::camel($dummyUser),
    //     ];

    //     $stub = str_replace(
    //         array_keys($replace),
    //         array_values($replace),
    //         $stub
    //     );

    //     return preg_replace(
    //         vsprintf('/use %s;[\r\n]+use %s;/', [
    //             preg_quote($namespacedModel, '/'),
    //             preg_quote($namespacedModel, '/'),
    //         ]),
    //         "use {$namespacedModel};",
    //         $stub
    //     );
    // }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $template = 'policy/policy.stub';

        $type = $this->getConfigurationType();

        if ($type === 'playground-resource') {
            $template = 'policy/policy.playground-resource.stub';
        } elseif ($type === 'playground-api') {
            $template = 'policy/policy.playground-api.stub';
        } elseif ($type === 'api') {
            $template = 'policy/policy.api.stub';
        } elseif ($type === 'resource') {
            $template = 'policy/policy.resource.stub';
        }

        return $this->resolveStubPath($template);
    }

    // /**
    //  * Resolve the fully-qualified path to the stub.
    //  *
    //  * @param  string  $stub
    //  * @return string
    //  */
    // protected function resolveStubPath($stub): string
    // {
    //     $file = $this->laravel->basePath(sprintf('%1$s/%2$s', static::STUBS, $stub));
    //     dump([
    //         '__METHOD__' => __METHOD__,
    //         '$file' => $file,
    //     ]);

    //     return $file;
    // }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->parseClassInput($rootNamespace).'\\Policies';
        // return $rootNamespace.'\Policies';
    }

    /**
     * Get the console command arguments.
     *
     * @return array<int, mixed>
     */
    protected function getOptions(): array
    {
        $options = parent::getOptions();

        // $options[] = ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],;
        $options[] = ['guard', 'g', InputOption::VALUE_OPTIONAL, 'The guard that the policy relies on'];
        $options[] = ['roles-action', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles for action.'];
        $options[] = ['roles-view', null, InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, 'The roles to view.'];

        return $options;

        // return [
        //     ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the policy already exists'],
        //     ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],
        //     ['guard', 'g', InputOption::VALUE_OPTIONAL, 'The guard that the policy relies on'],
        // ];
    }

    // /**
    //  * Interact further with the user if they were prompted for missing arguments.
    //  *
    //  * @return void
    //  */
    // protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    // {
    //     $name = $this->getNameInput();
    //     if (($name && $this->isReservedName($name)) || $this->didReceiveOptions($input)) {
    //         return;
    //     }

    //     $model = suggest(
    //         'What model should this policy apply to? (Optional)',
    //         $this->possibleModels(),
    //     );

    //     if ($model) {
    //         $input->setOption('model', $model);
    //     }
    // }

    // /**
    //  * Get a list of possible model names.
    //  *
    //  * @return array<int, string>
    //  */
    // protected function possibleModels(): array
    // {
    //     $modelPath = is_dir(app_path('Models')) ? app_path('Models') : app_path();

    //     return [];
    //     // return collect((new Finder)->files()->depth(0)->in($modelPath))
    //     //     ->map(fn ($file) => $file->getBasename('.php'))
    //     //     ->sort()
    //     //     ->values()
    //     //     ->all();
    // }

    /**
     * @param array<string, string> $searches
     */
    protected function make_roles_to_view(array &$searches): string
    {
        $indent = '    ';

        $content = '';

        $rolesToView = $this->c->rolesToView();
        if (! empty($rolesToView)) {
            foreach ($rolesToView as $i => $role) {
                $content .= sprintf('%2$s\'%3$s\'%4$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $role,
                    (count($rolesToView) - 2) >= $i ? ',' : ''
                );
                // $content = trim($content, ',');
            }
        }

        if (! empty($content)) {
            $searches['rolesToView'] = sprintf(
                '%1$s%3$s%2$s',
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['rolesToView'] = '';
        }

        return $searches['rolesToView'];
    }

    /**
     * @param array<string, string> $searches
     */
    protected function make_roles_for_action(array &$searches): string
    {
        $indent = '    ';

        $content = '';

        $rolesForAction = $this->c->rolesForAction();
        if (! empty($rolesForAction)) {
            foreach ($rolesForAction as $i => $role) {
                $content .= sprintf('%2$s\'%3$s\'%4$s%1$s',
                    PHP_EOL,
                    str_repeat($indent, 2),
                    $role,
                    (count($rolesForAction) - 2) >= $i ? ',' : ''
                );
                // $content = trim($content, ',');
            }
        }

        if (! empty($content)) {
            $searches['rolesForAction'] = sprintf(
                '%1$s%3$s%2$s',
                PHP_EOL,
                str_repeat($indent, 1),
                $content
            );
        } else {
            $searches['rolesForAction'] = '';
        }

        return $searches['rolesForAction'];
    }
}
