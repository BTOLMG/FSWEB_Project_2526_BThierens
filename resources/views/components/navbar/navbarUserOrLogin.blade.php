@auth
    <a class="profile-bar" href="{{ Auth::user()->rol === "actorbeheerder" ? route('account.index') : route('admin.index') }}">
        <h1 class="profile-header">{{ explode('.', explode('@', auth()->user()->email)[0])[0] }}</h1>
        <p class="profile-sub">{{ auth()->user()->rol }}</p>
    </a>
@else
    <a href="{{ route('login') }}" class="profile-btn">INLOGGEN</a>
@endauth
