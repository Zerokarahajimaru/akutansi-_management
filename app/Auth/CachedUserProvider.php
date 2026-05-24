<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Cache;

class CachedUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier.
     * Overridden to use Cache and minimize Supabase round-trips.
     */
    public function retrieveById($identifier)
    {
        return Cache::remember('user_auth_id_' . $identifier, 3600, function () use ($identifier) {
            return $this->createModel()->newQuery()
                ->select(['id', 'username', 'name', 'role', 'NoTelp_User', 'Alamat_User', 'password'])
                ->find($identifier);
        });
    }

    /**
     * Retrieve a user by the given credentials.
     * Used during login.
     */
    public function retrieveByCredentials(array $credentials)
    {
        return parent::retrieveByCredentials($credentials);
    }
}
