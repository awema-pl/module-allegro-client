<?php
namespace AwemaPL\AllegroClient\User\Sections\Applications\Policies;

use AwemaPL\AllegroClient\User\Sections\Applications\Models\Application;
use Illuminate\Foundation\Auth\User;

class ApplicationPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User $user
     * @param  Application $application
     * @return bool
     */
    public function isOwner(User $user, Application $application)
    {
        return $user->id === $application->user_id;
    }


}
