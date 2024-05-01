<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model\Skeleton;

use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\Skeleton\MakeUnique
 */
trait MakeUnique
{
    protected function buildClass_skeleton_uniques(Create $create): void
    {
        $ui = $create->ui();

        $this->components->info(sprintf('Skeleton unique for [%s]', $this->c->name()));

        $keychain = [
            'keys' => [
                'slug',
                'parent_id',
            ],
        ];

        $create->addUnique(0, $keychain);
        // dd($create);
    }
}
