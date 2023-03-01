<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UserRepository implements UserRepositoryInterface
{

    /**
     * register a user
     * @param string $name name of the user
     * @param string $email email of the user
     * @param string $password password of the user
     * @param integer $type user is admin or customer i.e customer = 1, admin = 2
     * @return Illuminate\Http\Response $response
     */
    public function register($name, $email, $password, $type = 1)
    {

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'user_type' => $type
        ]);

        return ResponseHelper::success("Success", [
            'user' => $user,
            'token' => $user->createToken('token')->plainTextToken,
            'token_type' => 'Bearer'
        ], 201);
    }

    /**
     * login a user
     * @param string $email email of the user
     * @param string $password password of the user
     * @return Illuminate\Http\Response $response
     */
    public function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->first();
            $user->tokens()->delete();
            $token = $user->createToken('token')->plainTextToken;
            return ResponseHelper::success('Success', [
                'user' => $user,
                'token' => $token
            ]);
        } else {
            return ResponseHelper::error("Invalid Login Credentials", 401);
        }
    }

    /**
     * send email verification link
     * @param App\Models\User $user
     * @return Illuminate\Http\Response $response
     */
    public function sendEmailVerificationLink(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return ResponseHelper::error('Email already verified');
        }
        $user->sendEmailVerificationNotification();
        return ResponseHelper::success('Email verification sent');
    }

    /**
     * mark user's email verified
     * @param App\Models\User $user
     * @return bool $status
     */
    public function markVerified(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return true;
        }
        return false;
    }

    /**
     * send password reset link
     * @param string $email
     * @return bool $status
     */
    public function sendPasswordResetLink($email)
    {
        Password::sendResetLink(['email' => $email]);
        return ResponseHelper::success('Password Reset link has been sent');
    }

    public function resetPassword($credentials)
    {
        $status = Password::reset($credentials, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if ($status == Password::INVALID_TOKEN) {
            return false;
        }
        return true;
    }
}
