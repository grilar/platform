<?php

namespace Grilar\ACL\Http\Controllers\Auth;

use Grilar\ACL\Http\Requests\LoginRequest;
use Grilar\ACL\Models\User;
use Grilar\ACL\Traits\AuthenticatesUsers;
use Grilar\Base\Facades\Assets;
use Grilar\Base\Facades\BaseHelper;
use Grilar\Base\Facades\PageTitle;
use Grilar\Base\Http\Controllers\BaseController;
use Grilar\Base\Http\Responses\BaseHttpResponse;
use Grilar\JsValidation\Facades\JsValidator;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    use AuthenticatesUsers;

    protected string $redirectTo = '/';

    public function __construct(protected BaseHttpResponse $response)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->redirectTo = BaseHelper::getAdminPrefix();
    }

    public function showLoginForm()
    {
        PageTitle::setTitle(trans('core/acl::auth.login_title'));

        Assets::addScripts(['jquery-validation', 'form-validation'])
            ->addStylesDirectly('vendor/core/core/acl/css/animate.min.css')
            ->addStylesDirectly('vendor/core/core/acl/css/login.css')
            ->removeStyles([
                'select2',
                'fancybox',
                'spectrum',
                'simple-line-icons',
                'custom-scrollbar',
                'datepicker',
            ])
            ->removeScripts([
                'select2',
                'fancybox',
                'cookie',
            ]);

        $jsValidator = JsValidator::formRequest(LoginRequest::class);

        $model = User::class;

        return view('core/acl::auth.login', compact('jsValidator', 'model'));
    }

    public function login(Request $request)
    {
        $request->merge([$this->username() => $request->input('username')]);

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $user = User::query()->where([$this->username() => $request->input($this->username())])->first();
        if (! empty($user)) {
            if (! $user->activated) {
                return $this->response
                    ->setError()
                    ->setMessage(trans('core/acl::auth.login.not_active'));
            }
        }

        return app(Pipeline::class)->send($request)
            ->through(apply_filters('core_acl_login_pipeline', [
                function (Request $request, Closure $next) {
                    if ($this->guard()->attempt(
                        $this->credentials($request),
                        $request->filled('remember')
                    )) {
                        return $next($request);
                    }

                    $this->incrementLoginAttempts($request);

                    return $this->sendFailedLoginResponse();
                },
            ]))
            ->then(function (Request $request) {
                Auth::user()->update(['last_login' => Carbon::now()]);

                if (! session()->has('url.intended')) {
                    session()->flash('url.intended', url()->current());
                }

                return $this->sendLoginResponse($request);
            });
    }

    public function username()
    {
        return filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    }

    public function logout(Request $request)
    {
        do_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, $request, $request->user());

        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->response
            ->setNextUrl(route('access.login'))
            ->setMessage(trans('core/acl::auth.login.logout_success'));
    }
}
