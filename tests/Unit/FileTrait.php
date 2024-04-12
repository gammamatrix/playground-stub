<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Stub;

/**
 * \Tests\Unit\Playground\Stub\FileTrait
 */
trait FileTrait
{
    protected function getResourceFile(string $type = ''): string
    {
        $package_base = dirname(dirname(__DIR__));

        //
        // Models
        //

        if (in_array($type, [
            'model',
            'model-backlog',
            'playground-model',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/model.backlog.json',
                $package_base
            );
        } elseif (in_array($type, [
            'abstract',
            'playground-abstract',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/model.abstract-model.json',
                $package_base
            );
        } elseif (in_array($type, [
            'model-api',
            'model-api-backlog',
            'playground-model-api',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/api/model.backlog.json',
                $package_base
            );
        } elseif (in_array($type, [
            'model-resource',
            'model-resource-backlog',
            'playground-model-resource',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/resource/model.backlog.json',
                $package_base
            );


        //
        // Tests
        //

        } elseif (in_array($type, [
            'test-policy',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/policy.snippet.json',
                $package_base
            );

        //
        // Tests
        //

        } elseif (in_array($type, [
            'test-model',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/configurations/test.model.crm.contact.json',
                $package_base
            );

        //
        // Empty
        //

        } elseif (in_array($type, [
            'empty',
        ])) {
            $file = sprintf(
                '%1$s/resources/testing/empty.json',
                $package_base
            );

        //
        // Default
        //

        } else {
            $file = sprintf(
                '%1$s/resources/testing/empty.json',
                $package_base
            );
        }

        return $file;
    }
}
