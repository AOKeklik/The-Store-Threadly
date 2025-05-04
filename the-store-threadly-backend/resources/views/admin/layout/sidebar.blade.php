<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="{{ Request::routeIs('admin.view') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.view") }}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ Request::routeIs('admin.setting.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.setting.view") }}"><i class="fa fa-cog"></i> <span>Setting</span></a>
            </li>
            <li class="{{ Request::routeIs('admin.category.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.category.view") }}"><i class="fas fa-folder"></i> <span>Category</span></a>
            </li>
            <li class="{{ Request::routeIs('admin.subscriber.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.subscriber.view") }}">
                    <i class="fas fa-envelope"></i>
                    <div class="d-flex align-items-center" style="gap:1rem">
                        <span>Subscriber</span>
                        <span class="badge badge-danger w-4" data-app-section="subscriber-unread">
                            @include("admin.subscriber.unread")
                        </span>
                    </div>
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.contact.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.contact.view") }}">
                    <i class="fas fa-envelope"></i> 
                    <div class="d-flex align-items-center" style="gap:1rem">
                        <span>Contact</span>
                        <span class="badge badge-danger w-4" data-app-section="contact-unread">
                            @include("admin.contact.unread")
                        </span>
                    </div>
                </a>
            </li>
            <li class="{{ Request::routeIs('admin.page.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.page.view") }}"><i class="fas fa-file-alt"></i> <span>Page</span></a>
            </li>
            <li class="nav-item dropdown {{ Request::routeIs('admin.slider.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-images"></i><span>Slider</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.slider.hero.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.slider.hero.view") }}"><i class="fas fa-angle-right"></i> <span>Hero</span></a>
                    </li>
                    <li class="{{ Request::routeIs('admin.slider.brand.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.slider.brand.view") }}"><i class="fas fa-angle-right"></i> <span>Brand</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::routeIs('admin.blog.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.blog.view") }}"><i class="fas fa-pen"></i> <span>Blog</span></a>
            </li>
            <li class="nav-item dropdown {{ 
                Request::routeIs('admin.delivery.*') ||
                Request::routeIs('admin.attribute.*') ||
                Request::routeIs('admin.coupon.*') || 
                Request::routeIs('admin.wishlist.*') ||
                Request::routeIs('admin.product.*')
                ? 'active' : '' 
            }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i><span>ECommerce</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.delivery.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.delivery.view") }}"><i class="fas fa-angle-right"></i> <span>Delivery</span></a>
                    </li>
                    <li class="{{ Request::routeIs('admin.attribute.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.attribute.view") }}"><i class="fas fa-angle-right"></i> <span>Attribute</span></a>
                    </li>
                    <li class="{{ Request::routeIs('admin.coupon.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.coupon.view") }}"><i class="fas fa-angle-right"></i> <span>Coupon</span></a>
                    </li>
                    <li class="{{ Request::routeIs('admin.wishlist.*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.wishlist.view") }}"><i class="fas fa-angle-right"></i> <span>Wishlist</span></a>
                    </li>
                    <li class="{{ Request::routeIs('admin.product.view') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.product.view") }}"><i class="fas fa-angle-right"></i> Product</a>
                    </li>
                    <li class="{{ Request::routeIs('admin.product.add.view') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.product.add.view") }}"><i class="fas fa-angle-right"></i> Add Product</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>