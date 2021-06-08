<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\Rows;
use Flow\ETL\Transformer;

/**
 * @psalm-immutable
 */
final class SortEntriesTransformer implements Transformer
{
    public function transform(Rows $rows) : Rows
    {
        return $rows->sortEntries();
    }
}
