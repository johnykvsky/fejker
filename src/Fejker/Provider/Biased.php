<?php

declare(strict_types=1);

namespace Fejker\Provider;

class Biased extends Base
{
    /**
     * Returns a biased integer between $min and $max (both inclusive).
     * The distribution depends on $function.
     *
     * The algorithm creates two doubles, x ∈ [0, 1], y ∈ [0, 1) and checks whether the
     * return value of $function for x is greater than or equal to y. If this is
     * the case the number is accepted and x is mapped to the appropriate integer
     * between $min and $max. Otherwise two new doubles are created until the pair
     * is accepted.
     *
     * @param int      $min      Minimum value of the generated integers.
     * @param int      $max      Maximum value of the generated integers.
     * @param callable $function A function mapping x ∈ [0, 1] onto a double ∈ [0, 1]
     *
     * @return int An integer between $min and $max.
     */
    public function biasedNumberBetween(int $min = 0, int $max = 100, $function = 'sqrt'): int
    {
        do {
            $x = mt_rand() / mt_getrandmax();
            $y = mt_rand() / (mt_getrandmax() + 1);
        } while (call_user_func($function, $x) < $y);

        return (int) floor($x * ($max - $min + 1) + $min);
    }

    protected static function unbiased(): int
    {
        return 1;
    }

    protected static function linearLow($x): int|float
    {
        return 1 - $x;
    }

    protected static function linearHigh($x): int|float
    {
        return $x;
    }
}
