<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="/admin" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <img src="/assets/img/bbcms-logo.png" width="100%" />
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                @if(Sentry::getUser()->hasAccess('deletecache'))
                <li class="dropdown">
                	<a href="javascript:void(0)" class="btn btn-link" data-toggle="dropdown" id="cacheBtn"><i class="fa fa-refresh"></i> Xóa cache</a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li><a href="javascript:void(0)" onclick="updateCache('home')" class="btn btn-link">Trang chủ</a></li>
                        <li><a href="javascript:void(0)" onclick="updateCache('other')" class="btn btn-link">Các trang khác</a></li>
                        <li><a href="javascript:void(0)" onclick="updateCache('other')" class="btn btn-link">Toàn bộ</a></li>
                    </ul>
                </li>
                @endif
                <li class="hidden-xs"><a target="_blank" href="{{ URL::to('/') }}" class="btn btn-link"><span class="glyphicon glyphicon-share-alt"></span> Xem trang chủ</a></li>
                <li class="dropdown messages-menu" id="notisAct">
                    <a href="#" class="dropdown-toggle btn btn-link" data-toggle="dropdown" onclick="GetNotifications();" data-open="0">
                        <i class="ion-flag"></i>
                        @if(Sentry::getUser()->notifications)
                            <span class="label label-success">{{ Sentry::getUser()->notifications }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu" id="notifications">
                        <li><div align="center"><img src="/assets/img/loader.gif" border="0" /></div></li>
                    </ul>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle btn btn-link" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>Chào, <strong>{{ Sentry::getUser()->first_name }}</strong> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            {{ User::avatar(Sentry::getUser()->avatar, '100x100_crop', 100) }}
                            <p>
                                {{ Sentry::getUser()->fullName() }}
                                <!-- <small>Member since Nov. 2012</small> -->
                            </p>
                            <div style="overflow: hidden" style="padding: 20px 0;">
                                <span class="pull-left">
                                    <a href="{{ URL::to('account') }}" target="_blank" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Hồ sơ</a>
                                </span>
                                <span class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Thoát</a>
                                </span>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>