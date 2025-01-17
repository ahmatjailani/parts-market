<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('assets-admin/images/logo.png') }}" alt="STP OTOMOTIF" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                <li class="{{ Route::is('products.*') ? 'active' : '' }}">
                    <a href="{{ route('products.index') }}">
                        <i class="fa fa-list"></i>Products</a>
                </li>
                <li class="{{ Route::is('categorys.*') ? 'active' : '' }}">
                    <a href="{{ route('categorys.index') }}">
                        <i class="fas fa-server"></i>Category Product</a>
                </li>
                <li class="{{ Route::is('services.*') ? 'active' : '' }}">
                    <a href="{{ route('services.index') }}">
                        <i class="fa fa-wrench"></i>Services</a>
                </li>
                <li class="{{ Route::is('categoryservices.*') ? 'active' : '' }}">
                    <a href="{{ route('categoryservices.index') }}">
                        <i class="fa fa-pencil-alt"></i>Category Services</a>
                </li>
                <li class="{{ Route::is('carcatalog.*') ? 'active' : '' }}">
                    <a href="{{ route('carcatalog.index') }}">
                        <i class="fa fa-car"></i>Vehicle</a>
                </li>
                <li class="{{ Route::is('sales.*') ? 'active' : '' }}">
                    <a href="{{ route('sales.index') }}">
                        <i class="fa fa-usd"></i>Sales</a>
                </li>
                <li class="{{ Route::is('team.*') ? 'active' : '' }}">
                    <a href="{{ route('team.index') }}">
                        <i class="fa fa-users"></i>Team</a>
                </li>
                <li class="{{ Route::is('news.*') ? 'active' : '' }}">
                    <a href="{{ route('news.index') }}">
                        <i class="fa fa-newspaper"></i>News</a>
                </li>
                <li class="{{ Route::is('testimoni.*') ? 'active' : '' }}">
                    <a href="{{ route('testimoni.index') }}">
                        <i class="fa fa-comments"></i>Testimony</a>
                </li>
                <li class="{{ Route::is('message.*') ? 'active' : '' }}">
                    <a href="{{ route('message.index') }}">
                        <i class="fa fa-comment"></i>Message</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
