<!-- main-header opened -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="responsive-logo">
                <a href="{{ route('rfoof.admin') }}"><img src="{{ asset('uploads/default.png') }}"
                        class="logo-1" alt="logo"></a>
                <a href="{{ route('rfoof.admin') }}"><img src="{{ asset('uploads/default.png') }}"
                        class="logo-2" alt="logo"></a>
            </div>
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="javascript:void();" onclick="sidebar_session(true, 1)"><i
                        class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="javascript:void();" onclick="sidebar_session(true, 0)"><i
                        class="header-icons fe fe-x"></i></a>
            </div>
        </div>
        @include('rfoof.layouts.footer')
        <div class="main-header-right">

            <div class="nav nav-item">
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href=""><img alt=""
                            src="{{ asset('uploads/default.png') }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="" src="{{ asset('uploads/default.png') }}"
                                        class=""></div>
                                <div class="mr-3 my-auto">
                                    <h6></h6>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item " href="#"><i
                                class="bx bx-log-out"></i>{{ __('admin.logout') }}</a>
                        <form id="logout-form" action="#" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->
