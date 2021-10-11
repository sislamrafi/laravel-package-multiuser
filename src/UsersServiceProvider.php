<?php

namespace Sislamrafi\Multiuser;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Arr;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

use \Symfony\Component\Console\Output\ConsoleOutput as cso;

class UsersServiceProvider extends ServiceProvider
{
    protected $namespace = 'Sislamrafi\\Multiuser\\app\\Http\\Controllers';
    protected $fileName = 'multi-user';

    public function boot()
    {
        $this->co = new cso;

        if ($this->app->runningInConsole()) {
            $this->publishMigrations();
            $this->publishes([
                __DIR__.'/public' => public_path('vendor/sislamrafi/'.$this->fileName),
            ], 'public');
            $this->publishes([
                __DIR__.'/config/multiuser.php' => config_path('multiuser.php'),
              ], 'config');
        }
        
        $this->registerRoutes();
        $this->registerMiddleware();
        $this->loadViewsFrom(__DIR__.'/resources/views', 'multiuser');
        //$this->verifyEmail();
    }

    public function register()
    {
        //$this->mergeConfigFrom(__DIR__.'/config/auth.php', 'auth');
    }

    protected function registerRoutes()
    {
        Route::middleware(['web'])  
                ->prefix('multiuser')
                ->name('multiuser.')
                ->namespace($this->namespace)
                ->group(__DIR__.'/routes/auth-routes.php');
    }

    protected function publishMigrations()
    {
        if (!$this->migrationExists('create_roles_table.php')) {
            $this->publishes([
              __DIR__ . '/database/migrations/create_roles_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_roles_table.php'),
              // you can add any number of migrations here
            ], 'migrations');
            $this->co->writeln("Migration created");
            return;
        }
    }

    protected function migrationExists($mgr)
    {
        $path = database_path('migrations/');
        $files = scandir($path);
        $pos = false;
        //$this->co->writeln("Searching migration : " . $mgr);
        foreach ($files as &$value) {
            //$this->co->writeln($value);
            $pos = strpos($value, $mgr);
            if ($pos !== false) {
                return true;
            }
        }
        return false;
    }

    protected function registerMiddleware()
    {
        
        $router = $this->app->make(Router::class);
        //$router->aliasMiddleware('auth-admin', \Sislamrafi\Multiuser\app\Http\Middlewares\AdminAuth::class);
        $router->aliasMiddleware('user-verified', \Sislamrafi\Multiuser\app\Http\Middlewares\AdminEmailVerify::class);
        //$router->pushMiddlewareToGroup('admin', \Sislamrafi\Admin\app\Http\Middlewares\AdminAuth::class);
    }

    
}
