<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;;


class CheckForMaintenanceMode
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'adminlogin',
        'adminsubmit/*'
    ];
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance() && !$this->isBackendRequest($request)) {
            $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);

            throw new MaintenanceModeException($data['time'], $data['retry'], $data['message']);
        }

        return $next($request);
    }

    private function isBackendRequest($request)
    {
        // dd($request->is('application/*'));
        return ($request->is('*/application/*') or $request->is('/*') or $request->is('adminlogin/*') or $request->is('adminsubmit/*'));
    }
}
