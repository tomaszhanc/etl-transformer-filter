<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\CaseStyles;
use Flow\ETL\Exception\InvalidArgumentException;
use Flow\ETL\Exception\RuntimeException;
use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer;
use Flow\ETL\Transformer\Factory\NativeEntryFactory;
use Jawira\CaseConverter\Convert;

/**
 * @psalm-immutable
 */
final class ArrayKeysCaseTransformer implements Transformer
{
    private string $arrayEntryName;

    private string $style;

    private EntryFactory $entryFactory;

    public function __construct(
        string $arrayEntryName,
        string $style,
        EntryFactory $entryFactory = null
    ) {
        /** @psalm-suppress ImpureFunctionCall */
        if (!\class_exists('Jawira\CaseConverter\Convert')) {
            throw new RuntimeException("Jawira\CaseConverter\Convert class not found, please add jawira/case-converter dependency to the project first.");
        }

        if (!\in_array($style, CaseStyles::ALL, true)) {
            throw new InvalidArgumentException("Unrecognized style {$style}, please use one of following: " . \implode(', ', CaseStyles::ALL));
        }

        $this->arrayEntryName = $arrayEntryName;
        $this->style = $style;
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
            /** @phpstan-ignore-next-line */
            $newKey = \is_string($key) ? (string) \call_user_func([new Convert($key), 'to' . \ucfirst($this->style)]) : $key;

            if (\is_array($value)) {
                $value = $this->convertArrayKeysCase($value);
            }

            $newArray[$newKey] = $value;
        }

        return $newArray;
    }
}
