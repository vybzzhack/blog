<!-- need to remove -->
<li class="nav-item">
    <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('home') }}" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('posts.index') }}" class="nav-link {{ Request::is('posts.index') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pencil-alt"></i>
        <p>Posts</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('posts.myPosts') }}" class="nav-link">
        <i class="nav-icon fas fa-user"></i>
        <p>My Posts</p>
    </a>
</li>

@if (Auth::user() && Auth::user()->isAdmin())
<li class="nav-item">
    <a href="{{ route('admin.pending_posts') }}" class="nav-link {{ Request::is('admin/pending-posts') ? 'active' : '' }}">
        <i class="nav-icon fas fa-clock"></i> <!-- Using a clock icon for "pending" -->
        <p>Pending Posts</p>
    </a>
</li>
@endif

@if (Auth::user() && Auth::user()->isAdmin())
<li class="nav-item">
    <a href="{{ route('admin.users.index') }}" class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Users</p>
    </a>
</li>
@endif

@if (auth()->check() && auth()->user()->isAdmin())
<li class="nav-item">
    <a href="{{ route('admin.analytics') }}" class="nav-link {{ Request::is('admin/analytics') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Analytics</p>
    </a>
</li>
@endif