# Attribute Routing plugin for CakePHP

Attribute routing for CakePHP 4.*

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

Remember if you define wildcard route as  `#[Route('/users/*')]` you have to define
all other routes in sub-path.

Path to controller action `Controller::action` is generated automatically from
controller class name and method name;

License MIT
