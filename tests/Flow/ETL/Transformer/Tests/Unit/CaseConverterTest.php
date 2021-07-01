<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\Transformer\CaseConverter;
use PHPUnit\Framework\TestCase;

final class CaseConverterTest extends TestCase
{
    public function test_converts_case_type() : void
    {
        $converter = new CaseConverter();
        $string = 'this IS brilliant';

        $this->assertEquals('This_Is_Brilliant', $converter->convert($string, CaseConverter::STYLE_ADA));
        $this->assertEquals('thisIsBrilliant', $converter->convert($string, CaseConverter::STYLE_CAMEL));
        $this->assertEquals('THIS-IS-BRILLIANT', $converter->convert($string, CaseConverter::STYLE_COBOL));
        $this->assertEquals('this.is.brilliant', $converter->convert($string, CaseConverter::STYLE_DOT));
        $this->assertEquals('this-is-brilliant', $converter->convert($string, CaseConverter::STYLE_KEBAB));
        $this->assertEquals('this is brilliant', $converter->convert($string, CaseConverter::STYLE_LOWER));
        $this->assertEquals('THIS_IS_BRILLIANT', $converter->convert($string, CaseConverter::STYLE_MACRO));
        $this->assertEquals('ThisIsBrilliant', $converter->convert($string, CaseConverter::STYLE_PASCAL));
        $this->assertEquals('This is brilliant', $converter->convert($string, CaseConverter::STYLE_SENTENCE));
        $this->assertEquals('this_is_brilliant', $converter->convert($string, CaseConverter::STYLE_SNAKE));
        $this->assertEquals('This Is Brilliant', $converter->convert($string, CaseConverter::STYLE_TITLE));
        $this->assertEquals('This-Is-Brilliant', $converter->convert($string, CaseConverter::STYLE_TRAIN));
        $this->assertEquals('THIS IS BRILLIANT', $converter->convert($string, CaseConverter::STYLE_UPPER));
    }
}
