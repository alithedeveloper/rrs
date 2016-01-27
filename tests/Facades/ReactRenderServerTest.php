<?php

namespace Tureki\RRS\Tests\Facades;

use Tureki\RRS\Tests\Base;
use Tureki\RRS\ReactRenderServerServiceProvider;
use Tureki\RRS\Facades\ReactRenderServer;

class ReactRenderServerTest extends Base
{
    public function testFacadeInstance()
    {
        $this->bootApplication();

        $this->assertInstanceOf(
            'Tureki\RRS\ReactRenderServer',
            ReactRenderServer::getFacadeRoot()
        );
    }

    protected function bootApplication()
    {
        $app = $this->getApplication();
        
        $provider = new ReactRenderServerServiceProvider($app);
        $provider->register();
        $provider->boot();
        
        ReactRenderServer::setFacadeApplication($app);

        return $app;
    }
}
