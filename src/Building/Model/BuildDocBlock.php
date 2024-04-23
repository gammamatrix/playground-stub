<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Playground\Stub\Configuration\Model\Create;

/**
 * \Playground\Stub\Building\Model\BuildDocBlock
 */
trait BuildDocBlock
{
    protected function buildClass_docblock(): void
    {
        $create = $this->c->create();

        if (! $create) {
            return;
        }

        $this->searches['docblock'] = PHP_EOL.' *';

        $this->buildClass_docblock_properties($create);
    }

    protected function buildClass_docblock_properties(Create $create): void
    {
        $this->buildClass_docblock_ids($create);
        $this->buildClass_docblock_dates($create);
        $this->buildClass_docblock_permissions($create);
        $this->buildClass_docblock_status($create);
        $this->buildClass_docblock_matrix($create);
        $this->buildClass_docblock_flags($create);
        $this->buildClass_docblock_columns($create);
        $this->buildClass_docblock_ui($create);
        $this->buildClass_docblock_json($create);
    }

    protected function buildClass_docblock_ids(Create $create): void
    {
        // Handle primary
        $primary = $create->primary();
        if ($primary) {

            $type = 'string';
            if (in_array($primary, [
                'bigIncrements',
                'increments',
            ])) {
                $type = 'int';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s $id',
                $type
            );

        }

        // Handle all other IDS.
        foreach ($create->ids() as $column => $createId) {
            $foreign = $createId->foreign();
            $referencesUser = false;
            // dump([
            //     '__METHOD__' => __METHOD__,
            //     '$createId' => $createId,
            //     '$foreign' => $foreign,
            // ]);
            if (! empty($foreign['on'])) {
                $referencesUser = $foreign['on'] === 'users';
            }
            $type = 'string';
            if ($referencesUser && $createId->type() === 'uuid') {
                $type = 'scalar';
            } elseif (in_array($createId->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createId->nullable() ? '?' : '',
                $type,
                $createId->column(),
            );
        }
    }

    protected function buildClass_docblock_dates(Create $create): void
    {
        // Handle timestamps
        if ($create->timestamps()) {

            $this->searches['docblock'] .= PHP_EOL.
                ' * @property ?Carbon $created_at';
            $this->searches['docblock'] .= PHP_EOL.
                ' * @property ?Carbon $updated_at';
        }

        // Handle softDeletes
        if ($create->softDeletes()) {

            $this->searches['docblock'] .= PHP_EOL.
                ' * @property ?Carbon $deleted_at';
        }

        // Handle all other dates.
        foreach ($create->dates() as $column => $createDate) {
            $type = 'Carbon';

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createDate->nullable() ? '?' : '',
                $type,
                $createDate->column(),
            );
        }
    }

    protected function buildClass_docblock_permissions(Create $create): void
    {
        foreach ($create->permissions() as $column => $createPermission) {
            $type = 'string';
            if (in_array($createPermission->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createPermission->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createPermission->nullable() ? '?' : '',
                $type,
                $createPermission->column(),
            );
        }
    }

    protected function buildClass_docblock_status(Create $create): void
    {
        foreach ($create->status() as $column => $createStatus) {
            $type = 'string';
            if (in_array($createStatus->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createStatus->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createStatus->nullable() ? '?' : '',
                $type,
                $createStatus->column(),
            );
        }
    }

    protected function buildClass_docblock_flags(Create $create): void
    {
        foreach ($create->flags() as $column => $createFlag) {
            $type = 'string';
            if (in_array($createFlag->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createFlag->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createFlag->nullable() ? '?' : '',
                $type,
                $createFlag->column(),
            );
        }
    }

    protected function buildClass_docblock_matrix(Create $create): void
    {
        foreach ($create->matrix() as $column => $createMatrix) {
            $type = 'string';
            if (in_array($createMatrix->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createMatrix->type(), [
                'decimal',
                'double',
                'float',
            ])) {
                $type = 'double';
            } elseif (in_array($createMatrix->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            } elseif (in_array($createMatrix->type(), [
                'JSON_OBJECT',
            ])) {
                $type = 'array';
            } elseif (in_array($createMatrix->type(), [
                'JSON_ARRAY',
            ])) {
                $type = 'array';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createMatrix->nullable() ? '?' : '',
                $type,
                $createMatrix->column(),
            );
        }
    }

    protected function buildClass_docblock_columns(Create $create): void
    {
        foreach ($create->columns() as $column => $createColumn) {
            $type = 'string';
            if (in_array($createColumn->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createColumn->type(), [
                'decimal',
                'double',
                'float',
            ])) {
                $type = 'double';
            } elseif (in_array($createColumn->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            } elseif (in_array($createColumn->type(), [
                'JSON_OBJECT',
            ])) {
                $type = 'array';
            } elseif (in_array($createColumn->type(), [
                'JSON_ARRAY',
            ])) {
                $type = 'array';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createColumn->nullable() ? '?' : '',
                $type,
                $createColumn->column(),
            );
        }
    }

    protected function buildClass_docblock_ui(Create $create): void
    {
        foreach ($create->ui() as $column => $createUi) {
            $type = 'string';
            if (in_array($createUi->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createUi->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            } elseif (in_array($createUi->type(), [
                'JSON_OBJECT',
            ])) {
                $type = 'array';
            } elseif (in_array($createUi->type(), [
                'JSON_ARRAY',
            ])) {
                $type = 'array';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createUi->nullable() ? '?' : '',
                $type,
                $createUi->column(),
            );
        }
    }

    protected function buildClass_docblock_json(Create $create): void
    {
        foreach ($create->json() as $column => $createJson) {
            $type = 'string';
            if (in_array($createJson->type(), [
                'integer',
                'tinyInteger',
                'smallInteger',
                'mediumInteger',
                'bigInteger',
            ])) {
                $type = 'int';
            } elseif (in_array($createJson->type(), [
                'boolean',
            ])) {
                $type = 'bool';
            } elseif (in_array($createJson->type(), [
                'text',
                'mediumText',
                'longText',
            ])) {
                $type = 'array';
            } elseif (in_array($createJson->type(), [
                'JSON_OBJECT',
            ])) {
                $type = 'array';
            } elseif (in_array($createJson->type(), [
                'JSON_ARRAY',
            ])) {
                $type = 'array';
            }

            $this->searches['docblock'] .= PHP_EOL.sprintf(
                ' * @property %1$s%2$s $%3$s',
                $createJson->nullable() ? '?' : '',
                $type,
                $createJson->column(),
            );
        }
    }
}
