<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class CreateUserCommand extends Command
{
    public const FAILURE = -1;

    public const SUCCESS = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user['name'] = $this->ask('Name of the new user?');
        $user['email'] = $this->ask('Email of the new user?');
        $user['password'] = $this->secret('Password of the new user?');

        $roles = Role::query()->get(['id', 'name']);
        $roleNames = $roles->pluck('name')->toArray();

        $selectedRoleIndex = $this->choice('What is the role of the new user?', $roleNames, 1);

        $index = $roles->search(function ($item) use ($selectedRoleIndex) {
            return $item['name'] === $selectedRoleIndex;
        });

        if ($index === false) {
            $this->error('Role not found');

            return self::FAILURE;
        }

        $validator = Validator::make($user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:'.User::class],
            'password' => ['required', Password::defaults()],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        DB::transaction(function () use ($user, $roles, $index) {
            $newUser = User::create($user);
            $newUser->roles()->attach($roles[$index]['id']);
        });

        $this->info("User {$user['email']} created successfully");

        return self::SUCCESS;
    }
}
