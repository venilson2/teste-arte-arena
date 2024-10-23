<?php

namespace Modules\Account\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Account\App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Modules\Account\App\Http\Requests\StoreAccountRequest;
use Modules\Account\App\Http\Requests\UpdateAccountRequest;

class AccountApiController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $accounts = Account::all();
        } else {
            $accounts = Account::where('user_id', $user->id)->get();
        }

        return response()->json($accounts);
    }

    public function store(StoreAccountRequest $request): JsonResponse
    {
        $user = Auth::user();
    
        $data = $request->validated();
    
        $data['user_id'] = $user->id;
    
        $account = Account::create($data);
    
        return response()->json($account, 201);
    }

    public function update(UpdateAccountRequest $request, $id): JsonResponse
    {

        $user = Auth::user();

        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        if ($account->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();

        $account->update($data);

        return response()->json($account);
    }

    public function destroy($id): JsonResponse
    {
        $user = Auth::user();
    
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }
    
        if ($account->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        $account->delete();
        return response()->json(null, 204);
    }
}