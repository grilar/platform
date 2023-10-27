<?php

namespace Grilar\ACL\Services;

use Grilar\ACL\Events\RoleAssignmentEvent;
use Grilar\ACL\Models\Role;
use Grilar\ACL\Models\User;
use Grilar\Support\Services\ProduceServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateUserService implements ProduceServiceInterface
{
    public function __construct(protected ActivateUserService $activateUserService)
    {
    }

    public function execute(Request $request): User
    {
        $user = User::query()->create($request->input());

        if ($request->has('username') && $request->has('password')) {
            $user->fill([
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
            ]);

            if ($this->activateUserService->activate($user) && $roleId = $request->input('role_id')) {
                $role = Role::query()->find($roleId);

                if ($role) {
                    $role->users()->attach($user->id);

                    event(new RoleAssignmentEvent($role, $user));
                }
            }
        }

        return $user;
    }
}
