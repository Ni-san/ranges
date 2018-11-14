<?php

class RangeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function calculateReturnsZeroOnEmptyData(): void
    {
        $rangeService = new \app\RangeService([]);

        $this->assertSame(0, $rangeService->calculate(0, 100));
    }

    /**
     * @test
     */
    public function calculateOneElement(): void
    {
        $rangeService = new \app\RangeService([
            [
                'start' => 1,
                'end' => 3,
            ]
        ]);

        $this->assertSame(1, $rangeService->calculate(0, 100));
        $this->assertSame(0, $rangeService->calculate(4, 100));
    }

    /**
     * @test
     * @dataProvider provider
     *
     * @param array $items
     * @param $start
     * @param $end
     * @param $expected
     */
    public function calculation(array $items, $start, $end, $expected): void
    {
        $rangeService = new \app\RangeService($items);

        $actual = $rangeService->calculate($start, $end);
        $this->assertSame($expected, $actual);
    }

    /**
     * @var array $set1
     * _***______
     * 0123456789
     */
    private static $set1 = [['start' => 1, 'end' => 3]];

    /**
     * @var array $set2
     * _*****___________________
     * _____***_________________
     * _____******______________
     * ||||||||||  |  |  |  |  |
     * 0123456789 12 15 18 21 24
     */
    private static $set2 = [
        ['start' => 1, 'end' => 5],
        ['start' => 5, 'end' => 7],
        ['start' => 5, 'end' => 10],
    ];

    /**
     * @var array $set3
     * _*****___________________
     * __*******________________
     * ___******________________
     * ______***________________
     * ________***______________
     * __________________***____
     * ||||||||||  |  |  |  |  |
     * 0123456789 12 15 18 21 24
     */
    private static $set3 = [
        ['start' => 1, 'end' => 5],
        ['start' => 2, 'end' => 8],
        ['start' => 3, 'end' => 8],
        ['start' => 6, 'end' => 8],
        ['start' => 8, 'end' => 10],
        ['start' => 18, 'end' => 20],
    ];

    public function provider(): array
    {
        return [
            [
                'items' => self::$set1,
                'start' => 0,
                'end' => 3,
                'expected' => 1,
            ],

            [
                'items' => self::$set2,
                'start' => 0,
                'end' => 3,
                'expected' => 1,
            ],
            [
                'items' => self::$set2,
                'start' => 0,
                'end' => 6,
                'expected' => 3,
            ],
            [
                'items' => self::$set2,
                'start' => 2,
                'end' => 7,
                'expected' => 3,
            ],
            [
                'items' => self::$set2,
                'start' => 5,
                'end' => 7,
                'expected' => 3,
            ],
            [
                'items' => self::$set2,
                'start' => 6,
                'end' => 7,
                'expected' => 2,
            ],
            [
                'items' => self::$set2,
                'start' => 7,
                'end' => 12,
                'expected' => 2,
            ],
            [
                'items' => self::$set2,
                'start' => 8,
                'end' => 12,
                'expected' => 1,
            ],
            [
                'items' => self::$set2,
                'start' => 11,
                'end' => 12,
                'expected' => 0,
            ],


            [
                'items' => self::$set3,
                'start' => 0,
                'end' => 2,
                'expected' => 2,
            ],
            [
                'items' => self::$set3,
                'start' => 0,
                'end' => 3,
                'expected' => 3,
            ],
            [
                'items' => self::$set3,
                'start' => 2,
                'end' => 7,
                'expected' => 3,
            ],
            [
                'items' => self::$set3,
                'start' => 3,
                'end' => 4,
                'expected' => 3,
            ],
            [
                'items' => self::$set3,
                'start' => 2,
                'end' => 8,
                'expected' => 4,
            ],
            [
                'items' => self::$set3,
                'start' => 6,
                'end' => 12,
                'expected' => 4,
            ],
            [
                'items' => self::$set3,
                'start' => 7,
                'end' => 12,
                'expected' => 4,
            ],
            [
                'items' => self::$set3,
                'start' => 8,
                'end' => 12,
                'expected' => 4,
            ],
            [
                'items' => self::$set3,
                'start' => 9,
                'end' => 12,
                'expected' => 1,
            ],
            [
                'items' => self::$set3,
                'start' => 9,
                'end' => 122,
                'expected' => 1,
            ],
        ];
    }
}
