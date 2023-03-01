<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * register a user
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'type' => 'required|min_digits:1'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error("Validation Error", 400, $validator->errors());
        }
        return $this->userRepository->register($request->name, $request->email, $request->password, $request->type);
    }

    /**
     * login a user
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error("Validation Error", 400, $validator->errors());
        }

        return $this->userRepository->login($request->email, $request->password);
    }

    /**
     * send email verification link
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function sendEmailVerificationLink(Request $request, User $user)
    {
        return $this->userRepository->sendEmailVerificationLink($user);
    }

    /**
     * verify the email
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function verify(Request $request, $id, $hash)
    {
        if (!$request->hasValidSignature()) {
            return view('auth.notify', ['message' => 'Invalid or expired link, Email wasn\'t verified, Please request another']);
        } else {
            $user = User::find($id);
            $status = $this->userRepository->markVerified($user);
            return $status ?
                view('auth.notify', ['message' => 'Email verified successfully']) :
                view('auth.notify', ['message' => 'Email already verified successfully']);
        }
    }

    /**
     * verify the email
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function sendPasswordResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::error('Validation Error', 400, $validator->errors());
        }

        return $this->userRepository->sendPasswordResetLink($request->email);
    }
    /**
     * password reset view
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function resetView(Request $request)
    {
        return view('auth.password-reset');
    }

    /**
     * reset the password
     * @param Illuminate\Http\Request
     * @param Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);
        $status = $this->userRepository->resetPassword($credentials);

        if ($status) {
            return view('auth.notify', ['message' => 'Password Updated Successfully']);
        } else {
            return view('auth.notify', ['message' => 'Password Wasn\'t Updated Successfully, Request a new password reset link']);
        }
    }
}
