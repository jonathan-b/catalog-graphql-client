<?php

namespace ArrowSphere\CatalogGraphQLClient\Tests\Helpers;

use ArrowSphere\CatalogGraphQLClient\Helpers\FilterHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class FilterHelperTest
 */
class FilterHelperTest extends TestCase
{
    public function providerGetSearchBodyFilters(): array
    {
        return [
            'empty'              => [
                'inputArray' => [],
                'expected'   => [],
            ],
            'oneValue'           => [
                'inputArray' => [
                    'test1' => 'val1',
                ],
                'expected'   => [
                    [
                        'name'  => 'test1',
                        'value' => 'val1',
                    ],
                ],
            ],
            'multipleValues'     => [
                'inputArray' => [
                    'test1' => [
                        'val1',
                        'val2',
                    ],
                ],
                'expected'   => [
                    [
                        'name'  => 'test1',
                        'value' => [
                            'val1',
                            'val2',
                        ],
                    ],
                ],
            ],
            'simpleNestedArray'  => [
                'inputArray' => [
                    'test1' => 'val1',
                    'test2' => [
                        'test2.1' => 'val2.1',
                        'test2.2' => 'val2.2',
                    ],
                ],
                'expected'   => [
                    [
                        'name'  => 'test1',
                        'value' => 'val1',
                    ],
                    [
                        'name'  => 'test2.test2.1',
                        'value' => 'val2.1',
                    ],
                    [
                        'name'  => 'test2.test2.2',
                        'value' => 'val2.2',
                    ],
                ],
            ],
            'complexNestedArray' => [
                'inputArray' => [
                    'test1' => 'val1',
                    'test2' => [
                        'test2.1' => 'val2.1',
                        'test2.2' => [
                            'test2.2.1' => 'val2.2.1',
                            'test2.2.2' => 'val2.2.2',
                        ],
                    ],
                ],
                'expected'   => [
                    [
                        'name'  => 'test1',
                        'value' => 'val1',
                    ],
                    [
                        'name'  => 'test2.test2.1',
                        'value' => 'val2.1',
                    ],
                    [
                        'name'  => 'test2.test2.2.test2.2.1',
                        'value' => 'val2.2.1',
                    ],
                    [
                        'name'  => 'test2.test2.2.test2.2.2',
                        'value' => 'val2.2.2',
                    ],
                ],
            ],
        ];
    }

    /**
     * @dataProvider providerGetSearchBodyFilters
     * @param array $inputArray
     * @param array $expected
     */
    public function testGetSearchBodyFilters(array $inputArray, array $expected): void
    {
        self::assertEquals($expected, (new FilterHelper($inputArray))->getSearchBodyFilters());
    }
}
