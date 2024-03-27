<div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog modal-dialog-zoom" role="document" style="top:145px">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h6 class="modal-title fw-600">{{ translate('Account') }}</h6>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true"></span>
                </button>
            </div> -->
            <div class="modal-body">
                <!-- Tabs -->
                <div class="nav aiz-nav-tabs d-flex justify-content-between">
                    <a href="#tab_default_1" data-toggle="tab" class="mx-5 pb-2 fs-16 fw-700 text-reset active show">{{ translate('Login')}}</a>
                    <a href="#tab_default_2" data-toggle="tab" class="mx-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Register')}}</a>
                </div>

                <div class="tab-content pt-3">
                    <!-- login -->
                    <div class="tab-pane active show" id="tab_default_1">
                        <div class="p-3">
                            <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                                @csrf

                                @if (addon_is_activated('otp_system') && env('DEMO_MODE') != 'On')
                                    <!-- Phone -->
                                    <div class="form-group phone-form-group mb-1">
                                        <input type="tel" id="phone-code"
                                            class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                            value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                    </div>
                                    <!-- Country Code -->
                                    <input type="hidden" name="country_code" value="">
                                    <!-- Email -->
                                    <div class="form-group email-form-group mb-1 d-none">
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email"
                                            id="email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <!-- Use Email Instead -->
                                    <div class="form-group text-right">
                                        <button class="btn btn-link p-0 text-primary" type="button"
                                            onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Email Instead') }}</i></button>
                                    </div>
                                @else
                                    <!-- Use Email Instead -->
                                    <div class="form-group">
                                        <input type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            value="{{ old('email') }}" placeholder="{{ translate('Email') }}" name="email"
                                            id="email" autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Password -->
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control h-auto rounded-0 form-control-lg"
                                        placeholder="{{ translate('Password') }}">
                                </div>

                                <!-- Remember Me & Forgot password -->
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('password.request') }}"
                                            class="text-reset opacity-60 hov-opacity-100 fs-14">{{ translate('Forgot password?') }}</a>
                                    </div>
                                </div>

                                <!-- Login Button -->
                                <div class="mb-2">
                                    <button type="submit"
                                        class="btn btn-primary btn-block fw-600 rounded-4">{{ translate('Login') }}</button>
                                </div>
                            </form>

                            <!-- Social Login -->
                            @if (get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1)
                                <div class="separator mb-3">
                                    <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                                </div>
                                <ul class="list-inline social colored text-center mb-5">
                                    <!-- Facebook -->
                                    @if (get_setting('facebook_login') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                                class="facebook">
                                                <i class="lab la-facebook-f"></i>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- Google -->
                                    @if (get_setting('google_login') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                                class="google">
                                                <i class="lab la-google"></i>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- Twitter -->
                                    @if (get_setting('twitter_login') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                                class="twitter">
                                                <i class="lab la-twitter"></i>
                                            </a>
                                        </li>
                                    @endif
                                    <!-- Apple -->
                                    @if (get_setting('apple_login') == 1)
                                        <li class="list-inline-item">
                                            <a href="{{ route('social.login', ['provider' => 'apple']) }}"
                                                class="apple">
                                                <i class="lab la-apple"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @endif
                        </div>
                    </div>
                    <!-- registration -->
                    <div class="tab-pane" id="tab_default_2">
                        <div class="p-3">
                            <div class="">
                                <form id="reg-form" class="form-default" role="form" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label for="name" class="fs-12 fw-700 text-soft-dark">{{  translate('Full Name') }}</label>
                                        <input type="text" class="form-control rounded-0{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="{{  translate('Full Name') }}" name="name">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Email or Phone -->
                                    @if (addon_is_activated('otp_system'))
                                        <div class="form-group phone-form-group mb-1">
                                            <label for="phone" class="fs-12 fw-700 text-soft-dark">{{  translate('Phone') }}</label>
                                            <input type="tel" id="phone-code" class="form-control rounded-0{{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}" placeholder="" name="phone" autocomplete="off">
                                        </div>

                                        <input type="hidden" name="country_code" value="">

                                        <div class="form-group email-form-group mb-1 d-none">
                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                            <input type="email" class="form-control rounded-0 {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"  autocomplete="off">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group text-right">
                                            <button class="btn btn-link p-0 text-primary" type="button" onclick="toggleEmailPhone(this)"><i>*{{ translate('Use Email Instead') }}</i></button>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="email" class="fs-12 fw-700 text-soft-dark">{{  translate('Email') }}</label>
                                            <input type="email" class="form-control rounded-0{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- password -->
                                    <div class="form-group">
                                        <label for="password" class="fs-12 fw-700 text-soft-dark">{{  translate('Password') }}</label>
                                        <input type="password" class="form-control rounded-0{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{  translate('Password') }}" name="password">
                                        <div class="text-right mt-1">
                                            <span class="fs-12 fw-400 text-gray-dark">{{ translate('Password must contain at least 6 digits') }}</span>
                                        </div>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <!-- password Confirm -->
                                    <div class="form-group">
                                        <label for="password_confirmation" class="fs-12 fw-700 text-soft-dark">{{  translate('Confirm Password') }}</label>
                                        <input type="password" class="form-control rounded-0" placeholder="{{  translate('Confirm Password') }}" name="password_confirmation">
                                    </div>

                                    <!-- Recaptcha -->
                                    @if(get_setting('google_recaptcha') == 1)
                                        <div class="form-group">
                                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                                        </div>
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    @endif

                                    <!-- Terms and Conditions -->
                                    <div class="mb-3">
                                        <label class="aiz-checkbox">
                                            <input type="checkbox" name="checkbox_example_1" required>
                                            <span class="">{{ translate('By signing up you agree to our ')}} <a href="{{ route('terms') }}" class="fw-500">{{ translate('terms and conditions.') }}</a></span>
                                            <span class="aiz-square-check"></span>
                                        </label>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mb-4 mt-4">
                                        <button type="submit" class="btn btn-primary btn-block fw-600 rounded-4">{{  translate('Create Account') }}</button>
                                    </div>
                                </form>

                                <!-- Social Login -->
                                @if(get_setting('google_login') == 1 || get_setting('facebook_login') == 1 || get_setting('twitter_login') == 1 || get_setting('apple_login') == 1)
                                    <div class="text-center mb-3">
                                        <span class="bg-white fs-12 text-gray">{{ translate('Or Join With')}}</span>
                                    </div>
                                    <ul class="list-inline social colored text-center mb-4">
                                        @if (get_setting('facebook_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if(get_setting('google_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                                    <i class="lab la-google"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (get_setting('twitter_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if (get_setting('apple_login') == 1)
                                            <li class="list-inline-item">
                                                <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple">
                                                    <i class="lab la-apple"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
