<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Role\GetRolesAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Http\Requests\Admin\User\UserListRequest;
use App\Http\Resources\Admin\User\UserItemResource;
use App\Http\Resources\Admin\User\UserListResource;
use App\Models\User;
use App\Services\FlashMessageService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserListRequest $request): Response
    {
        $data = $request->validated();
        $searchQuery = $data['s'] ?? '';
        $users = User::searched($searchQuery)
            ->select(['id', 'email', 'name'])
            ->withCount('orders')
            ->with('roles')
            ->withRolesFirst()
            ->paginate(10)
            ->onEachSide(1);

        return Inertia::render('Admin/Users/Index', [
            'users' => UserListResource::collection($users),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): Response
    {
        $user->load('roles');

        return Inertia::render('Admin/Users/Edit', [
            'user' => UserItemResource::make($user)->resolve(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, GetRolesAction $getRoles, FlashMessageService $flashMessageService): RedirectResponse
    {
        $data = $request->validated();
        $roles = $getRoles->handle();

        $newRolesIds = $roles->filter(function ($role) use ($data) {
            return in_array($role->name, $data['roles']);
        });
        $user->roles()->sync($newRolesIds);

        $flashMessageService->success('Roles updated successfully');

        return redirect()->route('admin.users.index');
    }
}
