<?php
declare(strict_types=1);

namespace MayMeow\Routing;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use MayMeow\Routing\Attributes\Route;

/**
 * Plugin for MayMeow\Routing
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        $routes->plugin(
            'MayMeow/Routing',
            ['path' => '/may-meow/routing'],
            function (RouteBuilder $builder) {
                // Add custom routes here

                $builder->fallbacks();
            }
        );

        // load Attribute routes
        $routes->scope('/', function (RouteBuilder $builder) {

            /** @var array<Route> $mayMoewRoutes */
            $attributeRoutes = (new \MayMeow\Routing\Router())->getRoutes();

            foreach ($attributeRoutes as $attributeRoute) {
                $builder->connect($attributeRoute->getUri(), $attributeRoute->getAction(), $attributeRoute->getOptions());
            }

            $builder->fallbacks();

        });

        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param \Cake\Http\MiddlewareQueue $middleware The middleware queue to update.
     * @return \Cake\Http\MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        // Add your middlewares here

        return $middlewareQueue;
    }
}
