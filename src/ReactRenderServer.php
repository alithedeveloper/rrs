<?php

namespace Tureki\RRS;

use Illuminate\Contracts\Config\Repository as Config;

class ReactRenderServer
{

    private $config;
    private $url;
    private $port;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->host   = $this->config->get('react-render-server.host');
        $this->port   = $this->config->get('react-render-server.port');
    }

    public function component($component, $data = [])
    {
        $props = json_encode($data);

        return $this->render('?component=' . urlencode($component) . '&props=' . urlencode($props));
    }

    private function render($uri)
    {
        $ctx = stream_context_create([
            'http'=> [
                'timeout' => $this->config->get('react-render-server.timeout'),
            ]
        ]);

        return file_get_contents($this->host . ($this->port ? ':' . $this->port : '') . $uri, false, $ctx);
    }
}
