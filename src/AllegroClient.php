<?php

namespace AwemaPL\AllegroClient;

use AwemaPL\AllegroClient\Admin\Sections\Settings\Models\Setting;
use AwemaPL\AllegroClient\Admin\Sections\Settings\Repositories\Contracts\SettingRepository;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use AwemaPL\AllegroClient\Contracts\AllegroClient as AllegroClientContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class AllegroClient implements AllegroClientContract
{
    /** @var Router $router */
    protected $router;

    /** @var SettingRepository $settings */
    protected $settings;

    public function __construct(Router $router, SettingRepository $settings)
    {
        $this->router = $router;
        $this->settings = $settings;
    }

    /**
     * Routes
     */
    public function routes()
    {
        if ($this->isActiveRoutes()) {
            if ($this->isActiveInstallationRoutes() && !$this->isMigrated()) {
                $this->installationRoutes();
            }
            if ($this->isActiveInstallationRoutes() && $this->isMigrated() && !$this->settings->exist()) {
                $this->installationDefaultSettingRoutes();
            }
            if ($this->isActiveApplicationRoutes()) {
                $this->applicationRoutes();
            }
            if ($this->isActiveAccountRoutes()) {
                $this->accountRoutes();
            }
            if ($this->isActiveSettingRoutes()) {
                $this->settingRoutes();
            }
            if ($this->isActiveCallbackRoutes()) {
                $this->callbackRoutes();
            }
        }
    }

    /**
     * Installation routes
     */
    protected function installationRoutes()
    {
        $prefix = config('allegro-client.routes.admin.installation.prefix');
        $namePrefix = config('allegro-client.routes.admin.installation.name_prefix');
        $this->router->prefix($prefix)->name($namePrefix)->group(function () {
            $this->router->get('/', '\AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Controllers\InstallationController@index')
                ->name('index');
            $this->router->post('/', '\AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Controllers\InstallationController@store')
                ->name('store');
        });
    }

    /**
     * Installation default setting routes
     */
    protected function installationDefaultSettingRoutes()
    {
        $prefix = config('allegro-client.routes.admin.installation.prefix');
        $namePrefix = config('allegro-client.routes.admin.installation.name_prefix');
        $this->router->prefix($prefix)->name($namePrefix)->group(function () {
            $this->router->get('/default-settings', '\AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Controllers\DefaultSettingController@index')
                ->name('index_default_setting');
            $this->router->post('/default-settings', '\AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Controllers\DefaultSettingController@store')
                ->name('store_default_setting');
        });
    }

    /**
     * Setting routes
     */
    protected function settingRoutes()
    {
        $prefix = config('allegro-client.routes.admin.setting.prefix');
        $namePrefix = config('allegro-client.routes.admin.setting.name_prefix');
        $middleware = config('allegro-client.routes.admin.setting.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\AllegroClient\Admin\Sections\Settings\Http\Controllers\SettingController@index')
                ->name('index');
            $this->router
                ->get('/applications', '\AwemaPL\AllegroClient\Admin\Sections\Settings\Http\Controllers\SettingController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\AllegroClient\Admin\Sections\Settings\Http\Controllers\SettingController@update')
                ->name('update');
        });
    }

    /**
     * Application routes
     */
    protected function applicationRoutes()
    {
        $prefix = config('allegro-client.routes.user.application.prefix');
        $namePrefix = config('allegro-client.routes.user.application.name_prefix');
        $middleware = config('allegro-client.routes.user.application.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\AllegroClient\User\Sections\Applications\Http\Controllers\ApplicationController@index')
                ->name('index');
            $this->router
                ->post('/', '\AwemaPL\AllegroClient\User\Sections\Applications\Http\Controllers\ApplicationController@store')
                ->name('store');
            $this->router
                ->get('/accounts', '\AwemaPL\AllegroClient\User\Sections\Applications\Http\Controllers\ApplicationController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\AllegroClient\User\Sections\Applications\Http\Controllers\ApplicationController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\AllegroClient\User\Sections\Applications\Http\Controllers\ApplicationController@delete')
                ->name('delete');
        });
    }

    /**
     * Account routes
     */
    protected function accountRoutes()
    {
        $prefix = config('allegro-client.routes.user.account.prefix');
        $namePrefix = config('allegro-client.routes.user.account.name_prefix');
        $middleware = config('allegro-client.routes.user.account.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@index')
                ->name('index');
            $this->router
                ->post('/', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@store')
                ->name('store');
            $this->router
                ->get('/accounts', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@scope')
                ->name('scope');
            $this->router
                ->patch('{id?}', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@update')
                ->name('update');
            $this->router
                ->delete('{id?}', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@delete')
                ->name('delete');
            $this->router
                ->post('/reconnect/{id?}', '\AwemaPL\AllegroClient\User\Sections\Accounts\Http\Controllers\AccountController@reconnect')
                ->name('reconnect');
        });
    }


    /**
     * Callback routes
     */
    protected function callbackRoutes()
    {
        $prefix = config('allegro-client.routes.user.callback.prefix');
        $namePrefix = config('allegro-client.routes.user.callback.name_prefix');
        $middleware = config('allegro-client.routes.user.callback.middleware');
        $this->router->prefix($prefix)->name($namePrefix)->middleware($middleware)->group(function () {
            $this->router
                ->get('/add/{id}', '\AwemaPL\AllegroClient\User\Sections\Callbacks\Http\Controllers\CallbackController@add')
                ->name('add');
        });
    }

    /**
     * Can installation
     *
     * @return bool
     */
    public function canInstallation()
    {
        $canForPermission = $this->canInstallForPermission();
        return $this->isActiveRoutes()
            && $this->isActiveInstallationRoutes()
            && $canForPermission
            && !$this->isMigrated();
    }

    /**
     * Can installation default settings
     *
     * @return mixed
     */
    public function canInstallationDefaultSettings(){
        $canForPermission = $this->canInstallForPermission();
        return !$this->canInstallation() && $this->isActiveRoutes()
            && $this->isActiveInstallationRoutes()
            && $canForPermission
            && !$this->settings->exist();
    }

    /**
     * Is migrated
     *
     * @return bool
     */
    public function isMigrated()
    {
        $tablesInDb = array_map('reset', \DB::select('SHOW TABLES'));

        $tables = array_values(config('allegro-client.database.tables'));
        foreach ($tables as $table){
            if (!in_array($table, $tablesInDb)){
                return false;
            }
        }
        return true;
    }

    /**
     * Is active routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveRoutes()
    {
        return config('allegro-client.routes.active');
    }

    /**
     * Is active setting routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveSettingRoutes()
    {
        return config('allegro-client.routes.admin.setting.active');
    }

    /**
     * Is active installation routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveInstallationRoutes()
    {
        return config('allegro-client.routes.admin.installation.active');
    }


    /**
     * Is active application routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveApplicationRoutes()
    {
        return config('allegro-client.routes.user.application.active');
    }


    /**
     * Is active account routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private function isActiveAccountRoutes()
    {
        return config('allegro-client.routes.user.account.active');
    }

    /**
     * Is active callback routes
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function isActiveCallbackRoutes()
    {
        return config('allegro-client.routes.user.callback.active');
    }

    /**
     * Include lang JS
     */
    public function includeLangJs()
    {
        $lang = config('indigo-layout.frontend.lang', []);
        $lang = array_merge_recursive($lang, app(\Illuminate\Contracts\Translation\Translator::class)->get('allegro-client::js')?:[]);
        app('config')->set('indigo-layout.frontend.lang', $lang);
    }

    /**
     * Can install for permission
     *
     * @return bool
     */
    private function canInstallForPermission()
    {
        $userClass = config('auth.providers.users.model');
        if (!method_exists($userClass, 'hasRole')) {
            return true;
        }

        if ($user = request()->user() ?? null){
            return $user->can(config('allegro_client.admin.installation.auto_redirect.permission'));
        }

        return false;
    }

    /**
     * Menu merge in navigation
     */
    public function menuMerge()
    {
        if ($this->canMergeMenu()){
            $allegroClientMenu = config('allegro-client-menu.navs', []);
            $navTemp = config('temp_navigation.navs', []);
            $nav = array_merge_recursive($navTemp, $allegroClientMenu);
            config(['temp_navigation.navs' => $nav]);
        }
    }

    /**
     * Can merge menu
     *
     * @return boolean
     */
    private function canMergeMenu()
    {
        return !!config('allegro-client-menu.merge_to_navigation') && self::isMigrated();
    }

    /**
     * Execute package migrations
     */
    public function migrate()
    {
         Artisan::call('migrate', ['--force' => true, '--path'=>'vendor/awema-pl/module-allegro-client/database/migrations']);
    }

    /**
     * Install package
     *
     * @param array $data
     */
    public function install(array $data)
    {
        $this->migrate();
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Install default settings package
     *
     * @param array $data
     */
    public function installDefaultSettings(array $data){

        $this->settings->create([
            'key' => 'default_client_id',
            'value' =>$data['default_client_id']
        ]);
        $this->settings->create([
            'key' => 'default_client_secret',
            'value' =>$data['default_client_secret']
        ]);
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
    }

    /**
     * Add permissions for module permission
     */
    public function mergePermissions()
    {
       if ($this->canMergePermissions()){
           $allegroClientPermissions = config('allegro-client.permissions');
           $tempPermissions = config('temp_permission.permissions', []);
           $permissions = array_merge_recursive($tempPermissions, $allegroClientPermissions);
           config(['temp_permission.permissions' => $permissions]);
       }
    }

    /**
     * Can merge permissions
     *
     * @return boolean
     */
    private function canMergePermissions()
    {
        return !!config('allegro-client.merge_permissions');
    }
}
