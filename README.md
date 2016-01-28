## RRS (ReactRenderServer)

[![Build Status](https://travis-ci.org/tureki/rrs.svg)](https://travis-ci.org/tureki/rrs)
[![Coverage Status](https://coveralls.io/repos/github/tureki/rrs/badge.svg)](https://coveralls.io/github/tureki/rrs)
[![Latest Stable Version](https://poser.pugx.org/tureki/rrs/v/stable)](https://packagist.org/packages/tureki/rrs)
[![Latest Unstable Version](https://poser.pugx.org/tureki/rrs/v/unstable)](https://packagist.org/packages/tureki/rrs)
[![License](https://poser.pugx.org/tureki/rrs/license)](https://packagist.org/packages/tureki/rrs)

**RRS** is package for generate React Render Server Boilerplate with Laravel/Lumen. It can let us easily create React`{.js|.jsx}` files in project and render components seamlessly on the server side within Blade Template.

If this package helpful and save your time. Do not forget star it :)

> **Note:** React Render Server is an independent Node.js Application.


## Requirements
* PHP 5.5.9+
* Node 0.10.0+


## Installation
Require this package with Composer.
```shell
composer require tureki/rrs
```


## Configuration
Once Composer has installed or updated your packages you need to register **RRS** with Laravel/Lumen itself.


### Laravel
Open up `config/app.php`.

`Register Service Provider`
```php
'providers' => [
  ...
  Tureki\RRS\ReactRenderServerServiceProvider::class,
]
```

`Facade Aliases`
```php
'aliases' => [
  ...
  'ReactRenderServer' => Tureki\RRS\Facades\ReactRenderServer::class,
]
```


### Lumen
Open up `bootstrap/app.php` then uncomment `$app->withFacades();`.

`Register Service Provider`
```php
$app->register(Tureki\RRS\ReactRenderServerServiceProvider::class);
```

`Facade Aliases`
```php
class_alias(Tureki\RRS\Facades\ReactRenderServer::class, 'ReactRenderServer');
```

---

Run Artisan copy the package files when you finished Laravel/Lumen setting.
```shell
php artisan vendor:publish --tag=rrs
```

> **Lumen Project:** You need install [irazasyed/larasupport](https://github.com/irazasyed/larasupport) package before run `artisan vendor:publish` command. Otherwise, you have to manual copy package file.

The default configuration file at `config/react-render-server.php`, ReactRenderServer will been generated at `resource/assets/rrs` directory.

Then install ReactRenderServer require package.
```shell
npm install -prefix resource/assets/rrs
```

And that's it!


## Usage
Once npm has installed, You need start **RRS**.
```shell
npm start -prefix resource/assets/rrs
```
> **Note:** You can use `PM2` or other process manager tool to manage RRS.

---

Run `php artisan tinker`:
```shell
Psy Shell
>>> ReactRenderServer::component('HelloWorld');
```

Output:
```
"<div data-reactid=".XXX" data-react-checksum="-XXX">React Render Server -> Hello World :)</div>"
```

---

Blade Template:
```php
{!! React::component('HelloWorld', $props) !!}
```

---

Lumen:
```php
$app->get('/', function () {
  return ReactRenderServer::component('HelloWorld');
});
```


## ReactJS Component
You can create React`{.js,.jsx}` files at `resource/assets/rrs/src`.

For example:

Create `Button.jsx` at `resource/assets/rrs/src/ui/`.
```js
import React from 'react';

export class Button extends React.Component {
  render() {
    return (<button>Click Me</button>);
  }
};

module.exports = HelloWorld;
```

Create `App.jsx` at `resource/assets/rrs/src/`.
```js
import React from 'react';
import Button from 'ui/Button';

export class Button extends React.Component {
  render() {
    return (
      <div>
        Application <Button/>
      </div>
    );
  }
};

module.exports = HelloWorld;
```

Get `App` component:
```
ReactRenderServer::component('App');
```

Get `Button` component:
```
ReactRenderServer::component('ui/Button');
```

> **Note:** If you are JS professional. You can explore `resource/assets/rrs` directory change **RRS** config.


## Workflow With Elixir
You can also integrate Elixir's workflow auto `start|stop|reload` **RRS** when you in development.

The following is sample:

Run:
```shell
npm install browser-sync --save-dev
npm install gulp-connect-php --save-dev
npm install gulp-util --save-dev
npm install pm2 --save-dev
```

Open up `gulpfile.js` and change it:
```js
var conn   = require('gulp-connect-php');
var gutils = require('gulp-util');
var elixir = require('laravel-elixir');

//Start PHP Web Server.
elixir.extend('serve', function(options) {
  if (gutils.env._.indexOf('watch') > -1) {
    conn.server(options);
  }
  new elixir.Task('serve', function() {}).watch();
});

//Start React Render Server.
elixir.extend('renderServer', function() {
  // get Elixir browsery-sync instance.
  var bs = require('browser-sync').instances.pop();
  var pm2 = require('pm2');
  var rrs = elixir.config.assetsPath + '/rrs';
  var rrsName = 'renderServer';
  var rrsConfig = {
    name: rrsName,
    script: rrs + '/server.js',
    cwd: rrs,
    watch: true,
    env: {
      NODE_PATH: 'src'
    }
  };
  //Remove process when stop development.
  process.on('SIGINT', function() {
    pm2.connect(function(err) {
      pm2.delete(rrsName, function(err) {
        process.exit(0);
      });
    });
  });

  new elixir.Task(rrsName, function() {
    pm2.connect(function(err) {
      pm2.list(function(err, list) {
        for (var key in list) {
          if (list[key].name == rrsName) {
            //browsery-sync reload when file change.
            setTimeout(function() {
              bs.reload();
            }, 100);
            pm2.disconnect();
            return;
          }
        }
        //auto start RRS
        pm2.start(rrsConfig, pm2.disconnect);
      });
    });
  }).watch([rrs + '/**/*']);

});

elixir(function(mix) {
  mix
      .renderServer()
      .serve({
        base: 'public',
        port: 8000,
      })
      .browserSync({
        proxy: 'localhost:' + 8000
      });
});
```

Run `gulp && gulp watch` (It will automatic open in browser)

> **Note:** This is just a sample, You can change it.


## Test
```
./vendor/bin/phpunit -c phpunit.xml
```

## Contributing
Welcome [PR](https://github.com/tureki/rrs/pulls) and play it :)

> **Coding Style:** Follows the PSR-2 coding standard and the PSR-4 autoloading standard.

## License
MIT © [tureki](https://github.com/tureki)
