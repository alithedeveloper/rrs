<?php

namespace Tureki\RRS\Tests;

use Tureki\RRS\Tests\Base;
use Tureki\RRS\ReactRenderServer;
use Tureki\RRS\ReactRenderServerServiceProvider;

class ReactRenderServerTest extends Base
{
    public function testComponent()
    {
        $app = $this->getApplication();
        $provider = new ReactRenderServerServiceProvider($app);
        $provider->register();

        $app['config']->set('react-render-server.host', __DIR__ . '/data/');
        $app['config']->set('react-render-server.port', null);

        $rrs = $app->make(ReactRenderServer::class);

        $this->assertEquals($rrs->component('Test'), 'Test');
    }
}
