<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Cast\EntryCaster;

use Flow\ETL\Row\Entry;
use Flow\ETL\Row\Entry\FloatEntry;
use Flow\ETL\Transformer\Cast\EntryCaster;
use Flow\ETL\Transformer\Cast\ValueCaster;

/**
 * @psalm-immutable
 */
final class AnyToFloatEntryCaster implements EntryCaster
{
    private ValueCaster\AnyToFloatCaster $valueCaster;

    public function __construct()
    {
        $this->valueCaster = new ValueCaster\AnyToFloatCaster();
    }

    public function cast(Entry $entry) : Entry
    {
        return new FloatEntry(
            $entry->name(),
            $this->valueCaster->cast($entry->value())
        );
    }
}
