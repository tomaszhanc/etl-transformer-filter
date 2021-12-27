<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Cast\EntryCaster;

use Flow\ETL\Row\Entry;
use Flow\ETL\Row\Entry\StringEntry;
use Flow\ETL\Transformer\Cast\EntryCaster;
use Flow\ETL\Transformer\Cast\ValueCaster;

/**
 * @psalm-immutable
 */
final class AnyToStringEntryCaster implements EntryCaster
{
    private ValueCaster\AnyToStringCaster $valueCaster;

    public function __construct()
    {
        $this->valueCaster = new ValueCaster\AnyToStringCaster();
    }

    public function cast(Entry $entry) : Entry
    {
        return new StringEntry(
            $entry->name(),
            $this->valueCaster->cast($entry->value())
        );
    }
}
