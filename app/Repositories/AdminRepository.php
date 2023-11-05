<?php

namespace App\Repositories;

use App\Models\User;

class AdminRepository
{
    public function all()
    {
        $admins = User::withWhereHas('roles', function ($q) {
            $q->where('name', 'Admin');
        })->get();
        return $admins;
    }

    public function createAdmin($request)
    {
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();
        $user->assignRole('Admin');
        return $user;
    }

    public function updateAdmin($request)
    {
        $user = User::find($request['user_id']);
        $user->name = $request['name'];
        $user->email = $request['email'];
        if ($request['password']) {
            $user->password = bcrypt($request['password']);
        }
        $user->save();
        return $user;
    }

    public function deleteAdmin($request)
    {
        $admin = User::find($request['id']);
        $admin->delete();
        return true;
    }
}
