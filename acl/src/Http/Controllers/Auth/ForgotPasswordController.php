<?php

namespace Grilar\ACL\Http\Controllers\Auth;

use Grilar\ACL\Http\Requests\ForgotPasswordRequest;
use Grilar\ACL\Traits\SendsPasswordResetEmails;
use Grilar\Base\Facades\Assets;
use Grilar\Base\Facades\PageTitle;
use Grilar\Base\Http\Controllers\BaseController;
use Grilar\Base\Http\Responses\BaseHttpResponse;
use Grilar\JsValidation\Facades\JsValidator;
use Illuminate\Http\Request;

class ForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails;

    public function __construct(protected BaseHttpResponse $response)
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        PageTitle::setTitle(trans('core/acl::auth.forgot_password.title'));

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

        $jsValidator = JsValidator::formRequest(ForgotPasswordRequest::class);

        return view('core/acl::auth.forgot-password', compact('jsValidator'));
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->response->setMessage(trans($response))->toResponse($request);
    }
}
