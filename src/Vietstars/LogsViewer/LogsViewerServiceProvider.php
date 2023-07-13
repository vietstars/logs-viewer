<?php 
namespace Vietstars\LogsViewer;

use Illuminate\Support\ServiceProvider;

class LogsViewerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this, 'package')) {
            $this->package('vietstars/logs-viewer', 'logs-viewer', __DIR__ . '/../../');
        }

        if (method_exists($this, 'loadViewsFrom')) {
            $this->loadViewsFrom(__DIR__.'/../../views', 'logs-viewer');
        }
        
        if (method_exists($this, 'publishes')) {
            $this->publishes([
                   __DIR__.'/../../views' => base_path('/resources/views/vendor/logs-viewer'),
            ], 'views');
            $this->publishes([
                __DIR__.'/../../config/logviewer.php' => $this->config_path('logviewer.php'),
            ]);

        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
    
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    private function config_path($path = '')
    {
        return function_exists('config_path') ? config_path($path) : app()->basePath() . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

}
