@extends('layouts.app')

@section('title', __('main.login'))

@section('content')
<div class="nk-wrap nk-wrap-nosidebar">
    <div class="nk-content">
        <div class="nk-split nk-split-page nk-split-md">
            <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                <div class="nk-block nk-block-middle nk-auth-body">
                    <div class="brand-logo pb-5">
                        <a href="{{ route('home') }}" class="logo-link">
                            @php
                                $logoPath = isset($settings) && $settings && $settings->logo_path ? $settings->logo_path : 'powerpuffsite/images/main/logo.png';
                            @endphp
                            <img class="logo-light logo-img" src="{{ asset($logoPath) }}" alt="logo">
                        </a>
                    </div>
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">{{ __('main.login') }}</h5>
                        </div>
                    </div>

                    <div class="col-sm-12 tabs">
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <form id="loginForm">
                                    @csrf
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="username">{{ __('main.login_field') }}</label>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="{{ __('main.enter_login') }}" value="" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">{{ __('main.password') }}</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch is-hidden" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg is-hidden" id="password" name="password" placeholder="{{ __('main.enter_password') }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-block login-btn">{{ __('main.sign_in') }}</button>
                                    </div>
                                    <p class="msg none"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block nk-auth-footer">
                    <div class="mt-3">
                        <div class="form-note-s2 pt-4">
                            {{ __('main.no_account') }}
                            <a href="{{ route('register') }}"><strong>{{ __('main.register') }}</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(config('recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.site_key') }}"></script>
@endif
<script>
$(document).ready(function() {
    $('.login-btn').click(function (e) {
        e.preventDefault();
        $('input').removeClass('error');
        
        @if(config('recaptcha.site_key'))
        // Get reCAPTCHA token
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ config('recaptcha.site_key') }}', {action: 'login'}).then(function(token) {
                let username = $('input[name="username"]').val();
                let password = $('input[name="password"]').val();
                $.ajax({
                    url: '{{ route("login") }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        username: username,
                        password: password,
                        recaptcha_token: token,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status) {
                            document.location.href = data.redirect || '{{ route("cabinet") }}';
                        } else {
                            $('.msg').removeClass('none').text(data.message || '{{ __("main.login_error") }}');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.username) {
                                $('input[name="username"]').addClass('error');
                            }
                            if (errors.password) {
                                $('input[name="password"]').addClass('error');
                            }
                            $('.msg').removeClass('none').text(errors.username ? errors.username[0] : '{{ __("main.validation_error") }}');
                        } else {
                            $('.msg').removeClass('none').text('{{ __("main.server_error") }}');
                        }
                    }
                });
            });
        });
        @else
        // reCAPTCHA not configured, submit form without token
        let username = $('input[name="username"]').val();
        let password = $('input[name="password"]').val();
        $.ajax({
            url: '{{ route("login") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                username: username,
                password: password,
                recaptcha_token: '',
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.status) {
                    document.location.href = data.redirect || '{{ route("cabinet") }}';
                } else {
                    $('.msg').removeClass('none').text(data.message || '{{ __("main.login_error") }}');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.username) {
                        $('input[name="username"]').addClass('error');
                    }
                    if (errors.password) {
                        $('input[name="password"]').addClass('error');
                    }
                    $('.msg').removeClass('none').text(errors.username ? errors.username[0] : '{{ __("main.validation_error") }}');
                } else {
                    $('.msg').removeClass('none').text('{{ __("main.server_error") }}');
                }
            }
        });
        @endif
    });
});
</script>
@endpush
