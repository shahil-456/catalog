<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{'/'}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('material/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('material/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{'/'}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('material/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('material/images/logo-light.png') }}" alt="" height="70">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.category.*', 'admin.brand.*', 'admin.brand.category.*') ? 'active' : '' }}"
                        href="#sidebarCatalogs" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('admin.category.*', 'admin.brand.*', 'admin.brand.category.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarCatalogs">
                        <i class="ri-apps-2-line"></i> <span>Catalogs</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.category.*', 'admin.brand.*', 'admin.brand.category.*') ? 'show' : '' }}"
                        id="sidebarCatalogs">
                        <ul class="nav nav-sm flex-column">
                        @can('list Categories')
                            <li class="nav-item">
                                <a href="{{ route('admin.category.list') }}"
                                    class="nav-link {{ request()->routeIs('admin.category.list') ? 'active' : '' }}">
                                    Categories
                                </a>
                            </li>
                             @endcan
                        @can('list brands')
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.list') }}"
                                    class="nav-link {{ request()->routeIs('admin.brand.list') ? 'active' : '' }}">
                                    Brands
                                </a>
                            </li>
                             @endcan
                            @can('list brand categories')
                            <li class="nav-item">
                                <a href="{{ route('admin.brand.category.list') }}"
                                    class="nav-link {{ request()->routeIs('admin.brand.category.list') ? 'active' : '' }}">
                                    Brand Categories
                                </a>
                            </li>
                             @endcan
                
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.blog.*', 'admin.blog.category.*', 'admin.cms.*') ? 'active' : '' }}"
                        href="#sidebarCMS" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('admin.blog.*', 'admin.blog.category.*', 'admin.cms.*') ? 'true' : 'false' }}"
                        aria-controls="sidebarCMS">
                        <i class="ri-honour-line"></i> <span>CMS</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.blog.*', 'admin.blog.category.*', 'admin.cms.*') ? 'show' : '' }}"
                        id="sidebarCMS">
                        <ul class="nav nav-sm flex-column">
                        @can('list blogs')
                            <li class="nav-item">
                                <a href="{{ route('admin.blog.list') }}"
                                    class="nav-link {{ request()->routeIs('admin.blog.list') ? 'active' : '' }}">
                                    Blog Posts
                                </a>
                            </li>
                         @endcan
                        @can('list blog categories')    
                            <li class="nav-item">
                                <a href="{{ route('admin.blog.category.list') }}"
                                    class="nav-link {{ request()->routeIs('admin.blog.category.list') ? 'active' : '' }}">
                                    Blog Categories
                                </a>
                            </li>
                             @endcan
                            @can('list home page cms')
                            <li class="nav-item">
                                <a href="{{ route('admin.cms.home') }}"
                                    class="nav-link {{ request()->routeIs('admin.cms.home') ? 'active' : '' }}">
                                    Home Page CMS
                                </a>
                            </li>
                             @endcan
                            @can('list service page cms')
                            <li class="nav-item">
                                <a href="{{ route('admin.cms.services') }}"
                                    class="nav-link {{ request()->routeIs('admin.cms.services') ? 'active' : '' }}">
                                    Service Page CMS
                                </a>
                            </li>
                             @endcan
                            @can('list blog page cms')
                            <li class="nav-item">
                                <a href="{{ route('admin.cms.blogs') }}"
                                    class="nav-link {{ request()->routeIs('admin.cms.blogs') ? 'active' : '' }}">
                                    Blog Page CMS
                                </a>
                            </li>
                             @endcan
                            @can('list faq page cms')
                            <li class="nav-item">
                                <a href="{{ route('admin.cms.faqs') }}"
                                    class="nav-link {{ request()->routeIs('admin.cms.faqs') ? 'active' : '' }}">
                                    FAQ Page CMS
                                </a>
                            </li>
                             @endcan
                        </ul>
                    </div>
                </li>
                @can('list customers')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}"
                        href="{{ route('admin.customers') }}">
                        <i class="ri-user-line"></i> <span>Customers</span> </a>
                </li>
                @endcan

                @can('list enquiries')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.enquiry.list') ? 'active' : '' }}"
                        href="{{ route('admin.enquiry.list') }}">
                        <i class="ri-message-line"></i> <span>Enquiries</span> </a>
                </li>
                @endcan

                @can('list contact enquiries')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.contact-enquiry.list') ? 'active' : '' }}"
                        href="{{ route('admin.contact-enquiry.list') }}">
                        <i class="ri-message-line"></i> <span>Contact Enquiries</span> </a>
                </li>
                @endcan                

                @canany(['list users', 'list permissions', 'list roles'])
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.users*', 'admin.roles*', 'admin.permissions*') ? 'active' : '' }}"
                        href="#sidebarUsers" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('admin.users*', 'admin.roles*', 'admin.permissions*') ? 'true' : 'false' }}"
                        aria-controls="sidebarUsers">
                        <i class="mdi mdi-account-multiple"></i> <span>Users</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.users*', 'admin.roles*', 'admin.permissions*') ? 'show' : '' }}"
                        id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            @can('list users')
                            <li class="nav-item">
                                <a href="{{ route('admin.users') }}"
                                    class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                                    Users
                                </a>
                            </li>
                            @endcan
                            @can('list permissions')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions') }}"
                                    class="nav-link {{ request()->routeIs('admin.permissions') ? 'active' : '' }}">
                                    Permissions
                                </a>
                            </li>
                            @endcan
                            @can('list roles')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles') }}"
                                    class="nav-link {{ request()->routeIs('admin.roles') ? 'active' : '' }}">
                                    Roles
                                </a>
                            </li>
                            @endcan
                           
                        </ul>
                    </div>
                </li>
                 @can('view report')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.enquiry.reports') ? 'active' : '' }}"
                        href="{{ route('admin.enquiry.reports') }}">
                        <i class="ri-bar-chart-line"></i> <span>Reports</span>
                    </a>
                </li>
                @endcan
                @endcanany
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
