<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;

class AccountController extends ApiController
{
    /**
     * List all accounts
     * 
     * @group Account API Resource
     */
    public function index()
    {
        return AccountResource::collection(
            Account::paginate()
        );
    }
 

    /**
     * Create a new account
     * 
     * @group Account API Resource
     *
     */
    public function store(AccountRequest $request) 
    {
        $account = Account::create($request->validated());
        return new AccountResource($account);
    }

    /**
     * View a account
     * 
     * Display a individual account data.
     * 
     * @group Account API Resource
     * 
     */
    public function show(Account $account)
    {
        return new AccountResource($account);
    }
 

    /**
     * Update a account
     * 
     * Update the specified account
     * 
     * @group Account API Resource
     * 
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        $account->update($request->validated());
        return new AccountResource($account);
    }

    /**
     * Delete a account.
     * 
     * Remove the account resource
     * 
     * @group Account API Resource
     * 
     */
    public function destroy(Account $account)
    {
        $account->deleteOrFail();
    }
}
