<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Stub\Configuration\Model;

/**
 * \Playground\Stub\Configuration\Model\CreateDate
 */
class CreateDate extends CreateColumn
{
    /**
     * @var array<int, string>
     */
    public $allowed_types = [
        'dateTime',
    ];

    protected string $type = 'dateTime';
}
