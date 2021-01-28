<?php

namespace AwemaPL\AllegroClient\Contracts;

use Illuminate\Http\Request;

interface AllegroClient
{
    /**
     * Register routes.
     *
     * @return void
     */
    public function routes();

    /**
     * Can installation
     *
     * @return mixed
     */
    public function canInstallation();

    /**
     * Can installation default settings
     *
     * @return mixed
     */
    public function canInstallationDefaultSettings();

    /**
     * Include Lang JS
     */
    public function includeLangJs();


    /**
     * Menu merge in navigation
     */
    public function menuMerge();

    /**
     * Install package
     *
     * @param array $data
     */
    public function install(array $data);

    /**
     * Install default settings package
     *
     * @param array $data
     */
    public function installDefaultSettings(array $data);

    /**
     * Add permissions for module permission
     *
     * @return mixed
     */
    public function mergePermissions();
}
