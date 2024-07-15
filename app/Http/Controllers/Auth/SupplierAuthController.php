<?php

// app/Http/Controllers/Auth/SupplierAuthController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SupplierAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:suppliers',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'logo' => $request->logo,
        ]);

        $token = $supplier->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 422);
        }
    
        // Attempt to authenticate supplier
        if (!Auth::guard('supplier')->attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid login details'], 401);
        }
    
        // Retrieve authenticated supplier
        $supplier = Supplier::where('email', $request->email)->firstOrFail();
    
        // Generate and return API token
        $token = $supplier->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new SupplierResource($supplier),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}

