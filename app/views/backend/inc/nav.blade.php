<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
          {{ User::avatar(Sentry::getUser()->avatar, '100x100_crop', 100) }}
        </div>
        <div class="pull-left info">
            <p>Hi, {{ Sentry::getUser()->first_name }}</p>

            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
            <span class="input-group-btn">
                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="treeview active">
            <a href="/admin">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="{{ URL::to('admin') }}" class="{{ (Request::is('admin') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Bảng theo dõi</a></a>
                </li>
                @if ( Sentry::getUser()->hasAnyAccess(['news','news.sort']) )
                <li>
                    <a href="{{ URL::to('admin/news/sorts') }}" class="{{ (Request::is('admin/news/sorts') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Sắp xếp bài viết</a></a>
                </li>
                @endif
            </ul>
        </li>
        <li class="treeview {{ ((Request::is('admin/news') || Request::is('admin/news/create') || Request::is('admin/news/*/edit') || Request::is('admin/categories*') || Request::is('admin/tags*') || Request::is('admin/comments*')) ? ' active' : '') }}">
            <a href="#">
                <span class="glyphicon glyphicon-pencil"></span>
                <span>Tác nghiệp</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if ( Sentry::getUser()->hasAnyAccess(['news','news.create']) )
                  <li><a href="javascript:void(0)" data-toggle="modal" data-target="#modal_newpost"><i class="fa fa-angle-double-right"></i> Đăng bài mới</a></li>
                @endif
                <li>
                <a href="{{ URL::to('admin/news') }}" class="{{ (Request::is('admin/news') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Danh sách bài</a></a></li>
                @if ( Sentry::getUser()->hasAnyAccess(['news','news.createcategory']) )
                <li><a href="{{ URL::to('admin/categories') }}" class="{{ (Request::is('admin/categories*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Chuyên mục</a></li>
                @endif
                @if ( Sentry::getUser()->hasAnyAccess(['news','news.edittopic']) )
                <li><a href="{{ URL::to('admin/tags?type=topic') }}" class="{{ (Request::is('admin/tags*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Luồng sự kiện</a></li>
                @endif
                <li><a href="{{ URL::to('admin/tags?type=tag') }}" class="{{ (Request::is('admin/tags?type=tag') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Chủ đề</a></li>
                @if ( Sentry::getUser()->hasAnyAccess(['news','news.viewcomment']) )
                <li><a href="{{ URL::to('admin/comments') }}" class="{{ (Request::is('admin/comments*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Bình luận</a></li>
                @endif
            </ul>
        </li>
        <li class="treeview">
            <a class="media-modal" data-url="{{ URL::to('medias/my?env=list') }}">
                <span class="glyphicon glyphicon-cloud-upload"></span>
                <span>Thư viện</span>
            </a>
        </li>
        @if ( Sentry::getUser()->hasAnyAccess(['pages','pages.full']) )
        <li class="treeview {{ (Request::is('admin/pages*') ? ' active' : '') }}">
            <a href="#">
                <i class="glyphicon glyphicon-book"></i> <span>Trang thông tin</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if ( Sentry::getUser()->hasAnyAccess(['pages','pages.create']) )
                  <li><a href="{{ route('create/page') }}" class="{{ (Request::is('admin/pages/create') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Tạo mới</a></li>
                @endif
                <li><a href="{{ URL::to('admin/pages') }}" class="{{ (Request::is('admin/pages') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Danh sách trang</a></a></li>
            </ul>
        </li>
        @endif
        @if ( Sentry::getUser()->hasAnyAccess(['pages','user.full']) )
        <li class="treeview {{ (Request::is('admin/users*') || Request::is('admin/groups*') || Request::is('admin/newsletters*') ? ' active' : '') }}">
            <a href="#">
                <i class="glyphicon glyphicon-user"></i> <span>Người dùng</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ URL::to('admin/newsletters') }}" class="{{ (Request::is('admin/newsletters*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Newsletters</a></li>
              <li><a href="{{ URL::to('admin/users') }}" class="{{ (Request::is('admin/users*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Người dùng</a></li>
              <li><a href="{{ URL::to('admin/groups') }}" class="{{ (Request::is('admin/groups*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i> Nhóm người dùng</a></li>
            </ul>
        </li>
        @endif
        @if ( Sentry::getUser()->hasAnyAccess(['statistic','statistic.news']) || Sentry::getUser()->hasAnyAccess(['statistic','statistic.royalty']) )
        <li class="treeview {{ (Request::is('admin/royalties*') || Request::is('admin/news/statistics*') ? ' active' : '') }}">
            <a href="#">
                <i class="fa fa-bar-chart-o"></i> <span>Thống kê</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                @if ( Sentry::getUser()->hasAnyAccess(['statistic','statistic.news']))
                    <li><a href="{{ URL::to('admin/news/statistics') }}" class="{{ (Request::is('admin/news/statistics*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Bài viết</a></li>
                @endif
                @if ( Sentry::getUser()->hasAnyAccess(['statistic','statistic.royalty']))
                    <li><a href="{{ URL::to('admin/royalties') }}" class="{{ (Request::is('admin/royalties*') ? ' active' : '') }}"><i class="fa fa-angle-double-right"></i>  Nhuận bút</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ( Permission::has_access('settings', 'config'))
        <li class="treeview {{ (Request::is('admin/settings*') ? ' active' : '') }}">
            <a href="#">
                <i class="glyphicon glyphicon-cog"></i> <span>Thiết lập</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{ URL::to('admin/settings') }}"><i class="fa fa-angle-double-right"></i> Thông tin chung</a></li>
                <li><a href="{{ URL::to('admin/settings?v=news#tab-news') }}"><i class="fa fa-angle-double-right"></i> Bài viết</a></li>
                <li><a href="{{ URL::to('admin/settings?v=comments#tab-comments') }}"><i class="fa fa-angle-double-right"></i> Bình luận</a></li>
                <li><a href="{{ URL::to('admin/settings?v=analytics#tab-analytics') }}"><i class="fa fa-angle-double-right"></i> Analytics</a></li>
            </ul>
        </li>
        @endif
        <!-- <li>
            <a href="pages/calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="badge pull-right bg-red">3</small>
            </a>
        </li>
        <li>
            <a href="pages/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="badge pull-right bg-yellow">12</small>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
            </ul>
        </li> -->
    </ul>
</section>
<!-- /.sidebar -->