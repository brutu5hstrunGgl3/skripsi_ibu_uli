<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">RM Kapau Nasi Padang</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">RM Kapau</a>
        </div>
        <ul class="sidebar-menu">


      @hasanyrole('Admin|Owner') 
            <li class="menu-header">Management Users</li>
           
   <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Users</span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('user.index') }}">User List</a>
                        </li>

                    </ul>
                </li>
                @endhasanyrole

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
                <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Permintaan Cuti</span></a>
                        <ul class="dropdown-menu">
                            

                             <li>
                                <a class="nav-link" href="{{ route('cuti.create') }}">Pendaftaran Cuti</a>
                            </li>

                             <li>
                                <a class="nav-link" href="{{ route('cuti.index') }}">Histori Cuti</a>
                            </li>
                                 @hasanyrole('Admin|Owner')
                             <li>
                                <a class="nav-link" href="{{ route('cuti.index') }}">Daftar cuti karyawan</a>
                            </li> @endhasanyrole

                            

                        </ul>
                </li>
    
                <li class="menu-header">Management Penggajian</li>
           
   <li class="nav-item dropdown ">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Gaji</span></a>
                    <ul class="dropdown-menu">
                        <li>
                        <a class="nav-link" href="{{ route('payroll.index') }}">Slip Gaji</a>
                        </li>

                    </ul>
                </li>
       
    </aside>
</div>
