<?php
namespace TuaWebsite\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Login Controller
 *
 * @package TuaWebsite\Http\Controllers\Auth
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    // Actions ----
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    public function login(Request $request)
    {
        // Validate the data
        $this->validateLogin($request);

        // Throttle login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Grab the credentials
        $credentials = $request->only($this->username(), 'password');

        // Attempt the login
        if ($this->guard()->attempt($credentials, $request->has('remember'))) {
            return $this->sendLoginResponse($request);
        }

        // If it failed, increment the attempts
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();
        $request->session()->regenerate();

        if($request->ajax()){
            return response()->json([], 204);
        }

        return redirect('/');
    }

    // Internals ----
    /**
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return \Auth::guard();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param Request $request
     */
    private function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password'        => 'required',
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $message = \Lang::get('auth.throttle', ['seconds' => $seconds]);

        if($request->ajax()){
            return response()->json([
                'message' => $message
            ], 429);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([$this->username() => $message]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    private function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if($request->ajax()){
            return response()->json([
                'redirect' => \Session::pull('url.intended', route('admin.index'))
            ], 200);
        }

        return redirect()->intended(route('admin.index'));
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     *
     * @return RedirectResponse|JsonResponse
     */
    private function sendFailedLoginResponse(Request $request)
    {
        if($request->isXmlHttpRequest()){
            return response()->json([
                'message' => \Lang::get('auth.failed')
            ], 401);
        }
        else{
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => \Lang::get('auth.failed'),
                ]);
        }
    }
}
