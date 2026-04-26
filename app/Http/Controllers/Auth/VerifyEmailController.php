<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    /**
     * Mark a user's email address as verified using a signed URL.
     *
     * The route is protected by the `signed` and `throttle` middleware so the
     * link is tamper-proof and rate-limited. We additionally verify the hash
     * matches the user's email so that a leaked link cannot be reused for a
     * different account.
     */
    public function __invoke(Request $request, $id, $hash): RedirectResponse
    {
        $frontend         = rtrim((string) config('app.frontend_url'), '/');
        $verifiedTarget   = $frontend . '/login?verified=1';
        $alreadyVerified  = $frontend . '/login?verified=already';

        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->away($alreadyVerified);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->away($verifiedTarget);
    }
}
