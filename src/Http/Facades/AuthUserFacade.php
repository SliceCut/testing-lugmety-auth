<?php

namespace Lugmety\Auth\Http\Facades;

use Illuminate\Support\Facades\Facade;
use Lugmety\Auth\Services\Singleton\AuthUser;

/**
 * @method static array|null user()
 * @method static array roles()
 * @method static string|null token()
 * @method static mixed|null get(string $key, $default = null)
 * @method static bool hasRole(...$roles)
 * @method static bool hasParentRole(...$roles)
 * @method static int|null getUserId()
 */
class AuthUserFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AuthUser::class;
    }
}