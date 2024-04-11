<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\Create
 */
class CreateId extends ModelConfiguration
{
    protected string $primary = '';

    protected string $type = '';

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

        return $this;
    }

    /**
     * @return ?array<string, string>
     */
    public function foreign(): ?array
    {
        return $this->foreign;
    }
}
