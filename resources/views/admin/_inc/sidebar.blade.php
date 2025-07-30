<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="logo-wrapper">
        <a href="#"><img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt=""></a>
        <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
            </i>
        </div>
    </div>
    <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"
                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn">
                    <a href="#"><img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}"
                            alt=""></a>
                    <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div>
                        <h6>Pinned</h6>
                    </div>
                </li>
                {{-- Dashboard --}}
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg>
                        <span class="lan-3">Dashboard </span>
                    </a>
                </li>

                <li class="sidebar-main-title">
                    <div>
                        <h6>Menu</h6>
                    </div>
                </li>

                {{-- Groups --}}
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link sidebar-title {{ request()->routeIs('groups.*') ? 'active' : '' }}" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                        </svg>
                        <span>Groups</span>
                        <div class="according-menu">
                            <i class="fa fa-angle-{{ request()->routeIs('groups.*') ? 'down' : 'right' }}"></i>
                        </div>
                    </a>
                    <ul class="sidebar-submenu" style="{{ request()->routeIs('groups.*') ? 'display:block;' : '' }}">
                        <li>
                            <a class="{{ request()->routeIs('groups.index') ? 'active' : '' }}"
                                href="{{ route('groups.index') }}">
                                Groups
                            </a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('groups.create') ? 'active' : '' }}"
                                href="{{ route('groups.create') }}">
                                Add New Group
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Configration --}}
                <li class="sidebar-list">
                    <i class="fa fa-thumb-tack"></i>
                    <a class="sidebar-link sidebar-title
                        {{ request()->routeIs('schools.*') || request()->routeIs('teams.*') || request()->routeIs('therapists.*') || request()->routeIs('rooms.*') ? 'active' : '' }}"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                        </svg>
                        <span>Configuration</span>
                        <div class="according-menu">
                            <i class="fa fa-angle-{{ request()->routeIs('schools.*') || request()->routeIs('teams.*') || request()->routeIs('therapists.*') || request()->routeIs('rooms.*') ? 'down' : 'right' }}"></i>
                        </div>
                    </a>
                    <ul class="sidebar-submenu" style="{{ request()->routeIs('schools.*') || request()->routeIs('teams.*') || request()->routeIs('therapists.*') || request()->routeIs('rooms.*') ? 'display:block;' : '' }}">
                        <li>
                            <a class="{{ request()->routeIs('schools.*') ? 'active' : '' }}" href="{{ route('schools.index') }}">School</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('teams.*') ? 'active' : '' }}" href="{{ route('teams.index') }}">Team</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('therapists.*') ? 'active' : '' }}" href="{{ route('therapists.index') }}">Therapist</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">Room</a>
                        </li>
                    </ul>
                </li>

             <li class="sidebar-list">
                <i class="fa fa-thumb-tack"></i>
                <a class="sidebar-link sidebar-title {{ request()->routeIs('bookings.*') ? 'active' : '' }}" href="#">
                    <svg class="stroke-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                        <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                    </svg>
                    <span>Booking</span>
                    <div class="according-menu">
                        <i class="fa fa-angle-{{ request()->routeIs('bookings.*') ? 'down' : 'right' }}"></i>
                    </div>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('bookings.*') ? 'display:block;' : '' }}">
                    <li>
                        <a class="{{ request()->routeIs('bookings.index') ? 'active' : '' }}" href="{{ route('bookings.index') }}">Bookings</a>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('bookings.create') ? 'active' : '' }}" href="{{ route('bookings.create') }}">Add New Booking</a>
                    </li>
                </ul>
            </li>


            </ul>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</div>
