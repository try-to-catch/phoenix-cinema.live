<?php

namespace App\Actions\Role;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class GetRolesAction
{
    public function handle(): Collection
    {
        return Cache::rememberForever('roles', function () {
            return Role::all();
        });
    }
}
