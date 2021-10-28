<ul id="js-nav-menu" class="nav-menu">
    <li class="{{ Nav::isRoute('dashboard', 'active') }}">
        <a href="{{ route('dashboard') }}" title="Dashboard" data-filter-tags="dashboard">
                <i class="fal fa-cube"></i>
                <span class="nav-link-text" data-i18n="nav.dashboard">Dashboard</span>
        </a>
    </li>
    @if(Auth::user()->jenis_user == "admin")
        <li class="nav-title">Menu Admin</li>
        <li class="{{ Nav::isRoute('pegawai', 'active') }}">
            <a href="{{ url('/pegawai') }}" title="Pegawai" data-filter-tags="pegawai">
                <i class="fal fa-users"></i>
                <span class="nav-link-text" data-i18n="nav.pegawai">Pegawai & Kondektur</span>
            </a>
        </li>
        <li class="{{ Nav::isResource('setting', NULL, 'active') }}">
            <a href="{{ route('setting.index') }}" title="Setting" data-filter-tags="setting">
                <i class="fal fa-cog"></i>
                <span class="nav-link-text" data-i18n="nav.setting">Setting</span>
            </a>
        </li>
        <li class="{{ Nav::isRoute('jadwal', 'active') }}">
            <a href="{{ url('/jadwal') }}" title="Jadwal Dinas" data-filter-tags="Jadwal Dinas">
                <i class="fal fa-calendar"></i>
                <span class="nav-link-text" data-i18n="nav.jadwal">Data Jadwal</span>
            </a>
        </li>
    @endif
    <li class="nav-title">Fitur Utama</li>
    <li class="{{ Nav::isRoute('cari-jadwal', 'active') }}">
        <a href="{{ url('/cari-jadwal') }}" title="Kelas" data-filter-tags="cari-jadwal">
            <i class="fal fa-calendar"></i>
            <span class="nav-link-text" data-i18n="nav.cari-jadwal">Cari Jadwal</span>
        </a>
    </li>
    <li class="{{ Nav::isRoute('jadwal.tukar-jadwal', 'active') }}">
        <a href="{{ url('/jadwal/tukar-jadwal') }}" title="Kelas" data-filter-tags="jadwal.tukar-jadwal">
            <i class="fal fa-book"></i>
            <span class="nav-link-text" data-i18n="nav.jadwal.tukar-jadwal">Tukar Jadwal</span>
        </a>
    </li>
</ul>
