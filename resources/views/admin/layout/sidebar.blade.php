<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('assets/backend/images/laravel.png')}}" alt="Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"
              style="font-size: 11px;font-weight: bold">پنل مدیریت تسک فرکیو</span>
    </a>

    <div class="sidebar">
        <div>

            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{auth()->user()->profile}}"
                         class="img-circle elevation-2" alt="Profile">
                </div>
                <div class="info">
                    <a href="javascript:void(0)" class="d-block">{{auth()->user()->getFullNameAttribute()}}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <li class="nav-item">
                        <a target="_blank" href="{{ route('home') }}"
                           class="nav-link">
                            <i class="nav-icon fa fa-home"></i>
                            <p>
                                خانه
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-dashboard"></i>
                            <p>
                                داشبورد
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['users.index',
'users.create',
'users.edit']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['users.index',
'users.create',
'users.edit']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                کاربران
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                   class="nav-link {{ request()->routeIs(['users.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت کاربران</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users.create') }}"
                                   class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد کاربران</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ request()->routeIs(['lotteries.index',
'lotteries.create',
'lotteries.show']) ? 'menu-open' : '' }}">

                        <a href="#"
                           class="nav-link {{ request()->routeIs(['lotteries.index',
'lotteries.create',
'lotteries.result']) ? 'active' : '' }}">
                            <i class="nav-icon fa fa-database"></i>
                            <p>
                                قرعه کشی ها
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('lotteries.index') }}"
                                   class="nav-link {{ request()->routeIs(['lotteries.index']) ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>مدیریت قرعه کشی ها</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('lotteries.create') }}"
                                   class="nav-link {{ request()->routeIs('lotteries.create') ? 'active' : '' }}">
                                    <i class="fa fa-circle-o nav-icon"></i>
                                    <p>ایجاد قرعه کشی ها</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">

                        <a href="{{route('logout')}}"
                           class="nav-link">
                            <i class="nav-icon fa fa-close"></i>
                            <p>
                                خروج
                                <i class="fa right"></i>
                            </p>
                        </a>

                    </li>

                </ul>
            </nav>

        </div>
    </div>

</aside>
