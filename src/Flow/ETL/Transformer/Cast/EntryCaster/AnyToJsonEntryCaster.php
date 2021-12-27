<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Cast\EntryCaster;

use Flow\ETL\Row\Entry;
use Flow\ETL\Row\Entry\JsonEntry;
use Flow\ETL\Transformer\Cast\EntryCaster;
use Flow\ETL\Transformer\Cast\ValueCaster;

/**
 * @psalm-immutable
 */
final class AnyToJsonEntryCaster implements EntryCaster
{
    private ValueCaster\AnyToJsonCaster $valueCaster;

    public function __construct()
    {
        $this->valueCaster = new ValueCaster\AnyToJsonCaster();
    }

    public function cast(Entry $entry) : Entry
    {
        return new JsonEntry(
            $entry->name(),
            $this->valueCaster->cast($entry->value())
        );
    }
}
