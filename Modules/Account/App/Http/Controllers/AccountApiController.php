<?php

namespace Modules\Account\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Account\App\Models\Account;
use Illuminate\Support\Facades\Auth;

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

    public function show($id): JsonResponse
    {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }
        return response()->json($account);
    }

    public function store(Request $request): JsonResponse
    {

        $user = Auth::user();

        $data = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'value'         => 'required|numeric',
            'due_date'      => 'required|date',
            'status'        => 'required|in:paid,pending',
            'user_id'       => $user->id
        ]);

        $account = Account::create($data);

        return response()->json($account, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'value' => 'required|numeric',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,pending',
        ]);

        $account->update($data);

        return response()->json($account);
    }

    public function destroy($id): JsonResponse
    {
        $account = Account::find($id);
        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $account->delete();

        return response()->json(['message' => 'Account deleted']);
    }
}