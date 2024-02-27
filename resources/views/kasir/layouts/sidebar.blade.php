<div id="sidebar" class='active'>
    <div class="sidebar-wrapper active">

        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item">
                    <span class="sidebar-link" style="font-size: 2.2em; color: cornflowerblue;"><b>Toko Bersinar</b></span>
                </li>

                <li class='sidebar-title'>Main Menu</li>

                @if(auth()->user()->level == 'Admin')
                <li class="sidebar-item">
                    <a href="/admin/dashboard" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>

                </li>

                <li class='sidebar-title'>Master Menu</li>

                <li class="sidebar-item">
                    <a href="/admin/kategori" class="sidebar-link">
                        <i data-feather="list" width="20"></i>
                        <span>Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="/admin/ukuran" class="sidebar-link">
                        <i data-feather="crop" width="20"></i>
                        <span>Ukuran</span>
                    </a>

                </li>

                <li class="sidebar-item">
                    <a href="/admin/produk" class="sidebar-link">
                        <i data-feather="file-text" width="20"></i>
                        <span>Produk</span>
                    </a>

                </li>

                <li class="sidebar-item">
                    <a href="/admin/transaksi" class="sidebar-link">
                        <i data-feather="book" width="20"></i>
                        <span>Laporan</span>
                    </a>

                </li>

                <li class='sidebar-title'>User Menu</li>

                <li class="sidebar-item">
                    <a href="/admin/user" class="sidebar-link">
                        <i data-feather="users" width="20"></i>
                        <span>User</span>
                    </a>

                </li>

                <li class="sidebar-item">
                    <a href="/admin/info" class="sidebar-link">
                        <i data-feather="info" width="20"></i>
                        <span>Info</span>
                    </a>

                </li>

                @elseif(auth()->user()->level == 'Kasir')
                <li class="sidebar-item">
                    <a href="/kasir/dashboard" class="sidebar-link">
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>

                </li>

                <li class='sidebar-title'>Master Menu</li>

                <li class="sidebar-item">
                    <a href="/kasir/transaksi" class="sidebar-link">
                        <i data-feather="dollar-sign" width="20"></i>
                        <span>Transaksi</span>
                    </a>

                </li>

                <li class='sidebar-title'>User Menu</li>

                <li class="sidebar-item">
                    <a href="/kasir/info" class="sidebar-link">
                        <i data-feather="info" width="20"></i>
                        <span>Info</span>
                    </a>

                </li>

                </li>
                @endif
            </ul>
        </div>
    </div>
</div>