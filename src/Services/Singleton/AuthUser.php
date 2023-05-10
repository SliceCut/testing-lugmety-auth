<?php

namespace Lugmety\Auth\Services\Singleton;

class AuthUser
{
    /**
     * @var array|null
     */
    public $user = null;
    /**
     * @var int|null
     */
    public $user_id = null;
    /**
     * @var string|null
     */
    public $token = null;

    /**
     * @param array $user
     * @return void
     */
    public function setUser($user)
    {
        $this->user = $user;
        if($user) {
            $this->setUserId('user_id');
        }
    }

    /**
     * @param string $token
     * @return void
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param int $user_id
     * @param void
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return array|null
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Get user Role
     * @return array
     */
    public function roles()
    {
        return $this->get('roles', []);
    }

    /**
     * @return string|null
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        $value =  $this->user[$key] ?? null;
        return  $value ? $value : $default;
    }

    /**
     * @return int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Method to get the full username
     * @return string
     */
    public function getFullUserName()
    {
        return ($this->user['middlename'] == "")
            ? $this->user['firstname'] . " " . $this->user['lastname']
            : $this->user['firstname'] . " " . $this->user['middlename'] . " " . $this->user['lastname'];
    }
    
    /**
     * Check if the user has the requested role or not
     * @param array $roles
     * @return bool
     */
    public function hasRole(...$roles)
    {
        $userRoles = $this->roles();
        foreach($roles as $role) {
            if(in_array($role, $userRoles)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has the requested parent role or not
     * @param array $roles
     * @return bool
     */
    public function hasParentRole(...$roles)
    {
        $parentRole = $this->get('parentRole');
        foreach($roles as $role) {
            if($role == $parentRole) {
                return true;
            }
        }

        return false;
    }
}