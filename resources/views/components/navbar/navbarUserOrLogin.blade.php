@auth
    <div class="profile-img"></div>
    <div class="profile-header">{{ auth()->user()->email }}</div>
    <div class="profile-sub">{{ auth()->user()->rol }}</div>
@else
    <button class="inloggen-btn">INLOGGEN</button>
@endauth
