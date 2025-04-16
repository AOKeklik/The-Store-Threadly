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
            <li class="{{ Request::routeIs('admin.category.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.category.view") }}"><i class="fas fa-folder"></i> <span>Category</span></a>
            </li>
            <li class="{{ Request::routeIs('admin.attribute.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.attribute.view") }}"><i class="fas fa-sliders-h"></i> <span>Attribute</span></a>
            </li>
            <li class="{{ Request::routeIs('admin.coupon.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.coupon.view") }}"><i class="fas fa-ticket-alt"></i> <span>Coupon</span></a>
            </li>
            <li class="nav-item dropdown {{ Request::routeIs('admin.product.*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i><span>Product</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::routeIs('admin.product.view') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.product.view") }}"><i class="fas fa-angle-right"></i> Product</a>
                    </li>
                    <li class="{{ Request::routeIs('admin.product.add.view') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route("admin.product.add.view") }}"><i class="fas fa-angle-right"></i> Add</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::routeIs('admin.blog.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route("admin.blog.view") }}"><i class="fas fa-pen"></i> <span>Blog</span></a>
            </li>
        </ul>
    </aside>
</div>