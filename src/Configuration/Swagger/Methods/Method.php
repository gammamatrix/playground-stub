<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger\Methods;

use Playground\Stub\Configuration;
use Playground\Stub\Configuration\Swagger\Responses\Response;

/**
 * \Playground\Stub\Configuration\Swagger\Methods\Method
 */
class Method extends Configuration\Configuration
{
    protected string $summary = '';

    protected string $operationId = '';

    /**
     * @var array<int, Response>
     */
    protected array $responses = [];

    /**
     * @var array<int, string>
     */
    protected array $tags = [];

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        'tags' => [],
        'summary' => '',
        'operationId' => '',
        'responses' => [],
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        parent::setOptions($options);

        if (! empty($options['summary'])
            && is_string($options['summary'])
        ) {
            $this->summary = $options['summary'];
        }

        if (! empty($options['operationId'])
            && is_string($options['operationId'])
        ) {
            $this->operationId = $options['operationId'];
        }

        if (! empty($options['responses'])
            && is_array($options['responses'])
        ) {
            foreach ($options['responses'] as $i => $response) {
                if (is_array($response)) {
                    $this->addResponse($response);
                }
            }
        }

        if (! empty($options['tags'])
            && is_array($options['tags'])
        ) {
            foreach ($options['tags'] as $i => $tag) {
                if (is_string($tag) && $tag && ! in_array($tag, $this->tags)) {
                    $this->tags[] = $tag;
                }
            }
        }
        // dump([
        //     '$options' => $options,
        // ]);

        return $this;
    }

    /**
     * @param array<string, string> $meta
     */
    public function addResponse(array $meta): self
    {
        $response = new Response($meta, $this->skeleton());
        $response->apply();
        $this->responses[] = $response;

        return $this;
    }

    public function summary(): string
    {
        return $this->summary;
    }

    public function operationId(): string
    {
        return $this->operationId;
    }

    /**
     * @return array<int, Response>
     */
    public function responses(): array
    {
        return $this->responses;
    }

    /**
     * @return array<int, string>
     */
    public function tags(): array
    {
        return $this->tags;
    }

    public function jsonSerialize(): mixed
    {
        $properties = [];

        $tags = $this->tags();
        if ($tags) {
            $properties['tags'] = $tags;
        }

        $properties['summary'] = $this->summary();

        if ($this->operationId()) {
            $properties['operationId'] = $this->operationId();
        }

        $responses = $this->responses();
        if ($responses) {
            $properties['responses'] = [];
            foreach ($responses as $i => $response) {
                $properties['responses'][$response->code()] = [
                    'description' => $response->description(),
                ];

                $content = $response->content();
                if ($content) {
                    $properties['responses'][$response->code()]['content'] = $content->toArray();
                }
            }
        }

        // dump([
        //     '$properties' => $properties,
        //     '$responses' => $responses,
        // ]);

        return $properties;
    }
}
