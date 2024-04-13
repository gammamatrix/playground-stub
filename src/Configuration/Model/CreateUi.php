<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateUi
 */
class CreateUi extends CreateColumn
{
    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'JSON_OBJECT',
        'string',
    ];
}