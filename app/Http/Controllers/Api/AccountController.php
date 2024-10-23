<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AccountResource::collection(
            Account::paginate()
        );
    }
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(AccountRequest $request) 
    {
        $account = Account::create($request->validated());
        return new AccountResource($account);
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        return new AccountResource($account);
    }
 

    /**
     * Update the specified resource in storage.
     */
    public function update(AccountUpdateRequest $request, Account $account)
    {
        $account->update($request->validated());
        return new AccountResource($account);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        $account->deleteOrFail();
    }
}
