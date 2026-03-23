{{-- ═══ SHARED SIDEBAR ═══ --}}
{{-- Pass $activePage variable from your view to highlight the active link --}}
<aside class="shared-sidebar">
    <a href="{{ route('dashboard.1') }}" class="nav-link {{ ($activePage ?? '') === 'dashboard' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/1.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.dashboard') }}
    </a>
    <a href="{{ route('calendar') }}" class="nav-link {{ ($activePage ?? '') === 'calendar' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/2.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.calendar') }}
    </a>
    <a href="{{ route('learning') }}" class="nav-link {{ ($activePage ?? '') === 'learning' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/3.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.learning') }}
    </a>
    <a href="{{ route('courses') }}" class="nav-link {{ ($activePage ?? '') === 'courses' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/4.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.courses') }}
    </a>
    <a href="{{ route('quiz') }}" class="nav-link {{ ($activePage ?? '') === 'quiz' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/5.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.quiz') }}
    </a>
    <a href="{{ route('account.new') }}" class="nav-link {{ ($activePage ?? '') === 'account' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/6.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.account') }}
    </a>
    <a href="{{ route('wallet.address') }}" class="nav-link {{ ($activePage ?? '') === 'wallet' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/7.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.wallet_address') }}
    </a>
    <a href="{{ route('transaction') }}" class="nav-link {{ ($activePage ?? '') === 'transaction' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/8.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.transaction') }}
    </a>
    <a href="{{ route('payment.method') }}" class="nav-link {{ ($activePage ?? '') === 'payment' ? 'active' : '' }}">
        <img src="{{ asset('images/icons/9.png') }}" style="width: 22px; height: 22px;">
        {{ __('navigation.payment') }}
    </a>
</aside>
