<nav class="sb-sidenav accordion sb-sidenav-dark" id="siden">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>

            {{-- Dashboard --}}
            <a class="nav-link" href="{{ route('customer.dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>
            
            {{-- Quotation --}}
            <a class="nav-link" href="{{ route('customer.quotations') }}">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-file-invoice-dollar"></i></i></div>
                Quotation
            </a>

            {{-- Invoices --}}
            <a class="nav-link" href="#">
                <div class="sb-nav-link-icon"><i class="fa-solid fa-dollar-sign"></i></div>
                Invoice
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="big">{{ Auth::user()->name }}</div>
    </div>
</nav>