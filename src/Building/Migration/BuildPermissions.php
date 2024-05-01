<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Migration;

/**
 * \Playground\Stub\Building\Migration\BuildPermissions
 */
trait BuildPermissions
{
    protected function buildClass_permissions(): void
    {
        $permissions = $this->model?->create()?->permissions();
        if (! $permissions) {
            return;
        }

        $this->searches['table_permissions'] = PHP_EOL.PHP_EOL;

        $this->searches['table_permissions'] .= sprintf(
            '%1$s// Permissions',
            str_repeat(' ', 12)
        );

        $this->searches['table_permissions'] .= PHP_EOL;

        // if (!empty($this->searches['table_primary'])) {
        //     $this->searches['table_permissions'] .= PHP_EOL;
        // }

        $i = 0;
        foreach ($permissions as $column => $createPermission) {
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$column' => $column,
            //     '$createPermission' => $createPermission,
            // ]);

            if (empty($createPermission->column()) || $createPermission->column() !== $column) {
                $this->components->error(sprintf(
                    'Column [%s] expected to be set and match [$createPermission->column(): %s] - group [%s]',
                    $column,
                    $createPermission->column(),
                    'table_permissions'
                ));

                continue;
            }

            if (in_array($column, $this->columns)) {
                $this->components->error(sprintf(
                    'Column [%s] already exists - group [%s]',
                    $column,
                    'table_permissions'
                ));

                continue;
            }

            $this->columns[] = $column;

            $this->searches['table_permissions'] .= $this->buildClass_column(
                $column,
                $createPermission->properties(),
                'table_permissions'
            );

            $i++;
        }
    }
}
