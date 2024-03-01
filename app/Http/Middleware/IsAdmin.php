<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Обрабатываем входящий запрос.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->bearerToken() === env("ADMIN_AUTH_KEY")) {
            // Если передан правильный ключ авторизации, пропускаем запрос дальше
            return $next($request);
        } else {
            // Иначе возвращаем ошибку авторизации
            return response()->json([
                'status' => 'error',
                'message' => 'Ошибка авторизации'
            ], 401);
        }
    }
}
