<?php

namespace Tureki\RRS\Tests;

use Tureki\RRS\Tests\Base;
use Tureki\RRS\ReactRenderServerServiceProvider;

class ReactRenderServerServiceProviderTest extends Base
{
    public function testConfig()
    {
        $config = include $this->root . '/config/config.php';

        $app = $this->getApplication();
        $provider = new ReactRenderServerServiceProvider($app);
        $provider->register();

        $this->assertTrue($config === $app['config']->get('react-render-server'));
    }
}
