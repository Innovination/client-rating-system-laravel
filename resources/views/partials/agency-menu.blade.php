<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">
    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full brand-lockup" href="#">
            <span class="brand-mark">{{ strtoupper(substr(trans('panel.site_title'), 0, 1)) }}</span>
            <span class="brand-title">{{ trans('panel.site_title') }}</span>
        </a>
    </div>

    <ul class="c-sidebar-nav">

        {{-- Dashboard --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('agency.home') }}" class="c-sidebar-nav-link {{ request()->is('agency') ? 'c-active' : '' }}">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>

        {{-- Agency Profile --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('agency.profile.show') }}" class="c-sidebar-nav-link {{ request()->is('agency/profile*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-building c-sidebar-nav-icon"></i>
                Agency Profile
            </a>
        </li>

        {{-- Clients --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('agency.clients.index') }}" class="c-sidebar-nav-link {{ request()->is('agency/clients*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-address-book c-sidebar-nav-icon"></i>
                My Clients
            </a>
        </li>

        {{-- Public Client Directory --}}
        <li class="c-sidebar-nav-item">
            <a href="{{ route('clients.index') }}" class="c-sidebar-nav-link {{ request()->is('clients') || request()->is('clients/*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-search c-sidebar-nav-icon"></i>
                Client Directory
            </a>
        </li>

        {{-- Change Password --}}
        @can('profile_password_edit')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('profile.password.edit') }}" class="c-sidebar-nav-link {{ request()->is('profile/password*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-key c-sidebar-nav-icon"></i>
                    Change Password
                </a>
            </li>
        @endcan

        {{-- Logout --}}
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt"></i>
                {{ trans('global.logout') }}
            </a>
        </li>

    </ul>
</div>
