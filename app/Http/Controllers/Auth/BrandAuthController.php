<?php

// app/Http/Controllers/Auth/BrandAuthController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BrandAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:brands',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string',
            'category_id' => 'required|uuid',
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'category_id' => $request->category_id,
            'logo' => $request->logo,
        ]);

        $token = $brand->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::guard('brand')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $brand = Brand::where('email', $request['email'])->firstOrFail();
        $token = $brand->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => new BrandResource($brand->load('category')),
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

