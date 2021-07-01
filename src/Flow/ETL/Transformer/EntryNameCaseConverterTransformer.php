<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\Exception\InvalidArgumentException;
use Flow\ETL\Row;
use Flow\ETL\Row\Entry;
use Flow\ETL\Rows;
use Flow\ETL\Transformer;

/**
 * @psalm-immutable
 */
final class EntryNameCaseConverterTransformer implements Transformer
{
    private string $style;

    private CaseConverter $caseConverter;

    public function __construct(string $style)
    {
        if (!\in_array($style, CaseConverter::STYLES, true)) {
            throw new InvalidArgumentException("Unrecognized style {$style}, please use one of following: " . \implode(', ', CaseConverter::STYLES));
        }

        $this->style = $style;
        $this->caseConverter = new CaseConverter();
    }

    public function transform(Rows $rows) : Rows
    {
        /** @psalm-var pure-callable(Row $row) : Row $rowTransformer */
        $rowTransformer = function (Row $row) : Row {
            return $row->map(function (Entry $entry) : Entry {
                return $entry->rename($this->caseConverter->convert($entry->name(), $this->style));
            });
        };

        return $rows->map($rowTransformer);
    }
}
