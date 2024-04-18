<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Stub\Configuration\Swagger;

/**
 * \Playground\Stub\Configuration\Swagger\Controllers
 */
class Controllers extends SwaggerConfiguration
{
    protected ?Controller\PathId $pathId = null;

    /**
     * @var array<string, mixed>
     */
    protected $properties = [
        // 'pathId' => null,
    ];

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options = []): self
    {
        if (! empty($options['pathId'])
            && is_array($options['pathId'])
        ) {
            $this->pathId = new Controller\PathId($options['pathId']);
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function pathId(array $options = []): Controller\PathId
    {
        if (empty($this->pathId)) {
            $this->pathId = new Controller\PathId($options, $this->skeleton());
            $this->properties['pathId'] = $this->pathId->apply()->toArray();
        }

        return $this->pathId;
    }
}
