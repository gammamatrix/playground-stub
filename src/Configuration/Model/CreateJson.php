<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateJson
 */
class CreateJson extends CreateColumn
{
    protected ?\Playground\Stub\Configuration\Model $_parent = null;

    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'JSON_OBJECT',
        'JSON_ARRAY',
    ];
}
