<?php

namespace TuaWebsite\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TuaWebsite\Http\Controllers\Controller;

/**
 * "Forgot Password" Controller
 *
 * @package TuaWebsite\Http\Controllers\Auth
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ForgotPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Actions ----
    /**
     * Display the form to request a password reset link.
     *
     * @return Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  Request  $request
     *
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email_address' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email_address')
        );

        if ($response === \Password::RESET_LINK_SENT) {
            return $this->sendSentResponse($request, $response);
        }

        return $this->sendFailedResponse($request, $response);
    }

    // Internals ----
    /**
     * @param Request $request
     * @param string  $response
     *
     * @return RedirectResponse|JsonResponse
     */
    private function sendSentResponse(Request $request, $response)
    {
        if($request->ajax()){
            return response()->json([
                'message' => trans($response)
            ], 200);
        }

        return back()->with('status', trans($response));
    }

    /**
     * @param Request $request
     * @param string  $response
     *
     * @return RedirectResponse|JsonResponse
     */
    private function sendFailedResponse(Request $request, $response)
    {
        if($request->ajax()){
            return $response()->json([
                'message' => trans($response)
            ], \Password::INVALID_USER === $response? 404:500);
        }

        return back()->withErrors([
            'email_address' => trans($response)
        ]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    private function broker()
    {
        return \Password::broker();
    }
}
