<div class="sidebar sidebar-white sidebar-main sidebar-expand-lg">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <div class="sidebar-section">
            <!-- Customers -->
            <div class="sidebar-section sidebar-resize-hide mx-2 d-flex justify-content">
                <a href="#" class="btn btn-link text-body text-start lh-1  p-2 my-1 w-100" data-bs-toggle="dropdown"
                    data-color-theme="white">
                    <div class="hstack gap-2 flex-grow-1 my-1">
                        {{-- <img src="../../../assets/images/brands/shell.svg" class="w-32px h-32px" alt=""> --}}
                        <img src="{{ asset('img/zoe-somalogo.jpeg') }}" alt="" width="60" height="60">
                        <div class="me-auto">
                            <div class="fw-semibold">Zoe-Soma Consultancy</div>
                        </div>
                    </div>
                </a>
                {{-- <h5 class="sidebar-resize-hide flex-grow-1 my-auto  text-muted"></h5> --}}
                <div class="btn">
                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                        class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- /customers -->

        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Summary -->
                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">MAIN MENU</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->url('/dashboard') ? 'active' : null }}"
                        {{-- href="{{ url('/dashboard') }}"> --}}
                        href="{{route('customer.dashboard')}}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('my-products*') ? 'active' : '' }}"
                       href="#">
                        <i class="ph-briefcase"></i>
                        <span>My Products</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('payments*') ? 'active' : '' }}" href="{{route('customer.payments.index')}}">
                        <i class="ph-credit-card"></i>
                        <span>Payment History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('beneficiaries*') ? 'active' : '' }}"
                        href="#">
                        <i class="ph-users"></i>
                        <span>My Beneficiaries</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('insurance-info*') ? 'active' : '' }}"
                        href="#">
                        <i class="ph-shield-check"></i>
                        <span>Insurance Info</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('support*') ? 'active' : '' }}" href="#">
                        <i class="ph-lifebuoy"></i>
                        <span>Support</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="#">
                        <i class="ph-info"></i>
                        <span>About ZoeSoma</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- /main navigation -->

    </div>
</div>
