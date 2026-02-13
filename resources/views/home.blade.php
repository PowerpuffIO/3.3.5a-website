<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('powerpuffsite/images/favicon.ico') }}" type="image/x-icon">
    <meta name="description" content="{{ $settings ? $settings->localizedSiteDescription() : '' }}">
    <meta name="format-detection" content="telephone=no">
    <title>{{ $settings ? $settings->localizedSiteTitle() : 'WoW Server' }}</title>
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
                                <a href="{{ route('ladder') }}" class="menu__link">{{ __('main.ladder') }}</a>
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
                <div class="page__soc soc vertical-figure">
                    <div class="vertical-figure__body">
                        <div class="vertical-figure__line vertical-figure__line_top"></div>
                        <ul class="soc__list">
                            @foreach($socialLinks as $social)
                            <li class="soc__item">
                                <a href="{{ $social->link }}" class="{{ $social->class }}"></a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="vertical-figure__line vertical-figure__line_bottom"></div>
                    </div>
                </div>

                <section class="page__main main">
                    <div class="main__container _container">
                        <div class="main__body">
                            <a href="{{ route('home') }}" class="main__logo">
                                <picture>
                                    @php
                                        $logoPath = $settings && $settings->logo_path ? $settings->logo_path : 'powerpuffsite/images/main/logo.png';
                                    @endphp
                                    <img src="{{ asset($logoPath) }}" alt="Image">
                                </picture>
                            </a>
                            <h1 class="main__title">
                                {{ $settings ? $settings->localizedTitle() : '' }}
                            </h1>
                            <div class="main__text">
                                {{ $settings ? $settings->localizedText() : '' }}
                            </div>
                            <a href="#howtostart" class="main__button">
                                <span>{{ __('main.start_playing') }}</span>
                            </a>
                        </div>

                        <div class="main__news news">
                            @foreach($news as $item)
                            <div class="news__column">
                                <a href="{{ route('news.show', $item) }}" class="news__item news-item">
                                    <div class="news-item__image _ibg">
                                        <picture>
                                            <img src="{{ asset($item->images) }}" alt="{{ $item->text }}">
                                        </picture>
                                    </div>
                                    <div class="news-item__content">
                                        <h3 class="news-item__title">{{ $item->date }}</h3>
                                        <p class="news-item__text">{{ $item->localized('text') }}</p>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <div class="main__news-button">
                            <a href="{{ route('news.index') }}" class="main__news-link">{{ __('main.all_news') }}</a>
                        </div>
                    </div>

                    <div class="main__rock main-rock">
                        <div class="main-rock__item main-rock__1 layer"></div>
                        <div class="main-rock__item main-rock__2 layer"></div>
                        <div class="main-rock__item main-rock__3 layer"></div>
                        <div class="main-rock__item main-rock__4 layer"></div>
                    </div>
                </section>

                @if($realms->count() > 0)
                <div class="page__server server">
                    <div class="server__container _container">
                        <div class="info__line gorizontal-line"></div>
                        <div class="server__image">
                            <picture>
                                <img src="{{ asset('powerpuffsite/images/server/bg.png') }}" alt="Image">
                            </picture>
                        </div>
                        <div class="server__content">
                            <div class="server__tabs tabs-server _tabs">
                                <nav class="tabs-server__nav">
                                    @foreach($realms as $realm)
                                    <div class="tabs-server__item _tabs-item{{ $loop->first ? ' _active' : '' }}">
                                        <h2><span>{{ $realm->localized('name') }} <span>{{ $realm->rate }}</span></span></h2>
                                    </div>
                                    @endforeach
                                </nav>
                                <div class="tabs-server__body">
                                    @foreach($realms as $realm)
                                    <div class="tabs-server__block block-server _tabs-block{{ $loop->first ? ' _active' : '' }}">
                                        <div class="block-server__header">
                                            <h2 class="block-server__title">{{ $realm->localized('name') }}<span>{{ $realm->rate }}</span></h2>
                                            <div class="block-server__counter">{{ __('main.online') }}: <span>0</span></div>
                                        </div>
                                        <div class="block-server__text">
                                            {{ $realm->localized('description') }}
                                        </div>
                                        <ul class="block-server__list">
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->rate }}</div>
                                                    <div class="block-server__info-title">{{ __('main.experience') }}</div>
                                                </div>
                                            </li>
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->proffesion }}</div>
                                                    <div class="block-server__info-title">{{ __('main.professions') }}</div>
                                                </div>
                                            </li>
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->gold }}</div>
                                                    <div class="block-server__info-title">{{ __('main.gold') }}</div>
                                                </div>
                                            </li>
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->rep }}</div>
                                                    <div class="block-server__info-title">{{ __('main.reputation') }}</div>
                                                </div>
                                            </li>
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->loot }}</div>
                                                    <div class="block-server__info-title">{{ __('main.loot') }}</div>
                                                </div>
                                            </li>
                                            <li class="block-server__item-block">
                                                <div class="block-server__item">
                                                    <div class="block-server__info">{{ $realm->honor }}</div>
                                                    <div class="block-server__info-title">{{ __('main.honor_points') }}</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </main>
        </div>
    </div>
</div>

@if($features->count() > 0)
<div class="info__line gorizontal-line"></div>
<section class="page__features features">
    <div class="features__container _container">
        <div class="features__content">
            <h2 class="features__title">{{ __('main.features_title') }}</h2>
            <div class="features__slider">
                @foreach($features as $feature)
                <div class="features__item">
                    <div class="features-item__icon">
                        <picture>
                            <img src="{{ asset($feature->image) }}" alt="{{ $feature->localized('title') }}">
                        </picture>
                    </div>
                    <h3 class="features-item__title">{{ $feature->localized('title') }}</h3>
                    <div class="features-item__text">
                        {{ $feature->localized('description') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="info__line gorizontal-line"></div>
    <footer class="footer">
        <div class="footer__copy">
            {{ __('main.developed_by') }}
        </div>
        <a href="https://powerpuff.pro" rel="dofollow" title="Website & Development" target="_blank" class="footer__logo_Powerpuff">
            <img src="{{ asset('powerpuffsite/fonts/powerpuff.png') }}" alt="Powerpuff - website creation">
        </a>
    </footer>
</section>
@else
<section class="page__features features">
    <div class="features__container _container">
        <div class="info__line gorizontal-line"></div>
        <footer class="footer">
            <div class="footer__copy">
                {{ __('main.developed_by') }}
            </div>
            <a href="https://powerpuff.pro" rel="dofollow" title="Website & Development" target="_blank" class="footer__logo_Powerpuff">
                <img src="{{ asset('powerpuffsite/fonts/powerpuff.png') }}" alt="Powerpuff - website creation">
            </a>
        </footer>
    </div>
</section>
@endif

<div id="howtostart" class="modalDialog">
    <div>
        <a href="#close" title="{{ __('main.close') }}" class="closemodal">X</a>
        <div class="modal__top">
            <div class="modal__top-left">
                <h3 class="title__modal">{{ __('main.download_full_game') }}</h3>
                <p class="modal__left-subtitle">{{ __('main.client_size_text') }} {{ $hts->client_size ?? '25.6 GB' }}</p>
                <p class="modal__left-text">{{ __('main.download_problems_text') }}</p>
                <div class="modal__linkDown">
                    @if(($hts->google_drive_active ?? true) && ($hts->google_drive_url ?? ''))
                    <a href="{{ $hts->google_drive_url }}" class="modal__linkDown-item" target="_blank">
                        <span class="img__link__modal">
                            <img src="{{ asset('powerpuffsite/images/l1.png') }}" alt="">
                        </span> Google Drive
                    </a>
                    @endif
                    @if(($hts->yandex_disk_active ?? true) && ($hts->yandex_disk_url ?? ''))
                    <a href="{{ $hts->yandex_disk_url }}" class="modal__linkDown-item" target="_blank">
                        <span class="img__link__modal">
                            <img src="{{ asset('powerpuffsite/images/l2.png') }}" alt="">
                        </span> Yandex Disk
                    </a>
                    @endif
                    @if(($hts->filemail_active ?? true) && ($hts->filemail_url ?? ''))
                    <a href="{{ $hts->filemail_url }}" class="modal__linkDown-item" target="_blank">
                        <span class="img__link__modal">
                            <img src="{{ asset('powerpuffsite/images/l3.png') }}" alt="">
                        </span> FileMail
                    </a>
                    @endif
                    @if(($hts->mega_active ?? true) && ($hts->mega_url ?? ''))
                    <a href="{{ $hts->mega_url }}" class="modal__linkDown-item" target="_blank">
                        <span class="img__link__modal">
                            <img src="{{ asset('powerpuffsite/images/l4.png') }}" alt="">
                        </span> MegaNZ
                    </a>
                    @endif
                    @if(($hts->torrent_active ?? true) && ($hts->torrent_url ?? ''))
                    <a href="{{ $hts->torrent_url }}" class="modal__linkDown-item" target="_blank">
                        <span class="img__link__modal">
                            <img src="{{ asset('powerpuffsite/images/l5.png') }}" alt="">
                        </span> Torrent File
                    </a>
                    @endif
                </div>
            </div>
            <div class="modal__top-right">
                <h3 class="title__modal">{{ __('main.launcher') }}</h3>
                <a href="{{ $hts->launcher_url ?? '#' }}" class="btn_modal-dowm" target="_blank">{{ $hts ? $hts->localizedLauncherText() : __('main.launcher') }}</a>
                <p class="modal__right-text">{{ $hts ? $hts->localizedLauncherDescription() : '' }}</p>
            </div>
        </div>
        <div class="modal__bottom">
            <div class="modal__bottom-left">
                <h3 class="title__modal">{{ __('main.update_drivers') }}</h3>
                <a href="https://www.nvidia.com/Download" class="nvidea_link" target="_blank">
                    <img src="{{ asset('powerpuffsite/images/d1.png') }}" alt="">
                </a>
                <div class="modal__driver">
                    <a href="https://www.amd.com/support" class="amd_link" target="_blank">
                        <img src="{{ asset('powerpuffsite/images/d2.png') }}" alt="">
                    </a>
                    <a href="https://www.microsoft.com/Download/confirmation.aspx?id=35" class="directx_link" target="_blank">
                        <img src="{{ asset('powerpuffsite/images/d3.png') }}" alt="">
                    </a>
                </div>
            </div>
            <div class="modal__bottom-right">
                <h3 class="title__modal">{{ __('main.system_requirements') }}</h3>
                <div class="modal__system">
                    <div class="modal__system_item title">
                        <span class="system__colum">{{ __('main.components') }}</span>
                        <span class="system__colum">{{ __('main.minimum') }}</span>
                        <span class="system__colum">{{ __('main.recommended') }}</span>
                    </div>
                    <div class="modal__system_item">
                        <span class="system__colum grey">{{ __('main.storage') }}</span>
                        <span class="system__colum">{{ $hts->req_storage_min ?? '27gb' }}</span>
                        <span class="system__colum">{{ $hts->req_storage_rec ?? '30gb' }}</span>
                    </div>
                    <div class="modal__system_item">
                        <span class="system__colum grey">Windows</span>
                        <span class="system__colum">{{ $hts->req_windows_min ?? 'Windows 7' }}</span>
                        <span class="system__colum">{{ $hts->req_windows_rec ?? 'Windows 10' }}</span>
                    </div>
                    <div class="modal__system_item">
                        <span class="system__colum grey">{{ __('main.ram') }}</span>
                        <span class="system__colum">{{ $hts->req_ram_min ?? '2gb' }}</span>
                        <span class="system__colum">{{ $hts->req_ram_rec ?? '6gb' }}</span>
                    </div>
                    <div class="modal__system_item">
                        <span class="system__colum grey">{{ __('main.video_card') }}</span>
                        <span class="system__colum">{{ $hts->req_gpu_min ?? '256mb' }}</span>
                        <span class="system__colum">{{ $hts->req_gpu_rec ?? '1024mb' }}</span>
                    </div>
                    <div class="modal__system_item">
                        <span class="system__colum grey">{{ __('main.internet') }}</span>
                        <span class="system__colum">{{ $hts->req_internet_min ?? '10 Mbit/s' }}</span>
                        <span class="system__colum">{{ $hts->req_internet_rec ?? '50 Mbit/s' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="md-overlay"></div>
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
