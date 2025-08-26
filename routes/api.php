<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/* ---------- Auth: login token ---------- */
Route::post('/login-token', function (Request $r) {
    $data = $r->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $data['email'])->first();
    if (!$user || !Hash::check($data['password'], $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 422);
    }

    $token = $user->createToken('postman')->plainTextToken;
    return response()->json(['token' => $token], 200);
});

/* ---------- Public ---------- */
Route::get('/series', [\App\Http\Controllers\Api\SeriesController::class, 'index']);
Route::get('/series/{id}', [\App\Http\Controllers\Api\SeriesController::class, 'show']);

/* ---------- Auth (Sanctum) ---------- */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites',  [\App\Http\Controllers\Api\FavoriteController::class, 'index']);
    Route::post('/favorites', [\App\Http\Controllers\Api\FavoriteController::class, 'store']);

    Route::post('/logout-token', function (Request $r) {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'logged out'], 200);
    });
});
