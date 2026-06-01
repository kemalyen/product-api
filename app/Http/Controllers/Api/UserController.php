<?php

namespace App\Http\Controllers\Api;

use App\Data\Common\PaginatedDto;
use App\Data\User\UserDto;
use App\Factories\UserFactory;
use App\Http\Controllers\ApiController;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    protected UserRepository $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
        $this->authorizeResource(User::class);
    }

    /**
     * List all users
     * 
     * @group User API Resource
     * @queryParam sort by user name and email
     * @queryParam filter[name] Filter by name. Wildcards are supported. Example: *fix*
     * @queryParam filter[email] Filter by email. Wildcards are supported. Example: *fix*
     * @queryParam filter[role] Filter by role. Wildcards are NOT supported. Example: Account Manager
     * @queryParam filter[account] Filter by account. Wildcards are NOT supported. Example: 1
     */
    public function index(UserFilter $filter): JsonResponse
    {
        $users = User::filter($filter)->account()->with('roles')->paginate();
        return response()->json(
            PaginatedDto::from($users, fn($u) => UserDto::from($u))
        );
    }

    /**
     * Create a new user
     * 
     * @group User API Resource
     *
     */
    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->user_repository->save($request->validated(), UserFactory::create());
        return response()->json(UserDto::from($user), 201);
    }

    /**
     * Update a user
     * 
     * Update the specified user
     * 
     * @group User API Resource
     * 
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $user = $this->user_repository->update($request->validated(), $user);
        return response()->json(UserDto::from($user));
    }

    /**
     * View an user
     * 
     * Display an user with relational data.
     * 
     * @group User API Resource
     * 
     */
    public function show(User $user): JsonResponse
    {
        if ($this->include('account')) {
            $user = $user->load('account');
        }

        return response()->json(UserDto::from($user));
    }

    /**
     * Delete a user.
     * 
     * Remove the user resource
     * 
     * @group User API Resource
     * 
     */
    public function destroy(User $user): JsonResponse
    {
        $user->deleteOrFail();
        return response()->json([], 204);
    }
}
