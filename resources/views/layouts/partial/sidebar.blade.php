<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">CORE</div>
        
            <a class="nav-link" href="{{ url('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            {{-- Customer --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseCustomer" aria-expanded="false" aria-controls="collapseCustomer">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-person"></i></div>
                Customer
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseCustomer" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('tablecustomer') }}">Manage Customer</a>
                    <a class="nav-link" href="{{ url('customer') }}">Add Customer</a>
                </nav>
            </div>

            {{-- Material --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMaterials" aria-expanded="false" aria-controls="collapseMaterials">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-wrench"></i></div>
                Materials
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMaterials" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('tablematerial') }}">Manage Materials</a>
                    <a class="nav-link" href="{{ url('addmaterial') }}">Add Material</a>
                </nav>
            </div>
            
            {{-- Quotation --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseQuotation" aria-expanded="false" aria-controls="collapseQuotation">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                Quotation
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseQuotation" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ url('tablequotation') }}">Manage Quotation</a>
                    <a class="nav-link" href="{{ route('showQuotation') }}">add Quotation</a>
                </nav>
            </div>

            {{-- Invoice --}}
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseInvoice" aria-expanded="false" aria-controls="collapseInvoice">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                Invoice
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseInvoice" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('tableinvoicesView') }}">Manage Invoice</a>
                    <a class="nav-link" href="{{ route('showInvoices') }}">add Invoice</a>
                </nav>
            </div>

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