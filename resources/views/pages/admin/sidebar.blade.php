<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::getCurrentRoute()->uri == 'admin' ? 'active' : 'collapsed' }}" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-link"
            style="color: rgb(169, 169, 169); margin-top: 20px; margin-bottom: 20px; padding-left: 20px; position: relative;"
            data-key="t-components">
            <span
                style="position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 1px; width: 17px; background-color: rgb(169, 169, 169);"></span>
            DATA MASTER
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="{{ route('data_jurusan.index') }}">
                <i class="bi-files"></i>
                <span>Data Jurusan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('ruangan.index') }}">
                <i class="bi-file-earmark-text"></i>
                <span>Data Ruangan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="#">
                <i class="bi-files"></i>
                <span>Data Pengguna</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="#">
                <i class="bi-files"></i>
                <span>Data Peminjaman</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="#">
                <i class="bi-files"></i>
                <span>Laporan</span>
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
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/pinjam-ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('pinjam-ruangan.index') }}">
                <i class="bi-files"></i>
                <span>Pinjam Ruangan</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="#">
                <i class="bi-files"></i>
                <span>Peminjaman Saya</span>
            </a>
        </li>

    </ul>

</aside><!-- End Sidebar-->
