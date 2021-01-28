<?php

namespace AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Controllers;

use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Requests\StoreDefaultSetting;
use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\AllegroClient\Facades\AllegroClient;
use AwemaPL\AllegroClient\Admin\Sections\Installations\Http\Requests\StoreInstallation;
use Illuminate\Routing\Controller;

class DefaultSettingController extends Controller
{

    use RedirectsTo;

    /**
     * Where to redirect after installation.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Display installation form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('allegro-client::admin.sections.installations.default-settings');
    }

    /**
     * Store installation.
     *
     * @param  StoreDefaultSetting  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDefaultSetting $request)
    {
        AllegroClient::installDefaultSettings($request->all());
        return $this->ajaxRedirectTo($request);
    }
}
