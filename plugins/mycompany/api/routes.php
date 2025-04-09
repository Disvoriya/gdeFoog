<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use RainLab\User\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

// Префикс для API
Route::prefix('api')->group(function () {

    // Регистрация
    Route::post('/register', function (Request $request) {
        $data = $request->only(['first_name', 'email', 'password']);

        $user = new User;
        $user->first_name = $data['first_name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->password_confirmation = $data['password'];
        $user->is_activated = true;
        $user->activated_at = now();
        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    });

    // Логин
    Route::post('/login', function (Request $request) {
        // Получаем учетные данные из запроса
        $credentials = $request->only(['email', 'password']);

        // Логируем попытку входа
        Log::info('Trying to login with:', $credentials);

        // Проверяем, можно ли создать токен с данными учетными данными
        if (!$token = auth()->attempt($credentials)) {
            // Логируем ошибку
            Log::error('Token generation failed for credentials:', $credentials);

            // Если не удалось, возвращаем ошибку с кодом 401
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Возвращаем токен
        return response()->json(['token' => $token]);
    });

    Route::get('/test-jwt', function () {
        $user = \RainLab\User\Models\User::first();

        if ($user instanceof \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject) {
            return 'OK';
        } else {
            return 'NOPE';
        }
    });


    // Профиль (требует токен)
    Route::middleware('auth:api')->get('/profile', function () {
        return response()->json(auth()->user());
    });
});
