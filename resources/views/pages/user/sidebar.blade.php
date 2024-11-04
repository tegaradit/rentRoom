<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::getCurrentRoute()->uri == 'user' ? 'active' : 'collapsed' }}" href="{{ route('user.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'user/pinjam-ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('pinjam-ruangan.index') }}">
                <i class="bi-calendar4-range"></i>
                <span>Jadwal</span>
            </a>
        </li>

        <li class="nav-link"
            style="color: rgb(169, 169, 169); margin-top: 20px; margin-bottom: 20px; padding-left: 20px; position: relative;"
            data-key="t-components">
            <span
                style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 1px; width: 17px; background-color: rgb(169, 169, 169);"></span>
            PEMINJAMAN
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'user/pinjam-ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('pinjam-ruangan.index') }}">
                <i class="bi-calendar4-range"></i>
                <span>Pinjam Ruangan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'user/peminjaman_saya') ? 'active' : 'collapsed' }}"
                href="{{ route('peminjaman_saya.index') }}">
                <i class="bi-journal-bookmark"></i>
                <span>Peminjaman Saya</span>
            </a>
        </li>

    </ul>

</aside>
