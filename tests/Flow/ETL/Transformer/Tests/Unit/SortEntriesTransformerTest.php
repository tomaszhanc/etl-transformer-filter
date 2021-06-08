<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer\SortEntriesTransformer;
use PHPUnit\Framework\TestCase;

/**
 * @psalm-immutable
 */
final class SortEntriesTransformerTest extends TestCase
{
    public function test_sorts_entries_by_name() : void
    {
        $transformer = new SortEntriesTransformer();

        $rows = $transformer->transform(new Rows(
            Row::create(
                new Row\Entry\IntegerEntry('id', 1),
                new Row\Entry\BooleanEntry('active', true),
                new Row\Entry\StringEntry('name', 'entry one'),
            ),
            Row::create(
                new Row\Entry\StringEntry('name', 'entry two'),
                new Row\Entry\IntegerEntry('id', 2),
                new Row\Entry\BooleanEntry('active', true),
            )
        ));

        $this->assertSame(
            [
                ['active' => true, 'id' => 1, 'name' => 'entry one'],
                ['active' => true, 'id' => 2, 'name' => 'entry two'],
            ],
            $rows->toArray()
        );
    }
}
