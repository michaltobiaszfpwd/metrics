<?php

namespace GameSpecU\Metrics;

use GameSpecU\Metrics\Enums\Type;
use GameSpecU\Metrics\Models\Measurement;
use GameSpecU\Metrics\Monitors\RequestMemMonitor;
use GameSpecU\Metrics\Monitors\RequestTimeMonitor;
use Illuminate\Contracts\Foundation\Application;

class Metrics
{
    public static array $measurementsQueue = [];

    public static function register($app): void
    {
        static::registerMonitors($app);
        static::storeEntriesAfterResponse($app);
    }

    protected static function registerMonitors($app)
    {
        $monitors = [
            RequestMemMonitor::class,
            RequestTimeMonitor::class,
        ];

        foreach ($monitors as $monitor) {
            $app->make($monitor)->register($app);
        }
    }

    protected static function storeEntriesAfterResponse(Application $app): void
    {
        $app->terminating(function () {
            Metrics::storeEntries();
        });
    }

    protected static function storeEntries(): void
    {
        Measurement::insert(
            collect(static::$measurementsQueue)->map(function ($measurement) {
                return [
                    'type' => $measurement['type'],
                    'value' => $measurement['value'],
                    'context' => json_encode($measurement['context']),
                ];
            })->toArray());
    }

    public static function record(
        Type $type,
        ?int $value = null,
        ?array $context = null
    ): void {

        static::$measurementsQueue[] = [
            'type' => $type,
            'value' => $value,
            'context' => $context,
        ];
    }
}
