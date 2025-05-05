<nav id="sidebar" class="active" style="background-color: #C4D6C4;">
    <div class="custom-menu" style="text-align: right; padding-right: 15px;">
        <button type="button" id="sidebarCollapse" class="btn" style="position: relative; right: -15px; background-color: #468B94; color: white; border: none; 
            width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0;">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="#" class="logo" style="color: #333; font-weight: bold;">Suara Desa</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="mb-2">
                <a href="{{ route('homepage') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-home mr-3"></span>Beranda
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route ('laporan.create-pengurus') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-file-text mr-3"></span>Input Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="#" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-check-square-o mr-3"></span>Verifikasi Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('respon.index') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-reply mr-3"></span>Respon Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('kategori.index') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-tags mr-3"></span>Tambah Kategori
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('warga.verifikasi') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-user-plus mr-3"></span>Verifikasi Akun
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('dashboard.index') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-dashboard mr-3"></span>Dashboard
                </a>
            </li>
        </ul>

        <div class="footer">
            <p style="color: #333;">
               &copy; Suara Desa Project
            </p>
        </div>
    </div>
</nav>

<style>
    #sidebar .components a:hover {
        background-color: #3a7279 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
    }
    
    #sidebar {
        transition: all 0.3s ease;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
</style>
