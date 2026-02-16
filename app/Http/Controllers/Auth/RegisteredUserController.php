<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'region_id' => ['nullable', 'exists:regions,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'school_id' => ['nullable', 'exists:schools,id'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'birth_date' => ['nullable', 'date'],
            'user_type' => ['nullable', 'string', 'max:255'],
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'points' => 0, // Значение по умолчанию
        ];

        // Добавляем опциональные поля, если они присутствуют в запросе
        $optionalFields = ['avatar', 'country_id', 'region_id', 'district_id', 'city_id',
            'school_id', 'school_class_id', 'role_id', 'birth_date', 'user_type'];

        foreach ($optionalFields as $field) {
            if ($request->has($field)) {
                $userData[$field] = $request->$field;
            }
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return response()->noContent();
    }
}
