<?php

namespace GameSpecU\Metrics\Monitors;

use GameSpecU\Metrics\Enums\Type;

abstract class Monitor
{
    public Type $type;
    abstract public function register($app): void;

}
