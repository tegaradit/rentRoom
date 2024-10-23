<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Route::getCurrentRoute()->uri == 'admin' ? 'active' : 'collapsed' }}" href="/">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        {{-- <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/jurusan') ? 'active' : 'collapsed' }}"
                href="{{ route('jurusan.index') }}">
                <i class="bi-people"></i>
                <span>Guru</span>
            </a>
        </li><!-- End Guru Page Nav --> --}}

        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/ruangan') ? 'active' : 'collapsed' }}"
                href="{{ route('ruangan.index') }}">
                <i class="bi-file-earmark-text"></i>
                <span>Data Ruangan</span>
            </a>
        </li><!-- End Document jenis Page Nav -->

        
         <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/data_jurusan') ? 'active' : 'collapsed' }}"
                href="{{ route('data_jurusan.index') }}">
                <i class="bi-files"></i>    
                <span>Data Jurusan</span>
            </a>
        </li><!-- End Jenis Diklat Page Nav -->

        {{--<li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/golongan_guru') ? 'active' : 'collapsed' }}"
                href="{{ route('golongan_guru.index') }}">
                <i class="bi-view-stacked"></i>
                <span>Pangkat & Golongan</span>
            </a>
        </li><!-- End Pangkat Gol Page Nav -->


        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/kategori_kegiatan') ? 'active' : 'collapsed' }}"
                href="{{ route('kategori_kegiatan.index') }}">
                <i class="bi-tags"></i>
                <span>Kategori Kegiatan</span>
            </a>
        </li><!-- End Kategori Kegiatan Page Nav -->


        <li class="nav-item">
            <a class="nav-link  {{ str_contains(Route::getCurrentRoute()->uri, 'admin/manage_users') ? 'active' : 'collapsed' }}"
                href="{{ route('manage_users.index') }}">
                <i class="bi-person"></i>
                <span>Pengguna</span>
            </a>
        </li><!-- End Pengguna Page Nav --> --}}
    </ul>

</aside><!-- End Sidebar-->