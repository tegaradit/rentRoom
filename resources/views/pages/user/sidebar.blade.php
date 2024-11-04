<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'user/pinjam-ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('peminjaman.index') }}">
                <i class="bi-calendar4-range"></i>
                <span>Dashboard</span>
            </a>
        </li>


</aside>
