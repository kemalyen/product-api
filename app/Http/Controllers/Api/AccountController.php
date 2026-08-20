<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\PriceUpdateRequest;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Repositories\AccountRepository;
use Illuminate\Http\JsonResponse;

class AccountController extends ApiController
{
    protected AccountRepository $account_repository;

    public function __construct(AccountRepository $account_repository)
    {
        $this->account_repository = $account_repository;
        $this->authorizeResource(Account::class);
    }

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
        $account = $this->account_repository->create($request->validated());
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
        $account = $this->account_repository->update($request->validated(), $account);
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
    public function destroy(Account $account): JsonResponse
    {
        $account->deleteOrFail();
        return response()->json([], 204);
    }

    public function price(Account $account, Product $product, PriceUpdateRequest $request): JsonResponse
    {
        $this->authorize('price', $account);

        ProductPrice::updateOrCreate(
            ['account_id' => $account->id, 'product_id' => $product->id],
            ['price' => $request->price]
        );

        return response()->json(['message' => 'Price updated successfully'], 204);
    }
}
