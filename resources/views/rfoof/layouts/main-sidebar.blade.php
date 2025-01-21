<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('rfoof.admin') }}"><img
                src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('rfoof.admin') }}"><img
                src="{{ URL::asset('assets/img/brand/logo.png') }}" class="logo-icon" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround" src="{{ asset('uploads/default.png') }}"><span
                        class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0"></h4>
                </div>
            </div>
        </div>

        <ul class="side-menu">
            <li class="side-item side-item-category">{{ __('admin.main') }}</li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('home') }}"><i class="fe fe-home ml-3"
                        style="font-size: 16px"></i><span class="side-menu__label">{{ __('admin.main') }}</span></a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('rfoof.admin') }}"><i class="fe fe-home ml-3"
                        style="font-size: 16px"></i><span class="side-menu__label">{{ __('main.rfoof_home') }}</span></a>
            </li>

            @if (auth()->user()->hasPermission('rfoof.categories.index') ||
                    auth()->user()->hasPermission('rfoof.subCategories.index') ||
                    auth()->user()->hasPermission('rfoof.products.index') ||
                    auth()->user()->hasPermission('rfoof.comments.index') ||
                    auth()->user()->hasPermission('rfoof.complains.index') ||
                    auth()->user()->hasPermission('rfoof.favourites.index') ||
                    auth()->user()->hasPermission('rfoof.notifications.index'))
                <li class="side-item side-item-category">{{ __('admin.additional_data') }}</li>
            @endif


            @can('rfoof.sliders.index')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('rfoof.sliders.index') }}">
                        <i class="fe fe-grid ml-3" style="font-size: 16px"></i>
                        <span class="side-menu__label">{{ __('main.sliders') }}</span>
                    </a>
                </li>
            @endcan

            @can('rfoof.categories.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاقسام</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('rfoof.categories') }}">الاقسام</a>
                        </li>

                        <li><a class="slide-item" href="{{ route('rfoof.addCategory') }}">اضافه قسم</a>
                        </li>


                    </ul>
                </li>
            @endcan

            @can('rfoof.subCategories.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاقسام الفرعيه</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('rfoof.subCategories') }}">الاقسام الفرعيه</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('rfoof.addsubCategories') }}">اضافه قسم</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('rfoof.products.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاعلانات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('rfoof.products', 0) }}">الاعلانات الجديده</a></li>
                        <li><a class="slide-item" href="{{ route('rfoof.products', 1) }}">الاعلانات المفبوله</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('rfoof.products', 2) }}">الاعلانات المرفوضه</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('rfoof.products', 3) }}">الاعلانات المميزه</a></li>
                        <li><a class="slide-item" href="{{ route('rfoof.products', 4) }}">الاعلانات المحظوره</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('rfoof.comments.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">التعليقات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('rfoof.comments') }}">التعليقات</a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('rfoof.complains.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الشكاوي</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('rfoof.complains', 0) }}">الشكاوي الجديده</a></li>
                        <li><a class="slide-item" href="{{ route('rfoof.complains', 1) }}">الشكاوي القديمه</a></li>
                    </ul>
                </li>
            @endcan

            @can('rfoof.favourites.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">مفضلات الاعضاء</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('rfoof.favourite') }}">مفضلات الاعضاء</a></li>
                    </ul>
                </li>
            @endcan

            @can('rfoof.notifications.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span
                            class="side-menu__label">{{ __('admin.notifications') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item"
                                href="{{ route('rfoof.notifications') }}">{{ __('admin.notifications') }}</a></li>
                    </ul>
                </li>
            @endcan

        </ul>
    </div>
</aside>
<!-- main-sidebar -->
