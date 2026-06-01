<?php

namespace App\Http\Controllers\Api;

use App\Data\Account\AccountDto;
use App\Data\Common\PaginatedDto;
use App\Http\Controllers\ApiController;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Http\Requests\PriceUpdateRequest;
use App\Models\Account;
use App\Models\Product;
use App\Models\ProductPrice;
use Illuminate\Http\JsonResponse;

class AccountController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Account::class);
    }

    /**
     * List all accounts
     * 
     * @group Account API Resource
     */
    public function index(): JsonResponse
    {
        $accounts = Account::paginate();
        return response()->json(
            PaginatedDto::from($accounts, fn($a) => AccountDto::from($a))
        );
    }

    /**
     * Create a new account
     * 
     * @group Account API Resource
     *
     */
    public function store(AccountRequest $request): JsonResponse
    {
        $account = Account::create($request->validated());
        return response()->json(AccountDto::from($account), 201);
    }

    /**
     * View a account
     * 
     * Display a individual account data.
     * 
     * @group Account API Resource
     * 
     */
    public function show(Account $account): JsonResponse
    {
        return response()->json(AccountDto::from($account));
    }

    /**
     * Update a account
     * 
     * Update the specified account
     * 
     * @group Account API Resource
     * 
     */
    public function update(AccountUpdateRequest $request, Account $account): JsonResponse
    {
        $account->update($request->validated());
        return response()->json(AccountDto::from($account));
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
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            ProductPrice::updateOrCreate(
                ['account_id' => $account->id, 'product_id' => $product->id],
                ['price' => $request->validated()['price']]
            );

            return response()->json(['message' => 'Price updated successfully']);
        }

        abort(403, 'This action is unauthorized.');
    }
}
