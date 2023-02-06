<?php

namespace GameSpecU\Metrics\Enums;

enum Aggregate: string
{
    case AVG = 'avg';
    case SUM = 'sum';
    case MIN = 'min';
    case MAX = 'max';
    case COUNT = 'count';
    case P90 = 'p90';
    case P95 = 'p95';
    case P99 = 'p99';
    case MEDIAN = 'median';
    case STD = 'std';


    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

