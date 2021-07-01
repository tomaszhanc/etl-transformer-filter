<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\Exception\RuntimeException;
use Jawira\CaseConverter\Convert;

/**
 * @psalm-immutable
 */
final class CaseConverter
{
    public const STYLE_CAMEL = 'camel';

    public const STYLE_PASCAL = 'pascal';

    public const STYLE_SNAKE = 'snake';

    public const STYLE_ADA = 'ada';

    public const STYLE_MACRO = 'macro';

    public const STYLE_KEBAB = 'kebab';

    public const STYLE_TRAIN = 'train';

    public const STYLE_COBOL = 'cobol';

    public const STYLE_LOWER = 'lower';

    public const STYLE_UPPER = 'upper';

    public const STYLE_TITLE = 'title';

    public const STYLE_SENTENCE = 'sentence';

    public const STYLE_DOT = 'dot';

    public const STYLES = [
        self::STYLE_CAMEL,
        self::STYLE_PASCAL,
        self::STYLE_SNAKE,
        self::STYLE_ADA,
        self::STYLE_MACRO,
        self::STYLE_KEBAB,
        self::STYLE_TRAIN,
        self::STYLE_COBOL,
        self::STYLE_LOWER,
        self::STYLE_UPPER,
        self::STYLE_TITLE,
        self::STYLE_SENTENCE,
        self::STYLE_DOT,
    ];

    public function __construct()
    {
        /** @psalm-suppress ImpureFunctionCall */
        if (!\class_exists('Jawira\CaseConverter\Convert')) {
            throw new RuntimeException("Jawira\CaseConverter\Convert class not found, please add jawira/case-converter dependency to the project first.");
        }
    }

    public function convert(string $string, string $style) : string
    {
        switch ($style) {
            case self::STYLE_CAMEL:
                return (new Convert($string))->toCamel();
            case self::STYLE_PASCAL:
                return (new Convert($string))->toPascal();
            case self::STYLE_SNAKE:
                return (new Convert($string))->toSnake();
            case self::STYLE_ADA:
                return (new Convert($string))->toAda();
            case self::STYLE_MACRO:
                return (new Convert($string))->toMacro();
            case self::STYLE_KEBAB:
                return (new Convert($string))->toKebab();
            case self::STYLE_TRAIN:
                return (new Convert($string))->toTrain();
            case self::STYLE_COBOL:
                return (new Convert($string))->toCobol();
            case self::STYLE_LOWER:
                return (new Convert($string))->toLower();
            case self::STYLE_UPPER:
                return (new Convert($string))->toUpper();
            case self::STYLE_TITLE:
                return (new Convert($string))->toTitle();
            case self::STYLE_SENTENCE:
                return (new Convert($string))->toSentence();
            case self::STYLE_DOT:
                return (new Convert($string))->toDot();

            default:
                throw new RuntimeException("Unrecognized style {$style}, please use one of following: " . \implode(', ', self::STYLES));
        }
    }
}
