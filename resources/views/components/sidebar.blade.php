<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Internusa</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">I</a>
        </div>
        <ul class="sidebar-menu">


      
            <li class="menu-header">Management Users</li>
           
   <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('user.index') }}">User List</a>
                        </li>

                    </ul>
                </li>

                    <li class="menu-header">Absensi</li>
           
   <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Absensi kehadiran</span></a>
                        <ul class="dropdown-menu">
                            

                             <li>
                                <a class="nav-link" href="{{ route('absensi.formMasuk') }}">Absensi Datang</a>
                            </li>

                             <li>
                                <a class="nav-link" href="{{ route('absensi.formPulang') }}">Absensi Pulang</a>
                            </li>
                             <li>
                                <a class="nav-link" href="{{ route('ijin.create') }}">Ajukan Ijin</a>
                            </li>
                            <li>
                                <a class="nav-link" href="{{ route('absensi.index') }}">Riwayat Kehadiran</a>
                            </li>
                             <li>
                                <a class="nav-link" href="{{ route('ijin.index') }}">Riwayat Ijin</a>
                            </li>

                        </ul>
                </li>
    
                @hasanyrole('Admin|Owner')
                <li class="menu-header">Management Penggajian</li>
           
   <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Gaji</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('payroll.index') }}">Payroll</a>
                        </li>

                    </ul>
                </li>
              @endhasanyrole  
        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs"
                class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>
