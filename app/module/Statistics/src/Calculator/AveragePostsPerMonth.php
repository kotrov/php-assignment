<?php

declare(strict_types=1);

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

class AveragePostsPerMonth extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private array $totals = [];

    /**
     * @inheritDoc
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $key = $postTo->getDate()->format('\M\o\n\t\h M, Y');

        $this->totals[$key] = ($this->totals[$key] ?? 0) + 1;
    }

    /**
     * @inheritDoc
     */
    protected function doCalculate(): StatisticsTo
    {
        $sum = array_sum(array_values($this->totals));

        $value = $sum > 0 ? $sum / count($this->totals) : 0;

        return (new StatisticsTo())->setValue(round($value, 2));
    }
}
