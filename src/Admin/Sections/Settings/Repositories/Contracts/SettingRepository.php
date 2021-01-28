<?php

namespace AwemaPL\AllegroClient\Admin\Sections\Settings\Repositories\Contracts;

use AwemaPL\AllegroClient\Sections\Options\Http\Requests\UpdateOption;
use Illuminate\Http\Request;

interface SettingRepository
{
    /**
     * Create setting
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Scope setting
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);
    
    /**
     * Update setting
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);

    /**
     * exist setting
     *
     * @return boolean
     */
    public function exist();

    /**
     * Get value
     *
     * @param $key
     * @return mixed
     */
    public function getValue($key);

    /**
     * Add basic where clauses and execute single the query.
     *
     * @param array $conditions
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public function firstWhere(array $conditions, array $columns = ['*']);
}
