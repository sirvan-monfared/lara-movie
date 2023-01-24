<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-start" href="{{ route('front') }}">
        <div class="sidebar-brand-icon">
            <img src="/front/img/logo-icon.png" alt="">
        </div>
        <div class="sidebar-brand-text mx-3"><img src="/front/img/logo.png" alt="logo"></div>
    </a>

    <li @class(['nav-item', 'active' => request()->routeIs('front')])>
        <a class="nav-link" href="{{ route('front') }}">
            <i class="fas fa-fw fa-home"></i><span>Home</span>
        </a>
    </li>
    <li @class(['nav-item', 'active' => request()->routeIs('movies')])>
        <a class="nav-link" href="{{ route('movies') }}">
            <i class="fas fa-fw fa-film"></i><span>Movies</span>
        </a>
    </li>
    <li @class(['nav-item', 'active' => request()->routeIs('people')])>
        <a class="nav-link" href="{{ route('people') }}">
            <i class="fas fa-fw fa-film"></i><span>Celebrities</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- <div class="sidebar-heading">Extra</div> --}}

    {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-pager"></i>
            <span>Pages</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">All Pages</h6>
                <a class="collapse-item" href="movies.html">Movies</a>
                <a class="collapse-item" href="movies-detail.html">Movie Detail</a>
                <a class="collapse-item" href="events.html">Events</a>
                <a class="collapse-item" href="events-detail.html">Event Detail</a>
                <a class="collapse-item" href="people.html">People</a>
                <a class="collapse-item" href="people-detail.html">People Detail</a>
                <a class="collapse-item" href="sports.html">Sports</a>
                <a class="collapse-item" href="sports-detail.html">Sport Detail</a>
            </div>
        </div>
    </li> --}}
</ul>