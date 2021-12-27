<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Cast\ValueCaster;

use Flow\ETL\Transformer\Cast\ValueCaster;

/**
 * @psalm-immutable
 */
final class AnyToStringCaster implements ValueCaster
{
    public function cast($value) : string
    {
        /** @phpstan-ignore-next-line */
        return (string) $value;
    }
}
