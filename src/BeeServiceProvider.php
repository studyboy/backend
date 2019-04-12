<?php
/**
|----------------------------------------------
| Bee admin 
|----------------------------------------------
| @Author: damicook
| @E-mail: johngao@qq.com
| @Date:   2019-04-11 23:59:21
| @Last Modified by:   gsw
| @Last Modified time: 2019-04-12 09:52:35
|----------------------------------------------
 */
namespace Bee\Admin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BeeServiceProvider extends ServiceProvider
{

    protected $namespace ="Bee\\Admin\\Http\\Controllers";

    protected $commands =[
    ];
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //替换laravel admin的默认模版
        app('view')->prependNamespace('admin', __DIR__.'/../resources/views');

        //将参数配置替换默认配置文件
        $this->mergeConfigFrom(
            __DIR__.'/../config/bee.php', 'bee.bee'
        );
        
        //执行命令时候，自动发布静态资源到对应目录中
        $this->publishResources();

        //如果有数据库文件需迁移
        $this->registerMigrationsPath();

        //注册文件的存储路径
        $this->registerBeeDiskPath();

        //引入路由设置
        $this->mapWebRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //注册具体的实现类
        $this->app->singleton('beeadmin', function(){
            return new Beeadmin;
        });
    }

    protected function mapWebRoutes(){

        $attrs = [
            'prefix'        => config('admin.route.prefix'),
            'namespace'     => $this->namespace,
            'middleware'    => config('admin.route.middleware'),
        ];

        Route::group($attrs, function($router){

            // $router->group([], function ($router) {

            //     $router->resource('auth/users', 'UserController');

            //     $router->resource('auth/menu', 'MenuController', ['except' => ['create']]);

            // });

            $router->get('login', 'AuthAdminController@getLogin')->name('auth.admin.login');

            $router->get('auth/login', 'AuthAdminController@getLogin')->name('auth.admin.login');

            $router->post('auth/login', 'AuthAdminController@postLogin')->name('auth.admin.login.post');

            $router->post('logout', 'AuthAdminController@getLogout');

            $router->get('auth/setting', 'AuthAdminController@getSetting');

            $router->put('auth/setting', 'AuthAdminController@putSetting');
        });

        // Route::group(['namespace' => $this->namespace], function ($router) {
        //     $router->post('getMobile', 'AuthAdminController@getMobile');

        //     $router->group(['prefix' => 'export'], function () use ($router) {
        //         $router->get('/', 'ExportController@index')->name('admin.export.index');
        //         $router->get('downLoadFile', 'ExportController@downLoadFile')->name('admin.export.downLoadFile');
        //     });
        // });
    }
    protected function publishResources(){

        if($this->app->runningInConsole()){

            $this->publishes([
                __DIR__.'/../config/bee.php' => config_path('bee/bee.php')
            ]);

            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/bee')
            ]);
        }
    }
    protected function registerMigrationsPath(){

        return $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
    protected function registerBeeDiskPath(){

        $filesystems = config('filesystems');

        return $this->app['config']->set(
            'filesystems.disks', 
            array_merge($filesystems['disks'], config('bee.bee')['disks'])
        );
    }
}
