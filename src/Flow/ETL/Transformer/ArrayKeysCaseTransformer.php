<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\Exception\InvalidArgumentException;
use Flow\ETL\Exception\RuntimeException;
use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer;
use Flow\ETL\Transformer\Factory\NativeEntryFactory;

/**
 * @psalm-immutable
 */
final class ArrayKeysCaseTransformer implements Transformer
{
    private string $arrayEntryName;

    private string $style;

    private CaseConverter $caseConverter;

    private EntryFactory $entryFactory;

    public function __construct(
        string $arrayEntryName,
        string $style,
        EntryFactory $entryFactory = null
    ) {
        if (!\in_array($style, CaseConverter::STYLES, true)) {
            throw new InvalidArgumentException("Unrecognized style {$style}, please use one of following: " . \implode(', ', CaseConverter::STYLES));
        }

        $this->arrayEntryName = $arrayEntryName;
        $this->style = $style;
        $this->caseConverter = new CaseConverter();
        $this->entryFactory = $entryFactory ?? new NativeEntryFactory();
    }

    public function transform(Rows $rows) : Rows
    {
        /**
         * @psalm-var pure-callable(Row $row) : Row $transformer
         */
        $transformer = function (Row $row) : Row {
            $arrayEntry = $row->get($this->arrayEntryName);

            if (!$arrayEntry instanceof Row\Entry\ArrayEntry) {
                $entryClass = \get_class($arrayEntry);

                throw new RuntimeException("{$this->arrayEntryName} is not ArrayEntry but {$entryClass}");
            }

            return $row->set(
                $this->entryFactory->createEntry(
                    $arrayEntry->name(),
                    $this->convertArrayKeysCase($arrayEntry->value())
                )
            );
        };

        return $rows->map($transformer);
    }

    /**
     * @param array<mixed> $array
     *
     * @return array<mixed>
     */
    private function convertArrayKeysCase(array $array) : array
    {
        $newArray = [];

        /** @psalm-suppress MixedAssignment */
        foreach ($array as $key => $value) {
            $newKey = \is_string($key) ? $this->caseConverter->convert($key, $this->style) : $key;

            if (\is_array($value)) {
                $value = $this->convertArrayKeysCase($value);
            }

            $newArray[$newKey] = $value;
        }

        return $newArray;
    }
}
