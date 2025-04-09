<?php
declare(strict_types=1);

namespace ReaZzon\JWTAuth\Http\Controllers;

use October\Rain\Argon\Argon;
use RainLab\User\Models\User;
use ReaZzon\JWTAuth\Classes\Dto\TokenDto;
use ReaZzon\JWTAuth\Http\Requests\LoginRequest;
use ReaZzon\JWTAuth\Http\Resources\TokenResource;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @param LoginRequest $loginRequest
     * @return array
     * @throws \ApplicationException
     */


    public function __invoke(LoginRequest $loginRequest): array
    {
        // Получаем данные из запроса
        $validatedData = $loginRequest->validated();

        if (empty($validatedData)) {
            throw new \ApplicationException('Invalid login data');
        }

        // Пытаемся найти пользователя по email
        $user = User::where('email', $validatedData['email'])->first();

        if (empty($user)) {
            throw new \ApplicationException('Login failed: Invalid credentials');
        }

        // Проверяем, совпадает ли пароль с хешированным значением
        if (!Hash::check($validatedData['password'], $user->password)) {
            throw new \ApplicationException('Login failed: Invalid credentials');
        }

        // Создаем токен JWT
        $token = $this->JWTGuard->login($user);

        if (!$token) {
            throw new \ApplicationException('Failed to generate JWT token');
        }

        // Формируем объект TokenDto
        $tokenDto = new TokenDto([
            'token' => $token,
            'expires' => Argon::createFromTimestamp($this->JWTGuard->getPayload()->get('exp')),
            'user' => $user,
        ]);

        return ['data' => $tokenDto->toArray()];
    }


}
