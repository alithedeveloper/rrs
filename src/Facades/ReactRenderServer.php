<?php

namespace Tureki\RRS\Facades;

use Illuminate\Support\Facades\Facade;

class ReactRenderServer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'react-render-server';
    }
}
