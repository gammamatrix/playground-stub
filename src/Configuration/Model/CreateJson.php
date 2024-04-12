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
    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'JSON_OBJECT',
        'JSON_ARRAY',
    ];
}