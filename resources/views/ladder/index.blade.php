<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('powerpuffsite/images/favicon.ico') }}" type="image/x-icon">
    <title>{{ __('main.ladder_title') }}</title>
    <link rel="stylesheet" href="{{ asset('powerpuffsite/css/main_home.min.css') }}">
    <link rel="stylesheet" href="{{ asset('powerpuffsite/css/addition.css') }}">
    @if(file_exists(public_path('powerpuffsite/css/ladder/core.b15be49248362418ef78.css')))
    <link href="{{ asset('powerpuffsite/css/ladder/core.b15be49248362418ef78.css') }}" rel="stylesheet" type="text/css"/>
    @endif
    @if(file_exists(public_path('powerpuffsite/css/ladder/5.60a3b147f091048d9af5.css')))
    <link href="{{ asset('powerpuffsite/css/ladder/5.60a3b147f091048d9af5.css') }}" rel="stylesheet" type="text/css"/>
    @endif
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

<main id="main" role="main">
    <div class="Pane bordered Pane--underSiteNav Pane--above Pane--full Pane--abover" media-medium="!Pane--full">
        <div class="Pane-bgg" style="background-image:url('{{ asset('powerpuffsite/images/ladder/bg.jpg') }}');">
            <div class="Pane-overlay"></div>
        </div>

        <div class="Pane-content">
            <div class="space-medium"></div>
            <div media-huge="space-medium"></div>
            <div class="align-center" media-wide="!align-center align-left">
                <h1 class="margin-none font-semp-xxxLarge-white">{{ __('main.ladder_title') }}</h1>
            </div>
            <div class="space-rhythm-medium"></div>
            <div class="contain-large align-center" media-wide="!align-center !contain-large contain-wide contain-left align-left">
                <p class="margin-none font-bliz-light-small-beige">{{ __('main.ladder_description') }}</p>
            </div>
            <div class="space-rhythm-medium"></div>
            <div class="contain-medium gutter-small" media-medium="!gutter-small" media-nav="!contain-medium">
                <div class="List List--vertical List--full" media-nav="!List--full !List--vertical List--gutters">
                    <div class="List-item">
                        <div class="SelectMenu SelectMenu--fullscreen" media-medium="!SelectMenu--fullscreen">
                            <div class="SelectMenu-toggle">{{ __('main.arena_type') }}</div>
                        </div>
                        <div class="space-normal" media-nav="!space-normal"></div>
                    </div>
                    <div class="List-item">
                        <div class="SelectMenu SelectMenu--fullscreen" media-medium="!SelectMenu--fullscreen">
                            <div class="SelectMenu-toggle">
                                @if($type == 5){{ __('main.arena_1v1') }}
                                @elseif($type == 3){{ __('main.arena_2v2') }}
                                @elseif($type == 2){{ __('main.arena_3v3') }}
                                @else{{ __('main.arena_1v1') }}
                                @endif
                            </div>
                            <div class="SelectMenu-menu">
                                <div class="SelectMenu-close">
                                    <span class="Icon Icon--closeGold SelectMenu-close-icon"></span>
                                </div>
                                <div class="SelectMenu-inputContainer">
                                    <input class="SelectMenu-input" type="search" placeholder="{{ __('main.search') }}..."/>
                                </div>
                                <div class="SelectMenu-items">
                                    <div class="SelectMenu-item" data-value="{{ __('main.arena_1v1') }}">
                                        <a class="Link SelectMenu-link" href="{{ route('ladder', ['type' => 5]) }}">
                                            {{ __('main.arena_1v1') }}
                                        </a>
                                    </div>
                                    <div class="SelectMenu-item" data-value="{{ __('main.arena_2v2') }}">
                                        <a class="Link SelectMenu-link" href="{{ route('ladder', ['type' => 3]) }}">
                                            {{ __('main.arena_2v2') }}
                                        </a>
                                    </div>
                                    <div class="SelectMenu-item" data-value="{{ __('main.arena_3v3') }}">
                                        <a class="Link SelectMenu-link" href="{{ route('ladder', ['type' => 2]) }}">
                                            {{ __('main.arena_3v3') }}
                                        </a>
                                    </div>
                                    <div class="SelectMenu-exception">{{ __('main.no_results') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-medium" media-wide="space-huge"></div>
        </div>
    </div>

    <div class="Divider"></div>
    <div class="Pane Pane--dirtBlue bordered">
        <div class="Pane-bgg">
            <div class="Pane-overlay"></div>
        </div>

        <div class="Pane-content">
            <div media-wide="space-normal"></div>
            <div class="space-normal"></div>
            <div class="Paginator" data-page="1" data-size="30" data-total="{{ count($ladderData) }}">
                <div class="Paginator-pages">
                    <div class="Paginator-page" data-page="1">
                        <div class="SortTable SortTable--flex">
                            <div class="SortTable-head">
                                <div class="SortTable-row">
                                    <div class="SortTable-col SortTable-label is-sorted" data-priority="1">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.rank') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label" data-priority="2">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.rating_tier') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label SortTable-label--left" data-priority="1">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.player') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label hide" data-priority="4" media-wide="!hide">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.class') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label hide" data-priority="4" media-wide="!hide">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.faction') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label hide" data-priority="4" media-wide="!hide">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.realm') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label hide" data-priority="3" media-wide="!hide">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.wins') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-label hide" data-priority="6" media-wide="!hide">
                                        <div class="SortTable-labelOuter">
                                            <div class="SortTable-labelInner">
                                                <div class="SortTable-labelText">{{ __('main.losses') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="SortTable-body">
                                @forelse($ladderData as $player)
                                <div class="SortTable-row">
                                    <div class="SortTable-col SortTable-data align-center text-nowrap" data-value="{{ $player['id'] }}">{{ $player['id'] }}</div>
                                    <div class="SortTable-col SortTable-data align-center text-nowrap">
                                        <div class="flex flex-align-center flex-justify-center">
                                            <a class="Link" data-tooltip="pvp-tier-tooltip-{{ $player['ratingInfo'] }}">
                                                <div class="List">
                                                    <div class="List-item">
                                                        @if(file_exists(public_path("powerpuffsite/images/ladder/arena/{$player['ratingInfo']}.png")))
                                                        <img src="{{ asset("powerpuffsite/images/ladder/arena/{$player['ratingInfo']}.png") }}" style="max-width: 32px; margin-right: 5px;" alt="">
                                                        @endif
                                                    </div>
                                                    <div class="List-item">{{ $player['rating'] }}</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="SortTable-col SortTable-data" data-value="{{ $player['name'] }}">
                                        <a class="Link Character Character--{{ $player['classImg'] }} Character--inline Character--small Character--name margin-top-xSmall" media-wide="Character--avatar">
                                            <div class="Character-link">
                                                <div class="Character-table">
                                                    <div class="Character-bust">
                                                        <div class="Art Art--above">
                                                            <div class="Art-size" style="padding-top:50.43478260869565%"></div>
                                                            @if(file_exists(public_path("powerpuffsite/images/ladder/race/{$player['race']}.jpg")))
                                                            <div class="Art-image" style="background-image:url('{{ asset("powerpuffsite/images/ladder/race/{$player['race']}.jpg") }}');"></div>
                                                            @endif
                                                            <div class="Art-overlay"></div>
                                                        </div>
                                                    </div>
                                                    <div class="Character-avatar">
                                                        <div class="Avatar Avatar--medium">
                                                            @if(file_exists(public_path("powerpuffsite/images/ladder/race/{$player['race']}.jpg")))
                                                            <div class="Avatar-image" style="background-image:url('{{ asset("powerpuffsite/images/ladder/race/{$player['race']}.jpg") }}');"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="Character-details">
                                                        <div class="Character-role"></div>
                                                        <div class="Character-name">{{ $player['name'] }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="SortTable-col SortTable-data hide align-center" media-wide="!hide">
                                        <a class="Link" data-tooltip="2-{{ $player['name'] }}-character-class-tooltip">
                                            <div class="GameIcon GameIcon--{{ $player['classImg'] }} GameIcon--medium GameIcon--bordered GameIcon--rounded margin-top-xSmall">
                                                <div class="GameIcon-icon"></div>
                                                <div class="GameIcon-transmog"></div>
                                                <div class="GameIcon-borderImage"></div>
                                            </div>
                                        </a>
                                        <div class="Tooltip" name="2-{{ $player['name'] }}-character-class-tooltip">
                                            <div class="GameTooltip">
                                                <div class="ui-tooltip">
                                                    <div class="font-bliz-light-small-white">
                                                        {{ $player['class'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-data hide font-none align-center" data-value="{{ $player['faction'] }}" media-wide="!hide">
                                        <a class="Link" data-tooltip="2-{{ $player['name'] }}-character-faction-tooltip">
                                            <span class="Icon Icon--{{ $player['faction'] }} Icon--medium">
                                                @if(file_exists(public_path("powerpuffsite/images/ladder/faction/{$player['faction']}.png")))
                                                <img class="Icon-svg" src="{{ asset("powerpuffsite/images/ladder/faction/{$player['faction']}.png") }}" alt="">
                                                @endif
                                            </span>
                                        </a>
                                        <div class="Tooltip" name="2-{{ $player['name'] }}-character-faction-tooltip">
                                            <div class="GameTooltip">
                                                <div class="ui-tooltip">
                                                    <div class="font-bliz-light-small-white">
                                                        {{ $player['faction'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="SortTable-col SortTable-data hide text-nowrap align-center" data-value="Server" media-wide="!hide">Server</div>
                                    <div class="SortTable-col SortTable-data hide text-nowrap align-center color-status-success" data-value="{{ $player['seasonWins'] }}" media-wide="!hide">{{ $player['seasonWins'] }}</div>
                                    <div class="SortTable-col SortTable-data hide text-nowrap align-center color-status-error" data-value="-{{ $player['seasonLosses'] }}" media-wide="!hide">-{{ $player['seasonLosses'] }}</div>
                                </div>
                                @empty
                                <div class="SortTable-row">
                                    <div class="SortTable-col SortTable-data" style="padding: 40px; text-align: center; color: rgba(255,255,255,0.6); grid-column: 1 / -1;">
                                        {{ __('main.no_ladder_data') }}
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-huge"></div>
            <div media-wide="space-large"></div>
            <div class="Tooltip" name="pvp-tier-tooltip-8">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-8.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_no_rank') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_no_rank_desc') }}</div></div></div>
            </div>
            <div class="Tooltip" name="pvp-tier-tooltip-9">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-9.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_combatant') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_combatant_desc') }}</div></div></div>
            </div>
            <div class="Tooltip" name="pvp-tier-tooltip-11">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-11.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_challenger') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_challenger_desc') }}</div></div></div>
            </div>
            <div class="Tooltip" name="pvp-tier-tooltip-12">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-12.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_rival') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_rival_desc') }}</div></div></div>
            </div>
            <div class="Tooltip" name="pvp-tier-tooltip-13">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-13.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_duelist') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_duelist_desc') }}</div></div></div>
            </div>
            <div class="Tooltip" name="pvp-tier-tooltip-14">
                <div class="GameTooltip"><div class="ui-tooltip"><div class="List"><div class="List-item"><img src="{{ asset('powerpuffsite/images/ladder/arena/pvp-tier-tooltip-14.png') }}" style="max-width: 32px;"></div><div class="List-item gutter-small-left"><div class="font-bliz-light-small-white">{{ __('main.tier_gladiator') }}</div></div></div><div class="space-small"></div><div class="font-size-xSmall color-beige-medium">{{ __('main.tier_gladiator_desc') }}</div></div></div>
            </div>
        </div>
    </div>
</main>

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
</div>

@if(file_exists(public_path('powerpuffsite/js/ladder/core.04c3634bf4bf834dbb46.js')))
<script src="{{ asset('powerpuffsite/js/ladder/core.04c3634bf4bf834dbb46.js') }}"></script>
<script id="init">window.trigger("init");</script>
@endif
<script src="{{ asset('powerpuffsite/js/vendor.min.js') }}"></script>
<script src="{{ asset('powerpuffsite/js/main_home.min.js') }}"></script>
<script>
(function() {
    // SelectMenu functionality
    document.addEventListener('DOMContentLoaded', function() {
        var selectMenus = document.querySelectorAll('.SelectMenu');
        
        selectMenus.forEach(function(selectMenu) {
            var toggle = selectMenu.querySelector('.SelectMenu-toggle');
            var menu = selectMenu.querySelector('.SelectMenu-menu');
            var close = selectMenu.querySelector('.SelectMenu-close');
            var input = selectMenu.querySelector('.SelectMenu-input');
            var items = selectMenu.querySelectorAll('.SelectMenu-item');
            var exception = selectMenu.querySelector('.SelectMenu-exception');
            
            if (!toggle || !menu) return;
            
            // Toggle menu on click
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                selectMenu.classList.toggle('is-open');
                menu.style.display = selectMenu.classList.contains('is-open') ? 'block' : 'none';
            });
            
            // Close menu
            if (close) {
                close.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    selectMenu.classList.remove('is-open');
                    menu.style.display = 'none';
                    if (input) input.value = '';
                    filterItems();
                });
            }
            
            // Filter items on input
            function filterItems() {
                if (!input) return;
                var filter = input.value.toLowerCase();
                var found = false;
                
                items.forEach(function(item) {
                    var text = (item.textContent || item.innerText).toLowerCase();
                    if (text.indexOf(filter) > -1) {
                        item.style.display = '';
                        found = true;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                if (exception) {
                    exception.style.display = found ? 'none' : 'block';
                }
            }
            
            if (input) {
                input.addEventListener('keyup', filterItems);
            }
            
            // Close on outside click
            document.addEventListener('click', function(e) {
                if (!selectMenu.contains(e.target)) {
                    selectMenu.classList.remove('is-open');
                    menu.style.display = 'none';
                }
            });
        });
    });
})();
</script>
</body>
</html>
