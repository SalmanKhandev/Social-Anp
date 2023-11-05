<?php

namespace App\Repositories;

use App\Models\User;
use App\Jobs\ThankYouEmailJob;
use App\Jobs\AccountActivationJob;
use App\Jobs\AccountDeactivationJob;

class UsersRepository
{
    public function all()
    {
        $users = User::whereHas('roles', function ($role) {
            $role->where('name', 'User');
        })->get();
        return $users;
    }
    public function countUsers()
    {
        return User::count();
    }

    public function findUserById($id)
    {
        return User::find($id);
    }

    public function topUsers($limit = 10)
    {
        $topUsers = User::withCount('posts')
            ->orderByDesc('posts_count')
            ->limit($limit)
            ->get()->filter(function ($user) {
                return $user->posts_count > 0;
            });
        return $topUsers;
    }

    public function thankYou($userId)
    {
        $user = $this->findUserById($userId);
        return  ThankYouEmailJob::dispatch($user);
    }

    public function accountActivation($userId)
    {
        $user = $this->findUserById($userId);
        return AccountActivationJob::dispatch($user);
    }

    public function accountDeactivation($userId)
    {
        $user = $this->findUserById($userId);
        return AccountDeactivationJob::dispatch($user);
    }

    public function updateUser($data)
    {
        $user = User::find($data['user_id']);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if ($data['password']) {
            $user->password = bcrypt($data['password']);
        }
        $user->save();
        return $user;
    }
}
