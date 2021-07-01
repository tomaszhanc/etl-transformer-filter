<?php

declare(strict_types=1);

namespace Flow\ETL\Transformer;

use Flow\ETL\ArrayKeyTransformer;
use Jawira\CaseConverter\Convert;
use PHPUnit\Framework\TestCase;

final class ArrayKeyTransformerTest extends TestCase
{
    public function test_transform_all_keys_to_snake_case() : void
    {
        $transformer = new ArrayKeyTransformer(
            fn (string $key) : string => (new Convert($key))->toSnake()
        );

        $this->assertEquals(
            [
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
            $transformer->transform([
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
            ]),
        );
    }
}
