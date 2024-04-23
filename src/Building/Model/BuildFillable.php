<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Stub\Building\Model;

/**
 * \Playground\Stub\Building\Model\BuildFillable
 */
trait BuildFillable
{
    protected function buildClass_fillable(): void
    {
        $fillable = $this->c->fillable();
        if (! $fillable) {
            return;
        }

        if (! empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        } elseif (! empty($this->searches['use_class']) && empty($this->searches['table']) && empty($this->searches['attributes']) && empty($this->searches['casts'])) {
            $this->searches['fillable'] .= PHP_EOL;
        }

        $code = PHP_EOL;

        foreach ($fillable as $attribute) {
            $code .= str_repeat(' ', 8);
            $code .= sprintf('\'%1$s\',', $attribute);
            $code .= PHP_EOL;
        }

        $code .= str_repeat(' ', 4);

        $this->searches['fillable'] .= sprintf('    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [%1$s];',
            $code
        );

        $this->searches['fillable'] .= PHP_EOL;
    }
}
