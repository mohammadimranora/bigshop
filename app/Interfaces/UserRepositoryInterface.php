<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{

    /**
     * register a user
     * @param string $name name of the user
     * @param string $email email of the user
     * @param string $password password of the user
     * @param integer $type user is admin or customer i.e customer = 1, admin = 2
     * @return array $response
     */
    public function register($name, $email, $password, $type);

    /**
     * login a user
     * @param string $email email of the user
     * @param string $password password of the user
     * @return array $response
     */
    public function login($email, $password);

    /**
     * send email verification link
     * @param App\Models\User $user User Model instance
     * @return array $response
     */
    public function sendEmailVerificationLink(User $user);

    /**
     * mark user's email verified
     * @param App\Models\User $user User Model instance
     * @return array $response
     */
    public function markVerified(User $user);

    /**
     * send password reset link
     * @param App\Models\User $user User Model instance
     * @return array $response
     */
    public function sendPasswordResetLink(User $user);

    /**
     * send password reset link
     * @param array $credentials
     * @return array $response
     */
    public function resetPassword($credentials);
}
