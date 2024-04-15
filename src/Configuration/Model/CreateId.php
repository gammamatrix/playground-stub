<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateId
 */
class CreateId extends ModelConfiguration
{
    protected string $column = '';

    protected mixed $default;

    protected string $description = '';

    protected string $icon = '';

    protected string $label = '';

    protected string $type = '';

    protected bool $nullable = false;

    protected bool $index = false;

    protected bool $readOnly = false;

    protected bool $unsigned = false;

    public bool $hasDefault = false;

    /**
     * @var ?array<string, string>
     */
    protected ?array $foreign = null;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'column' => '',
        'label' => '',
        'description' => '',
        'foreign' => null,
        'icon' => '',
        // 'default' => null,
        'index' => false,
        'nullable' => false,
        'readOnly' => false,
        'unsigned' => false,
        'type' => '',
        // 'foreign' => [
        //     'references' => 'id',
        //     'on' => '',
        // ],
    ];

    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'string',
        'ulid',
        'uuid',
        'integer',
        'bigInteger',
        'mediumInteger',
        'smallInteger',
        'tinyInteger',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['column'])
            && is_string($options['column'])
        ) {
            $this->column = $options['column'];
        }

        if (! empty($options['foreign'])
            && is_array($options['foreign'])
            && ! empty($options['foreign']['on'])
            && is_string($options['foreign']['on'])
        ) {
            $references = 'id';
            if (! empty($options['foreign']['references']) && is_string($options['foreign']['references'])) {
                $references = $options['foreign']['references'];
            }
            $this->foreign = [
                'references' => $references,
                'on' => $options['foreign']['on'],
            ];
        }

        if (array_key_exists('default', $options)) {
            $this->hasDefault = true;
            $this->default = $options['default'];
            $this->properties['default'] = $this->default;
        }

        if (array_key_exists('index', $options)) {
            $this->index = ! empty($options['index']);
        }

        if (array_key_exists('nullable', $options)) {
            $this->nullable = ! empty($options['nullable']);
        }

        if (array_key_exists('readOnly', $options)) {
            $this->readOnly = ! empty($options['readOnly']);
        }

        if (array_key_exists('unsigned', $options)) {
            $this->unsigned = ! empty($options['unsigned']);
        }

        return $this;
    }

    public function column(): string
    {
        return $this->column;
    }

    public function default(): mixed
    {
        if (! $this->hasDefault) {
            // NOTE This could throw an exception here.
            return null;
        }

        return $this->default;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function icon(): string
    {
        return $this->icon;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function nullable(): bool
    {
        return $this->nullable;
    }

    public function index(): bool
    {
        return $this->index;
    }

    public function readOnly(): bool
    {
        return $this->readOnly;
    }

    public function unsigned(): bool
    {
        return $this->unsigned;
    }

    /**
     * @return ?array<string, string>
     */
    public function foreign(): ?array
    {
        return $this->foreign;
    }
}
