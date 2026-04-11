<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full brand-lockup" href="#">
            <span class="brand-mark">{{ strtoupper(substr(trans('panel.site_title'), 0, 1)) }}</span>
            <span class="brand-title">{{ trans('panel.site_title') }}</span>
        </a>
    </div>

    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.home') }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>

                @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon"></i>
                    User Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.users.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/users*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon"></i>
                                Users
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/roles*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon"></i>
                                Roles
                            </a>
                        </li>
                    @endcan
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.permissions.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/permissions*') ? 'c-active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon"></i>
                                Permissions
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        @can('detail_access')
            <li
                class="c-sidebar-nav-dropdown {{ request()->is('admin/cities*', 'admin/states*', 'admin/countries*') ? 'c-show' : '' }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="c-sidebar-nav-icon fas fa-map"></i>
                    {{ trans('cruds.detail.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('city_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.cities.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/cities*') ? 'c-active' : '' }}">
                                <i class="c-sidebar-nav-icon fas fa-map-marker-alt"></i>
                                {{ trans('cruds.city.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('state_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.states.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/states*') ? 'c-active' : '' }}">
                                <i class="c-sidebar-nav-icon fas fa-map-signs"></i>
                                {{ trans('cruds.state.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('country_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.countries.index') }}"
                                class="c-sidebar-nav-link {{ request()->is('admin/countries*') ? 'c-active' : '' }}">
                                <i class="c-sidebar-nav-icon fas fa-flag"></i>
                                {{ trans('cruds.country.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('audit_log_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.audit-logs.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/audit-logs*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon"></i>
                    Audit Logs
                </a>
            </li>
        @endcan

        @can('setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.settings.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/settings*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon"></i>
                    Settings
                </a>
            </li>
        @endcan

        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.moderation.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/moderation*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-shield-alt c-sidebar-nav-icon"></i>
                Moderation
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.dispute-categories.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/dispute-categories*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-tags c-sidebar-nav-icon"></i>
                Dispute Categories
            </a>
        </li>

        @can('profile_password_edit')
            <li class="c-sidebar-nav-item">
                <a href="{{ route('profile.password.edit') }}" class="c-sidebar-nav-link {{ request()->is('profile/password*') ? 'c-active' : '' }}">
                    <i class="fa-fw fas fa-key c-sidebar-nav-icon"></i>
                    Change Password
                </a>
            </li>
        @endcan
        <li class="c-sidebar-nav-item">
            <a href="{{ route('admin.notifications.index') }}" class="c-sidebar-nav-link {{ request()->is('admin/notifications*') ? 'c-active' : '' }}">
                <i class="fa-fw fas fa-bell c-sidebar-nav-icon"></i>
                Notifications
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link"
                onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
