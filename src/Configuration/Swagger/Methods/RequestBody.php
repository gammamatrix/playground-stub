<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger\Methods;

use Playground\Stub\Configuration;

/**
 * \Playground\Stub\Configuration\Swagger\Methods\RequestBody
 */
class RequestBody extends Configuration\Configuration
{
    protected ?Content $content = null;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'content' => null,
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['content'])
            && is_array($options['content'])
        ) {
            $this->content = new Content($options['content']);
            $this->content->apply();
        }

        return $this;
    }

    public function content(): ?Content
    {
        return $this->content;
    }
}
