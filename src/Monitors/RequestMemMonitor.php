<?php

namespace GameSpecU\Metrics\Monitors;

use GameSpecU\Metrics\Enums\Type;
use Illuminate\Foundation\Http\Events\RequestHandled;

class RequestMemMonitor extends Monitor
{
    public Type $type = Type::REQUEST_MEM;

    public function register($app): void
    {
        $app['events']->listen(RequestHandled::class, [$this, 'measure']);
    }

    public function measure(RequestHandled $event): void
    {
        $mem = round(memory_get_peak_usage(true) / 1024 / 1024, 1);

        \GameSpecU\Metrics\Metrics::record($this->type, $mem, [
            'host' => $event->request->getHost(),
            'method' => $event->request->method(),
            'path' => $event->request->path(),
        ]);

    }


}
