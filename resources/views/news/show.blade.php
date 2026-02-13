<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('powerpuffsite/images/favicon.ico') }}" type="image/x-icon">
    <title>{{ $news->localized('text') }}</title>
    <link rel="stylesheet" href="{{ asset('powerpuffsite/css/main_home.min.css') }}">
    <link rel="stylesheet" href="{{ asset('powerpuffsite/css/addition.css') }}">
</head>
<body>
<div class="wrapper">
<header class="header">
    <div class="header__wrapper">
        <div class="header__container _container">
            <div class="header__body">
                <button type="button" class="menu__icon icon-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <div class="header__menu menu">
                    <nav class="menu__body" style="--logo-path: url('{{ asset($settings && $settings->logo_path ? $settings->logo_path : 'powerpuffsite/images/main/logo.png') }}');">
                        <ul class="menu__list">
                            <li class="menu__item">
                                <a href="{{ route('home') }}" class="menu__link">{{ __('main.home') }}</a>
                            </li>
                            <li class="menu__item">
                                <a href="{{ route('register') }}" class="menu__link">{{ __('main.registration') }}</a>
                            </li>
                            @auth
                            <li class="menu__item" style="padding-left: 53px;">
                                <a href="{{ route('cabinet') }}" class="actions-header__user menu__link">{{ __('main.personal_account') }}</a>
                            </li>
                            @else
                            <li class="menu__item" style="padding-left: 53px;">
                                <a href="{{ route('login') }}" class="actions-header__user menu__link">{{ __('main.personal_account') }}</a>
                            </li>
                            @endauth
                            @if(isset($activeLangs) && $activeLangs->count() > 1)
                            <li class="menu__item" style="padding-left: 30px; position: relative;">
                                <div class="lang-selector" style="position: relative; display: inline-block;">
                                    <a href="#" class="menu__link lang-current" onclick="event.preventDefault(); document.getElementById('lang-dropdown').classList.toggle('lang-show');" style="display: inline-flex; align-items: center; gap: 5px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                        {{ strtoupper(app()->getLocale()) }}
                                    </a>
                                    <div id="lang-dropdown" style="display: none; position: absolute; top: 100%; right: 0; background: rgba(20,20,30,0.95); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; min-width: 120px; z-index: 999; padding: 5px 0; margin-top: 5px;">
                                        @foreach($activeLangs as $lang)
                                        <a href="{{ route('locale.switch', $lang->code) }}" style="display: block; padding: 8px 16px; color: {{ app()->getLocale() === $lang->code ? '#fff' : '#aaa' }}; text-decoration: none; font-size: 14px; white-space: nowrap;">
                                            {{ $lang->native_name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="nk-app-root">
    <div class="nk-main">
        <div class="nk-wrap">
            <main class="page">
                <section class="page__main main">
                    <div class="main__container _container">
                        <div style="max-width: 900px; margin: 0 auto; padding: 60px 0 40px;">
                            <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #a0a0a0; text-decoration: none; margin-bottom: 30px; font-size: 14px; transition: color 0.2s;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                {{ __('main.back_to_home') }}
                            </a>

                            @if($news->images)
                            <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden;">
                                <img src="{{ asset($news->images) }}" alt="{{ $news->localized('text') }}" style="width: 100%; max-height: 450px; object-fit: cover; display: block;">
                            </div>
                            @endif

                            <div style="color: #8a8a9a; font-size: 14px; margin-bottom: 12px; letter-spacing: 0.5px;">{{ $news->date }}</div>

                            <h1 style="color: #fff; font-size: 32px; font-weight: 700; margin-bottom: 24px; line-height: 1.3;">{{ $news->localized('text') }}</h1>

                            <div style="color: #c0c0cc; font-size: 16px; line-height: 1.9; white-space: pre-wrap;">{{ $news->localized('content') }}</div>

                            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                                <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #a0a0a0; text-decoration: none; font-size: 14px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                                    {{ __('main.to_home') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="main__rock main-rock">
                        <div class="main-rock__item main-rock__1 layer"></div>
                        <div class="main-rock__item main-rock__2 layer"></div>
                        <div class="main-rock__item main-rock__3 layer"></div>
                        <div class="main-rock__item main-rock__4 layer"></div>
                    </div>
                </section>
            </main>
</div>
</div>
</div>

<section class="page__slider info" style="padding-top: 0; min-height: auto;">
    <div class="info__container _container">
        <div class="info__line gorizontal-line"></div>
        <footer class="footer">
            <div class="footer__copy">
                {{ __('main.developed_by') }}
            </div>
            <a href="https://isdteam.ru" rel="dofollow" title="Website development ISDteam" target="_blank" class="footer__logo ISDteam">
                <img src="{{ asset('powerpuffsite/images/isd.png') }}" alt="Website development ISDteam">
            </a>
        </footer>
    </div>
</section>

<script src="{{ asset('powerpuffsite/js/jquery-2.1.1.min.js') }}"></script>
<script src="{{ asset('powerpuffsite/js/vendor.min.js') }}"></script>
<script src="{{ asset('powerpuffsite/js/main_home.min.js') }}"></script>
<script>
document.addEventListener('click', function(e) {
    var dd = document.getElementById('lang-dropdown');
    if (dd && !e.target.closest('.lang-selector')) {
        dd.classList.remove('lang-show');
        dd.style.display = 'none';
    }
});
document.querySelectorAll('.lang-current').forEach(function(el) {
    el.addEventListener('click', function() {
        var dd = document.getElementById('lang-dropdown');
        dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
    });
});
</script>
</body>
</html>
