<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

use Playground\Stub\Configuration\Model\HasMany;
use Playground\Stub\Configuration\Model\HasOne;

/**
 * \Playground\Stub\Building\Model\BuildRelationshipsBuildRelationships
 */
trait BuildRelationships
{
    protected function buildClass_HasMany(): void
    {
        $hm = $this->c->HasMany();

        if (! $hm) {
            return;
        }

        if ($this->searches['HasOne']) {
            $this->searches['HasMany'] .= PHP_EOL;
        }

        $this->buildClass_uses_add('Illuminate\Database\Eloquent\Relations\HasMany');

        // $add_new_line = ! empty($this->searches['use_class'])
        //     || ! empty($this->searches['table'])
        //     || ! empty($this->searches['perPage'])
        //     || ! empty($this->searches['HasOne']);
        // // $this->searches['HasMany'] = $add_new_line ? PHP_EOL : '';

        $i = 0;
        foreach ($hm as $method => $HasMany) {
            $i++;
            $this->searches['HasMany'] .= $this->buildClass_HasMany_print($method, $HasMany);
            if ($i < count($hm)) {
                $this->searches['HasMany'] .= PHP_EOL;
            }
        }
    }

    protected function buildClass_HasMany_print(string $method, HasMany $HasMany): string
    {
        $related = $HasMany->related();

        if ($related !== class_basename($related)) {
            $related = '\\'.$this->parseClassInput($related);
        }

        return <<<PHP_CODE

    /**
     * {$HasMany->comment()}
     */
    public function {$method}(): HasMany
    {
        return \$this->hasMany(
            {$related}::class,
            '{$HasMany->foreignKey()}',
            '{$HasMany->localKey()}'
        );
    }
PHP_CODE;
    }

    protected function buildClass_HasOne(): void
    {
        $ho = $this->c->HasOne();
        if (! $ho) {
            return;
        }

        $this->buildClass_uses_add('Illuminate\Database\Eloquent\Relations\HasOne');

        $this->searches['HasOne'] = '';

        // if (! empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // } elseif (! empty($this->searches['fillable']) && empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // } elseif (! empty($this->searches['casts']) && empty($this->searches['fillable']) && empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // } elseif (! empty($this->searches['attributes']) && empty($this->searches['casts']) && empty($this->searches['fillable']) && empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // } elseif (! empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts']) && empty($this->searches['fillable']) && empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // } elseif (! empty($this->searches['use_class']) && empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts']) && empty($this->searches['fillable']) && empty($this->searches['perPage'])) {
        //     $this->searches['HasOne'] .= PHP_EOL;
        // }

        $i = 0;
        foreach ($ho as $method => $HasOne) {
            $i++;
            // dd([
            //     '__METHOD__' => __METHOD__,
            //     '$method' => $method,
            //     '$HasOne' => $HasOne,
            // ]);
            $this->searches['HasOne'] .= $this->buildClass_HasOne_print($method, $HasOne);
            if ($i < count($ho)) {
                $this->searches['HasOne'] .= PHP_EOL;
            }
        }
    }

    protected function buildClass_HasOne_print(string $method, HasOne $HasOne): string
    {
        $related = $HasOne->related();

        if ($related !== class_basename($related)) {
            $related = '\\'.$this->parseClassInput($related);
        }

        return <<<PHP_CODE

    /**
     * {$HasOne->comment()}
     */
    public function {$method}(): HasOne
    {
        return \$this->hasOne(
            {$related}::class,
            '{$HasOne->foreignKey()}',
            '{$HasOne->localKey()}'
        );
    }
PHP_CODE;
    }
}
