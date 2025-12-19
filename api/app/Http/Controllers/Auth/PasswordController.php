<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PasswordController extends RestController
{
    /**
     * Utilisateur connecté — changer son mot de passe
     */
    public function change(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return $this->error(
                'Current password is incorrect',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Optionnel : invalider les autres tokens
        $user->tokens()
            ->where('id', '!=', $request->user()->currentAccessToken()?->id)
            ->delete();

        return $this->ok([
            'message' => 'Password updated',
        ]);
    }

    /**
     * Mot de passe oublié — envoi email
     */
    public function forgot(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->ok(['message' => __($status)])
            : $this->error(__($status), Response::HTTP_BAD_REQUEST);
    }

    /**
     * Reset du mot de passe
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? $this->ok(['message' => __($status)])
            : $this->error(__($status), Response::HTTP_BAD_REQUEST);
    }
}
