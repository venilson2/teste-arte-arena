<?php

namespace Modules\Account\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Account\App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Modules\Account\App\Http\Requests\StoreAccountRequest;
use Modules\Account\App\Http\Requests\UpdateAccountRequest;
use Exception;

class AccountApiController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            if ($user->hasRole('admin')) {
                $accounts = Account::all();
            } else {
                $accounts = Account::where('user_id', $user->id)->get();
            }

            return response()->json($accounts);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(StoreAccountRequest $request): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        
            $user = Auth::user();
        
            $data = $request->validated();
        
            $data['user_id'] = $user->id;
        
            $account = Account::create($data);
        
            return response()->json($account, 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateAccountRequest $request, $id): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $user = Auth::user();

            $account = Account::find($id);
            if (!$account) {
                return response()->json(['message' => 'Account not found'], 404);
            }

            if ($account->user_id !== $user->id && !$user->hasRole('admin')) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $data = $request->validated();
            $account->update($data);

            return response()->json($account);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        
            $user = Auth::user();
        
            $account = Account::find($id);
            if (!$account) {
                return response()->json(['message' => 'Account not found'], 404);
            }
        
            if ($account->user_id !== $user->id && !$user->hasRole('admin')) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        
            $account->delete();
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}