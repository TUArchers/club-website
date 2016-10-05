<?php

namespace TuaWebsite\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;

/**
 * "Reset Password" Controller
 *
 * @package TuaWebsite\Http\Controllers\Auth
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ResetPasswordController extends Controller
{
    use RedirectsUsers;

    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Actions ----
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request      $request
     * @param  string|null  $token
     *
     * @return View
     */
    public function showResetForm(Request $request, $token = null)
    {
        if(is_null($token)){
            return redirect(route('auth.password-reset-request.show'));
        }

        return view('auth.passwords.reset')
            ->with([
                'token'         => $token,
                'email_address' => $request->email_address
            ]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function reset(Request $request)
    {
        $this->validate($request, [
            'token'         => 'required',
            'email_address' => 'required|email',
            'password'      => 'required|confirmed|min:6',
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == \Password::PASSWORD_RESET
            ? $this->sendResetResponse($request, $response)
            : $this->sendResetFailedResponse($request, $response);
    }

    // Internals ----
    /**
     * Get the password reset credentials from the request.
     *
     * @param  Request $request
     *
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email_address', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  User   $user
     * @param  string $password
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password_hash'  => \Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param Request $request
     * @param string  $response
     *
     * @return RedirectResponse|JsonResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        if($request->ajax()){
            return response()->json([
                'message' => trans($response)
            ], 200);
        }

        return redirect($this->redirectPath())->with('status', trans($response));
    }

    /**
     * Get the response for a failed password reset.
     *
     * @param  Request $request
     * @param  string  $response
     *
     * @return RedirectResponse
     */
    protected function sendResetFailedResponse(Request $request, $response)
    {
        if($request->ajax()){
            return response()->json([
                'message' => trans($response)
            ], 422);
        }

        return redirect()->back()
            ->withInput($request->only('email_address'))
            ->withErrors([
                'email_address' => trans($response)
            ]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return \Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard();
    }
}
