<?php

namespace Tureki\RRS\Tests;

use Illuminate\Foundation\Application;
// use Illuminate\View\Factory;
use Illuminate\Config\Repository;
use PHPUnit_Framework_TestCase;
use Mockery as m;

abstract class Base extends PHPUnit_Framework_TestCase
{
    protected $root;
    
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->root = realpath(__DIR__.'/../src');
    }

    public function tearDown()
    {
        m::close();
    }

    protected function getApplication($customConfig = [])
    {

        $app = new Application();
        $app->instance('path', __DIR__);
        $app['env'] = 'production';
        $app['path.config'] = $this->root . '/config';
        
        // Filesystem
        $files = m::mock('Illuminate\Filesystem\Filesystem');
        $app['files'] = $files;
        // View
        // $finder = m::mock('Illuminate\View\ViewFinderInterface');
        // $finder->shouldReceive('addExtension');
        // $app['view'] = new Factory(
            // new EngineResolver(),
            // $finder,
            // m::mock('Illuminate\Events\Dispatcher')
        // );

        // $config_data = include $config_file;
        
        // Config
        $app['config'] = new Repository([]);

        $app->bind('\Illuminate\Config\Repository', function () use ($app) {
            return $app['config'];
        });

        return $app;
    }
}
