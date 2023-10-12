<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class AddRoleToUserCommand extends Command
{
    public const FAILURE = -1;

    public const SUCCESS = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new role to the user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $userId = $this->ask('Who will receive an extra role? Specify the user ID');

        $user = User::query()->find($userId);
        if (! $user->exists()) {
            $this->error('User not found');

            return self::FAILURE;
        }

        $roles = Role::query()->get(['id', 'name']);

        $roleNames = $roles->diff($user->roles)->pluck('name')->toArray();

        $selectedRoleIndex = $this->choice('What is the role of the new user? (current roles: ['.$user->roles->values()->implode('name', ', ').'])', $roleNames, 1);

        $index = $roles->search(function ($item) use ($selectedRoleIndex) {
            return $item['name'] === $selectedRoleIndex;
        });

        if ($index === false) {
            $this->error('Role not found');

            return self::FAILURE;
        }

        $user->roles()->attach($roles[$index]['id']);

        $this->info("The role for user {$user['email']} added successfully");

        return self::SUCCESS;
    }
}
