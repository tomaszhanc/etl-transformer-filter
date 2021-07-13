<?php declare(strict_types=1);

namespace Flow\ETL\Transformer\Filter\Filter\ValidValue;

interface Validator
{
    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value) : bool;
}