<?php

namespace GameSpecU\Metrics\Monitors;

use GameSpecU\Metrics\Enums\Type;
use GameSpecU\Metrics\Metrics;
use Illuminate\Foundation\Http\Events\RequestHandled;

class RequestTimeMonitor extends Monitor
{
    public Type $type = Type::REQUEST_TIME;
    public function register($app): void
    {
        $app['events']->listen(RequestHandled::class, [$this, 'measure']);
    }

    public function measure(RequestHandled $event): void
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : $event->request->server('REQUEST_TIME_FLOAT');
        $duration = $startTime ? floor((microtime(true) - $startTime) * 1000) : null;


        Metrics::record($this->type, $duration, [
            'host' => $event->request->getHost(),
            'method' => $event->request->method(),
            'path' => $event->request->path(),
            'status' => $event->response->getStatusCode(),
            'memory' => round(memory_get_peak_usage(true) / 1024 / 1024, 1),
        ]);

    }


}
