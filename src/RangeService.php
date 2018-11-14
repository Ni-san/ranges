<?php

namespace app;

class RangeService
{
    private $items;

    /**
     * @param array $items example:
     * [
     *     [
     *         start => 1,
     *         end => 5,
     *     ],
     *     [
     *         start => 5,
     *         end => 7,
     *     ],
     *     [
     *         start => 5,
     *         end => 10,
     *     ],
     * ]
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param int $start
     * @param int $end
     * @return int - max number of intersected items during period $start to $end
     */
    public function calculate(int $start, int $end): int
    {
        $map = [];
        foreach ($this->items as $item) {
            $map[$item['start']] = $map[$item['start']] ?? ['start' => 0, 'end' => 0];
            $map[$item['start']]['start']++;

            if ($item['end'] !== null) {
                $map[$item['end']] = $map[$item['end']] ?? ['start' => 0, 'end' => 0];
                $map[$item['end']]['end']++;
            }
        }

        ksort($map);

        // $map is ascending-ordered map like `time => events in this time`,
        // where events are starts or ends of rent items.
        // example:
        // [
        //     1 =>  ['start' => 1, 'end' => 0],
        //     5 =>  ['start' => 2, 'end' => 1],
        //     7 =>  ['start' => 0, 'end' => 1],
        //     10 => ['start' => 0, 'end' => 1],
        // ]

        $res = 0;
        $counter = 0;

        foreach ($map as $key => $item) {
            $counter += $item['start'];
            if ($key >= $start && $key <= $end) {
                $res = max($res, $counter);
            }
            $counter -= $item['end'];
        }

        return $res;
    }
}
