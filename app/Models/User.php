<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    protected $table = 'users';

    public function authenticate($identifier, $password)
    {
        $user = $this->where('email', $identifier)
                     ->orWhere('username', $identifier)
                     ->first();
        if ($user && $password === $user->password) {
            // Authentication successful
            // You can perform additional actions here, such as setting a session variable
            return $user;
        }

        return null; // Authentication failed
    }
}

