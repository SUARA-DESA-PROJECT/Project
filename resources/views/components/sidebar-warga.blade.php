<nav id="sidebar" class="active" style="background-color: #C4D6C4;">
    <div class="custom-menu" style="text-align: right; padding-right: 15px;">
        <button type="button" id="sidebarCollapse" class="btn" style="position: relative; right: -15px; background-color: #468B94; color: white; border: none;">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4">
        <h1><a href="#" class="logo" style="color: #333; font-weight: bold;">Suara Desa</a></h1>
        <ul class="list-unstyled components mb-5">
            <li class="mb-2">
                <a href="{{ route('homepage-warga') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-home mr-3"></span>Beranda
                </a>
            </li>
            <li class="mb-2">
                <a href="{{route ('laporan.create') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-file-text mr-3"></span>Input Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('riwayat-laporan.index') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-history mr-3"></span>Riwayat Laporan
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('peta.persebaran.warga') }}" style="background-color: #468B94; color: white; border-radius: 10px; padding: 10px 15px; display: block; box-shadow: 0 2px 5px rgba(0,0,0,0.2); transition: all 0.3s ease;">
                    <span class="fa fa-map-marker mr-3"></span>Peta Persebaran
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