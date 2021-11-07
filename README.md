# Attribute Routing plugin for CakePHP

Attribute routing for CakePHP 4.*

## Requirements

- CakePHP 4.x
- PHP 8.x :warning: This plugin using features that are available in PHP 8 and later.
- Cache (tested with redis), all routes are cached before can be used.

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require maymeow/cake-attribute-routing
```
## Configuring

Add new key `Controllers` somewhere in application configuration and provide
controller names where you want to use Attribute Routes.

```php
// app_local.php
'Controllers' => [
    \App\Controller\UsersController::class
]
```

Next step is update `routes.php` file. Add following into `scope('/')` right before
`fallback` route:

```php
// routes.php
$routes->scope('/', function (RouteBuilder $builder) {
// already deffined routes
//...
    /** @var array<\MayMeow\Routing\Attributes\Route> $mayMoewRoutes */
    $attributeRoutes = (new \MayMeow\Routing\Router())->getRoutes();

    foreach ($attributeRoutes as $attributeRoute) {
        $builder->connect($attributeRoute->getUri(), $attributeRoute->getAction());
    }
// ...
// fallback route
$builder->fallbacks();
}
```
## Usage

To define route add attribute `Route` with required path to the methods as follows:

```php
#[Route('/users')]
public function index()
{
    $users = $this->paginate($this->Users);

    $this->set(compact('users'));
}
```
### Wildcard parameters

Sometimes you need to pass parameters to your action in that case you can use wildcard route:

```php
#[Route('/users/edit/*')]
public function edit($id = null)
{
    $user = $this->Users->get($id, [
        'contain' => [],
    ]);
    // ...
}
```

:warning: If you're creating wildcard route you must define all other routers in sub-path.

### Named parameters

Instead of using wildcard you can use named parameters. This is usable wne you want to pass more than one
parameter to your controllers' action.

```php
#[Route('/users/:id/details', options: ['id' => '\d+', 'pass' => ['id']])]
public function view($id = null)
{
    $user = $this->Users->get($id, [
        'contain' => [],
    ]);

    $this->set(compact('user'));
}
```

When you're creating route with named parameter you have to pass options to tell router which parameters
you want to pass to controller.

Path to controller action `Controller::action` is generated automatically from
controller class name and method name;

## Troubleshooting

This plugin using cache for routes: all routes need to be cached before use. If you have problem with
routes try to clear cache.

Fond bug? Or do you want new feature? Open new Issue https://github.com/MayMeow/cake-attribute-routing/issues

License MIT
