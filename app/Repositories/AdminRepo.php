<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AdminInterface;

class AdminRepo implements AdminInterface {

    public function getUser($id, $role) {
        $user;
        try {
            if($id == 'p') {
                if($role == 9) {
                    $user = \App\User::where('role', '>=', $role)->paginate(20);
                } else {
                    $user = \App\User::where('role', $role)->paginate(20);
                }
            } else {
                $user = \App\User::where('id', $id)->first();
            }
        } catch(\Exception $ex) {
            return $ex;
        }
        return $user;
    }

    public function getUserCount($id) {
        $total = 0;
        try {
            if($id == 9) {
                $total = \App\User::where('role', '>=', $id)->count();
            } else {
                $total = \App\User::where('role', '<=', 8)->count();
            }
        } catch(\Exception $ex) {
            return $ex;
        }
        return $total;
    }

    public function userGroups() {
        $user_group;
        try {
            $user_group = \App\AccountRole::all();
        } catch(\Exception $ex) {
            return $ex;
        }
        return $user_group;
    }

    public function getUserRole($role_id) {
        $role;
        try {
            $role = \App\AccountRole::where('id', $role_id)->first();
        } catch(\Exception $ex) {
            return $ex;
        }
        return $role;
    }

    public function searchUsers($username) {
        $user;
        try {
            $user = \App\User::where('name', 'like' , '%' . $username . '%')->orWhere('at_name', 'like' , '%' . $username . '%')->paginate(20);
        } catch(\Exception $ex) {
            return $ex;
        }
        return $user;
    }

    public function createUser($data) {
        $user;
        try {
            $user = \App\User::create($data);
        } catch(\Exception $ex) {
            return $ex;
        }
        return $user;
    }

    public function elevateAccount($id, $role) {
        $update;
        try {
            $update = \App\User::where('id', $id)->update(['role' => $role]);
        } catch(\Exception $ex) {
            return $ex;
        }
        return $update;
    }

    public function blockAccount($id) {
        $block;
        try {
            $block = \App\User::where('id', $id)->update(['account_status' => 1]);
        } catch(\Exception $ex) {
            return $ex;
        }
        return $block;
    }
}