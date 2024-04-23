<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateMatrix
 */
class CreateMatrix extends CreateColumn
{
    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'JSON_OBJECT',
        'bigInteger',
        'decimal',
    ];

    // /**
    //  * @param array<string, mixed> $options
    //  */
    // public function setOptions(array $options = []): self
    // {
    //     parent::setOptions($options);

    //     dump([
    //         '__METHOD__' => __METHOD__,
    //         '$options' => $options,
    //         '$this' => $this,
    //     ]);
    //     return $this;
    // }
}
