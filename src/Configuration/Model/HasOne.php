<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

use Illuminate\Support\Str;

/**
 * \Playground\Stub\Configuration\Model\HasOne
 */
class HasOne extends ModelConfiguration
{
    protected string $comment = '';

    protected string $accessor = '';

    protected string $related = '';

    protected string $foreignKey = '';

    protected string $localKey = '';

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'comment' => '',
        'accessor' => '',
        'related' => '',
        'foreignKey' => '',
        'localKey' => '',
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['comment'])
            && is_string($options['comment'])
        ) {
            $this->comment = $options['comment'];
        }

        if (! empty($options['accessor'])
            && is_string($options['accessor'])
        ) {
            $this->accessor = $options['accessor'];
        }

        if (! empty($options['related'])
            && is_string($options['related'])
        ) {
            $this->related = $options['related'];
        }

        if (! empty($options['foreignKey'])
            && is_string($options['foreignKey'])
        ) {
            $this->foreignKey = $options['foreignKey'];
        }

        if (! empty($options['localKey'])
            && is_string($options['localKey'])
        ) {
            $this->localKey = $options['localKey'];
        }

        if ($this->skeleton() && $this->accessor && $parent = $this->getParent()) {

            if (! $this->comment) {
                $this->comment = sprintf(
                    'The %1$s of the %2$s.',
                    Str::of($this->accessor)->kebab()->replace('-', ' ')->toString(),
                    Str::of($parent->name())->kebab()->replace('-', ' ')->toString()
                );
            }

            if (! $this->foreignKey) {
                $this->foreignKey = 'id';
            }

            if (! $this->localKey) {
                $this->localKey = Str::of($this->accessor)->snake()->finish('_id')->toString();
            }

            if (! $this->related) {
                $this->related = Str::of($this->accessor)->studly()->toString();
            }
        }

        return $this;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function accessor(): string
    {
        return $this->accessor;
    }

    public function related(): string
    {
        return $this->related;
    }

    public function foreignKey(): string
    {
        return $this->foreignKey;
    }

    public function localKey(): string
    {
        return $this->localKey;
    }
}
