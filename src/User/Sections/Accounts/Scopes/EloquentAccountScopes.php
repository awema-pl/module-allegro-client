<?php

namespace AwemaPL\AllegroClient\User\Sections\Accounts\Scopes;

use AwemaPL\Repository\Scopes\ScopesAbstract;

class EloquentAccountScopes extends ScopesAbstract
{
    protected $scopes = [
        'q' =>SearchAccount::class,
    ];
}
