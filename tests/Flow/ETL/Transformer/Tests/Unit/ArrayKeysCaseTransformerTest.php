<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer\Tests\Unit;

use Flow\ETL\CaseStyles;
use Flow\ETL\Row;
use Flow\ETL\Rows;
use Flow\ETL\Transformer\ArrayKeysCaseTransformer;
use PHPUnit\Framework\TestCase;

final class ArrayKeysCaseTransformerTest extends TestCase
{
    public function test_transforms_case_style_for_all_keys_in_array_entry() : void
    {
        $transformer = new ArrayKeysCaseTransformer(
            'arrayEntry',
            CaseStyles::SNAKE
        );

        $rows = $transformer->transform(
            new Rows(
                Row::create(
                    new Row\Entry\ArrayEntry(
                        'arrayEntry',
                        [
                            'itemId' => 1,
                            'itemStatus' => 'PENDING',
                            'itemEnabled' => true,
                            'itemVariants' => [
                                'variantStatuses' => [
                                    [
                                        'statusId' => 1000,
                                        'statusName' => 'NEW',
                                    ],
                                    [
                                        'statusId' => 2000,
                                        'statusName' => 'ACTIVE',
                                    ],
                                ],
                                'variantName' => 'Variant Name',
                            ],
                        ],
                    )
                )
            )
        );

        $this->assertEquals(
            [
                [
                    'arrayEntry' => [
                        'item_id' => 1,
                        'item_status' => 'PENDING',
                        'item_enabled' => true,
                        'item_variants' => [
                            'variant_statuses' => [
                                [
                                    'status_id' => 1000,
                                    'status_name' => 'NEW',
                                ],
                                [
                                    'status_id' => 2000,
                                    'status_name' => 'ACTIVE',
                                ],
                            ],
                            'variant_name' => 'Variant Name',
                        ],
                    ],
                ],
            ],
            $rows->toArray()
        );
    }
}
