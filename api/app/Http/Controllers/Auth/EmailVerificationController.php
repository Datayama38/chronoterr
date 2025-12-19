<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\RestController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends RestController
{
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->error(
                'Email already verified',
                Response::HTTP_CONFLICT
            );
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->ok([
            'message' => 'Verification email sent',
        ]);
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect(
            config('app.frontend_url') . '/email-verified'
        );
    }
}
