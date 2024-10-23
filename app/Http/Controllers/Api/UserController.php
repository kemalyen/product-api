<?php

namespace App\Http\Controllers\Api;

use App\Factories\UserFactory;
use App\Http\Controllers\ApiController;
use App\Http\Filters\UserFilter;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends ApiController
{
    protected UserRepository $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * List all users
     * 
     * @group User API Resource
     * @queryParam sort by user name and email
     * @queryParam filter[name] Filter by name. Wildcards are supported. Example: *fix*
     * @queryParam filter[email] Filter by email. Wildcards are supported. Example: *fix*
     * @queryParam filter[role] Filter by role. Wildcards are NOT supported. Example: Account Manager
     */
    public function index(UserFilter $filter)
    {
        return UserResource::collection(
            User::filter($filter)->with('roles')->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->user_repository->save($request->all(), UserFactory::create());
        return new UserResource($user);
    }

    /**
     * Update a user
     * 
     * Update the specified user
     * 
     * @group User API Resource
     * 
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user = $this->user_repository->update($request->all(), $user);
        return new UserResource($user);
    }

        /**
     * Delete a user.
     * 
     * Remove the user resource
     * 
     * @group User API Resource
     * 
     */
    public function destroy(User $user)
    {
        $user->deleteOrFail();
    }
}
