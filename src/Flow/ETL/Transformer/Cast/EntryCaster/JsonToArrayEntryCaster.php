<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Cast\EntryCaster;

use Flow\ETL\Row\Entry;
use Flow\ETL\Row\Entry\ArrayEntry;
use Flow\ETL\Transformer\Cast\EntryCaster;
use Flow\ETL\Transformer\Cast\ValueCaster;

/**
 * @psalm-immutable
 */
final class JsonToArrayEntryCaster implements EntryCaster
{
    private ValueCaster\JsonToArrayCaster $valueCaster;

    public function __construct()
    {
        $this->valueCaster = new ValueCaster\JsonToArrayCaster();
    }

    public function cast(Entry $entry) : Entry
    {
        return new ArrayEntry(
            $entry->name(),
            $this->valueCaster->cast($entry->value())
        );
    }
}
