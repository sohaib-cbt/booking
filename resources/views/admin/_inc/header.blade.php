<div class="page-header">
    <div class="header-wrapper row m-0">

        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"> <a href="index.html"><img class="img-fluid for-light"
                        src="{{ asset('assets/images/logo/logo_dark.png') }}" alt="logo-light"><img
                        class="img-fluid for-dark" src="{{ asset('assets/images/logo/logo.png') }}" alt="logo-dark"></a>
            </div>
            <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
            <div>
                <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                <div class="d-flex align-items-center gap-2 ">
                    <h4 class="f-w-600">Welcome Admin</h4>
                    <img class="mt-0" src="{{ asset('assets/images/hand.gif') }}" alt="hand-gif">
                </div>
            </div>
            <div class="welcome-content d-xl-block d-none"><span class="text-truncate col-12">Here’s what’s
                    happening with your store today. </span>
            </div>
        </div>
        <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
                <li>
                    <div class="mode"><i class="moon" data-feather="moon"> </i></div>
                </li>
                @php
                    $user = auth()->user();
                    $profileImage = $user->image && file_exists(public_path($user->image))
                        ? asset($user->image)
                        : asset('assets/images/profile.png');
                @endphp

                <li class="profile-nav onhover-dropdown">
                    <div class="media profile-media">
                        <img class="b-r-10" src="{{ $profileImage }}" alt="Profile Image" width="50" height="50">

                        <div class="media-body d-xxl-block d-none box-col-none" style="margin-top: 4px">
                            <div class="d-flex align-items-center gap-2"> <span>{{ auth()->user()->name }}</span><i class="middle fa fa-angle-down"> </i></div>
                            <p class="mb-0 font-roboto">Admin</p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ route('profile') }}"><i data-feather="user"></i><span>My Profile</span></a>
                        </li>
                        <li>
                            <div class="customizer-links" style="display: flex; ">
                                <a id="c-pills-home-tab" data-bs-toggle="pill" href="#c-pills-home" role="tab" aria-controls="c-pills-home" aria-selected="true" >
                                    <i data-feather="settings"></i><span>Settings</span>
                                </a>
                            </div>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-pill btn-outline-primary btn-sm">Log
                                    Out</button>
                            </form>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>

        <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
    </div>
</div>
