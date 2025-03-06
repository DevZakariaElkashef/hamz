<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('usedMarket.admin') }}"><img
                src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('usedMarket.admin') }}"><img
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
                <a class="side-menu__item" href="{{ route('usedMarket.home') }}"><i class="fe fe-home ml-3"
                        style="font-size: 16px"></i><span class="side-menu__label">{{ __('main.resale_home') }}</span></a>
            </li>

            @if (auth()->user()->hasPermission('usedMarket.categories.index') ||
                    auth()->user()->hasPermission('usedMarket.subCategories.index') ||
                    auth()->user()->hasPermission('usedMarket.products.index') ||
                    auth()->user()->hasPermission('usedMarket.comments.index') ||
                    auth()->user()->hasPermission('usedMarket.complains.old') ||
                    auth()->user()->hasPermission('usedMarket.favourites.index') ||
                    auth()->user()->hasPermission('usedMarket.notifications.index'))
                <li class="side-item side-item-category">{{ __('admin.additional_data') }}</li>
            @endif


            @can('usedMarket.sliders.index')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('usedMarket.sliders.index') }}">
                        <i class="fe fe-grid ml-3" style="font-size: 16px"></i>
                        <span class="side-menu__label">{{ __('main.sliders') }}</span>
                    </a>
                </li>
            @endcan

            @can('usedMarket.categories.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاقسام</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('usedMarket.categories') }}">الاقسام</a>
                        </li>

                        <li><a class="slide-item" href="{{ route('usedMarket.addCategory') }}">اضافه قسم</a>
                        </li>


                    </ul>
                </li>
            @endcan

            @can('usedMarket.subCategories.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاقسام الفرعيه</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('usedMarket.subCategories') }}">الاقسام الفرعيه</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('usedMarket.addsubCategories') }}">اضافه قسم</a>
                        </li>

                    </ul>
                </li>
            @endcan

            @can('usedMarket.products.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الاعلانات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('usedMarket.products', 0) }}">الاعلانات الجديده</a></li>
                        <li><a class="slide-item" href="{{ route('usedMarket.products', 1) }}">الاعلانات المفبوله</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('usedMarket.products', 2) }}">الاعلانات المرفوضه</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('usedMarket.products', 4) }}">الاعلانات المحظوره</a>
                        </li>
                        <li><a class="slide-item" href="{{ route('usedMarket.products', 'D') }}">الاعلانات المحذوفه</a></li>

                    </ul>
                </li>
            @endcan

            @can('usedMarket.comments.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">التعليقات</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">

                        <li><a class="slide-item" href="{{ route('usedMarket.comments') }}">التعليقات</a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('usedMarket.complains.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">الشكاوي</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('usedMarket.complains') }}">الشكاوي الجديده</a></li>
                        <li><a class="slide-item" href="{{ route('usedMarket.complains.old') }}">الشكاوي القديمه</a></li>
                    </ul>
                </li>
            @endcan

            @can('usedMarket.favourites.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span class="side-menu__label">مفضلات الاعضاء</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item" href="{{ route('usedMarket.favourite') }}">مفضلات الاعضاء</a></li>
                    </ul>
                </li>
            @endcan

            @can('usedMarket.notifications.index')
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="javascript:void();"><i class="fe fe-grid ml-3"
                            style="font-size: 16px"></i><span
                            class="side-menu__label">{{ __('admin.notifications') }}</span><i
                            class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li><a class="slide-item"
                                href="{{ route('usedMarket.notifications') }}">{{ __('admin.notifications') }}</a></li>
                    </ul>
                </li>
            @endcan
            <li style="padding: 30px"></li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->
