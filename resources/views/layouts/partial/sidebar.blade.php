<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">CORE</div>
        
            {{-- Dashboard --}}
            <a class="nav-link" href="{{ url('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            {{-- Customer --}}
            <a class="nav-link " href="{{ url('tablecustomer') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-users me-1"></i></div>
                Customer
            </a>

            {{-- Material --}}
            <a class="nav-link collapsed" href="{{ url('tablematerial') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-wrench"></i></div>
                Materials
            </a>

            
            {{-- Quotation --}}
            <a class="nav-link collapsed" href="{{ url('tablequotation') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                Quotation
            </a>

            {{-- Invoice --}}
            <a class="nav-link collapsed" href="{{ route('tableinvoicesView') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                Invoice
            </a>

            {{-- Sales Report --}}
            <a class="nav-link" href="{{ url('salesreport') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-file"></i></div>
                Sales Report
                {{-- <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div> --}}
            </a>
            {{-- <div class="collapse" id="collapseReport" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('tablequotation') }}">Manage Invoice</a>
                </nav>
            </div> --}}
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="big">{{ Auth::user()->name }}</div>
    </div>
</nav>