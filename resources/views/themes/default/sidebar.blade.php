<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="avatar" class="img-circle" src="{{ URL($user_info['avatar'])}}" width="64" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $user_info['name']}}</strong>
                             </span> <span class="text-muted text-xs block">
                             @if($user_info['level'] == 3)
                                Presiden Direktur
                             @elseif($user_info['level'] == 2)
                                Produser
                             @else
                                Idol
                             @endif
                             <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a data-toggle="modal" data-target="#belumada">Profil</a></li>
                                <li><a data-toggle="modal" data-target="#belumada">Pesan</a></li>
                                <li><a data-toggle="modal" data-target="#belumada">Pengaturan</a></li>
                                <li class="divider"></li>
                                <li><a href="{{ URL('logout')}}">Keluar</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="active">
                        <a href="{{ URL('/')}}" title="Dasbor"><i class="fa fa-th-large"></i> <span class="nav-label">Dasbor</span></a>
                    </li>
                    <li>
                        <a data-toggle="modal" data-target="#belumada" title="Rilisan"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Rilisan</span></a>
                    </li>
                    <li>
                        <a data-toggle="modal" data-target="#belumada" title="Proyek"><i class="fa fa-area-chart"></i> <span class="nav-label">Proyek</span></a>
                    </li>
                    <li>
                        <a href="#" title="Kategori"><i class="fa fa-bars"></i> <span class="nav-label">Kategori</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a data-toggle="modal" data-target="#belumada" title="Judul Kartun">Judul Kartun</a></li>
                            <li><a data-toggle="modal" data-target="#belumada" title="Musim Tayang">Musim Tayang</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#" title="Setoran"><i class="fa fa-book"></i> <span class="nav-label">Setoran</span><span class="fa arrow"></span></a></a>
                        <ul class="nav nav-second-level">
                            <li><a href="{{ URL('setoran/edit')}}" title="Siap Edit">Siap Edit</a></li>
                            <li><a href="{{ URL('setoran/qc')}}" title="Siap QC">Siap QC</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ URL('laporan')}}" title="Laporan QC"><i class="fa fa-desktop"></i> <span class="nav-label">Laporan QC</span></a>
                    </li>
                    <li>
                        <a href="#" title="Pengaturan"><i class="fa fa-gear"></i> <span class="nav-label">Pengaturan</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a data-toggle="modal" data-target="#belumada">Notifikasi</a></li>
                            <li><a data-toggle="modal" data-target="#belumada">Ubah Profil</a></li>
                            <li><a data-toggle="modal" data-target="#belumada">Ganti STNK</a></li>
                            <li><a data-toggle="modal" data-target="#belumada">Keluar</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>