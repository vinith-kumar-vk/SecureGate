{{-- ═══ SHARED HEADER / TOP BAR ═══ --}}
{{-- Include translation helper for JavaScript --}}
@once
    @include('partials.translations')
@endonce

<header class="shared-header">
    <div class="header-pill">
        <div class="header-left">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
            <a href="{{ route('category') }}" class="cat-dropdown">
                {{ __('navigation.categories') }}
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
            <div class="search-wrap">
                <a href="{{ route('search') }}" style="position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#94a3b8;z-index:1;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </a>
                <input type="text" placeholder="{{ __('common.search_placeholder') }}">
            </div>
        </div>
        <div class="header-right">
            <a href="#" class="h-icon-btn" title="{{ __('navigation.wishlist') }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </a>
            <a href="{{ route('shopping.cart') }}" class="h-icon-btn" title="{{ __('navigation.cart') }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </a>
            <div class="h-icon-btn" title="{{ __('navigation.notifications') }}">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                <span class="notif-badge">2</span>
            </div>
            <form method="POST" class="language-selector" style="display: inline;">
                @csrf
                <select name="locale" onchange="
                    const selectedLocale = this.value;
                    const form = this.closest('form');
                    form.action = '/set-language/' + selectedLocale;
                    form.submit();
                " style="padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; background: #f1f5f9; color: #334155;">
                    @php
                        $languages = config('languages.languages') ?? [
                            'en' => ['flag' => 'en-US', 'native_name' => 'English'],
                            'th' => ['flag' => '🇹🇭', 'native_name' => 'ไทย'],
                        ];
                    @endphp
                    @foreach($languages as $locale => $lang)
                        <option value="{{ $locale }}" @selected(app()->getLocale() === $locale)>
                            {{ $lang['flag'] ?? '' }} {{ $lang['native_name'] ?? $locale }}
                        </option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('account.new') }}" class="profile-pill">
                <div class="avatar-head"></div>
                <span>{{ Auth::check() ? Auth::user()->name : 'Student' }}</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" opacity="0.6"><path d="m6 9 6 6 6-6"/></svg>
            </a>
        </div>
    </div>
</header>
