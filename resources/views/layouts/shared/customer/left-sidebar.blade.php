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
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">SUMMARY</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->url('/dashboard') ? 'active' : null }}"
                        href="{{ url('/dashboard') }}">
                        <i class="ph-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @can('view-user-mgt-menu')

                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">User Management</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item">
                        {{-- <a class="nav-link {{ request()->routeIs('flex.performance-reports') ? 'active' : null }}" --}}
                        <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : null }}"
                            href="{{ route('user.index') }}">
                            <i class="ph-chart-bar"></i>User Registration </a>
                        {{-- <ul class="nav-group-sub collapse ">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.overtime') ? 'active' : null }}"
                                href="{{ route('flex.overtime') }}"> Overtimes </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                href="{{ route('attendance.leave') }}">Leave Applications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.linemanager.employees') ? 'active' : null }}"
                                href="{{ route('flex.linemanager.employees') }}">Assigned Employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.linemanager.taskmanagement') ? 'active' : null }}"
                                href="{{ route('flex.linemanager.taskmanagement') }}">Task Management</a>
                        </li>

                    </ul> --}}
                    </li>
                    @can('view-supervisor-registration-trend')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('supervisor_freelancers') ? 'active' : null }}"
                                href="{{ route('supervisor_freelancers') }}">
                                <i class="ph-layout"></i>
                                Supervisor Registration Overview </a>
                        </li>
                    @endcan
                @endcan
                <!-- users Management -->

                {{-- SUPERVISOR TO REGISTER THEIR FREELANCERS --}}
                @can('view-freelancer-mgt-menu')
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Freelancer Management</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item nav-item ">
                        {{-- <a class="nav-link {{ request()->routeIs('flex.performance-reports') ? 'active' : null }}" --}}
                        <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : null }}"
                            href="{{ route('freelancers.index') }}">
                            <i class="ph-chart-bar"></i>Freelancer Registration </a>
                        <ul class="nav-group-sub collapse ">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('supervisor_freelancers') ? 'active' : null }}"
                                    href="{{ route('supervisor_freelancers') }}"> Supervisors - Freelancers </a>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('flex.linemanager.taskmanagement') ? 'active' : null }}"
                                href="">Task Management</a>
                        </li> --}}

                        </ul>
                    </li>
                @endcan

                <!-- Clients Management -->
                @can('view-customer-mgt-menu')
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Customer Management</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>

                    {{-- This is for Freelencers to see registration --}}

                    {{-- This is for the Management to see registration --}}
                    @can('view-my-customer-registration')
                        <li class="nav-item nav-item-submenu">
                            <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : null }}"
                                href="{{ route('customer.index') }}">
                                <i class="ph-layout"></i>
                                <span>Customers</span>
                            </a>
                            <ul class="nav-group-sub collapse">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                        href="{{ route('customer.index') }}"><i
                                            class="ph ph-user"></i>Customers</a>
                                </li>
                                @can('view-public-sector-customer-registration')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                        href="{{ route('public.customer.index') }}"><i
                                            class="ph-users-three"></i>Public Sector</a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @can('view-all-customer-registration')
                        <li class="nav-item">

                            <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                href="{{ route('all_customers.index') }}"><i class="ph-layout"></i>All Customers</a>
                        </li>

                        @endcan
                        @can('view-all-public-sector-customer-registration')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                href="{{ route('public.customer.all_registration') }}"><i class="ph ph-user"></i>All Public Sector Customers</a>
                        </li>
                        @endcan
                @endcan


                <li class="nav-item-header">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Insurance Management</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>

                @can('view-insurance-application')
                    <li class="nav-item nav-item-submenu {{ request()->routeIs('flex.add_unpaid_leave') }}">
                        <a href="#" class="nav-link">
                            <i class="ph-calendar-check"></i>
                            <span> Insurance Applications</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.add_unpaid_leave') ||
                                request()->routeIs('attendance.leaveforfeiting') ||
                                request()->routeIs('attendance.revokeLeave') }}">
                            @if (session('mng_attend'))
                                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/flexperformance/flex/attendance/attendees') }}">Attendance</a></li> --}}
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                    href="{{ route('insurance-applications.index') }}"><i
                                        class="ph-note-pencil"></i>Insurance Applications</a>
                            </li>
                            @can('view-my-insurance-commission')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : null }}"
                                        href="{{ route('individual-commissions.index') }}">
                                        <i class="ph-layout"></i>
                                        <span>Insurance Commissions</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- Management Window for visualisation --}}
                @can('manage-insurance-application')
                    <li class="nav-item nav-item-submenu {{ request()->routeIs('flex.add_unpaid_leave') }}">
                        <a href="#" class="nav-link">
                            <i class="ph-calendar-check"></i>
                            <span> All Insurance Applications</span>
                        </a>

                        <ul
                            class="nav-group-sub collapse {{ request()->routeIs('flex.add_unpaid_leave') ||
                                request()->routeIs('attendance.leaveforfeiting') ||
                                request()->routeIs('attendance.revokeLeave') }}">
                            @if (session('mng_attend'))
                                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/flexperformance/flex/attendance/attendees') }}">Attendance</a></li> --}}
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('attendance.leave') ? 'active' : null }}"
                                    href="{{ route('education_insurance-requests') }}"><i
                                        class="ph-note-pencil"></i>Education</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : null }}"
                                    href="{{ route('bodaboda-insurances-requests') }}">
                                    <i class="ph-layout"></i>
                                    <span>BodaBoda</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('customers.index') ? 'active' : null }}"
                                    href="{{ route('business-insurances-requests') }}">
                                    <i class="ph-layout"></i>
                                    <span>Biashara</span>
                                </a>
                            </li>
                        </ul>


                    @endcan

                    @can('view-all-commissions')
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Commissions Management</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <a href="{{ route('all-commissions.index') }}" class="nav-link">
                        <i class="ph-calendar-check"></i>
                        <span> All Commissions</span>
                    </a>
                @endcan
                </li>

                <!-- Reports -->
                @can('view-reports')
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Reports</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="ph-layout"></i>
                            <span>All Reports</span>
                        </a>
                    </li>
                @endcan

                @can('view-setting')
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">Settings</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        {{-- <a class="nav-link {{ request()->routeIs('flex.performance-reports') ? 'active' : null }}" --}}
                        <a class="nav-link {{ request()->routeIs('department.index') ? 'active' : null }}"
                            href="{{ route('department.index') }}">
                            <i class="ph-chart-bar"></i>Settings</a>
                        <ul class="nav-group-sub collapse ">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('department.index') ? 'active' : null }}"
                                    href="{{ route('department.index') }}" href="">Department </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('department.index') ? 'active' : null }}"
                                    href="{{ route('all_positions_configured') }}" href="">Position </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('roles.index') ? 'active' : null }}"
                                    href="{{ url('roles') }}">
                                    <i class="ph-person-simple me-2"></i>Roles
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : null }}"
                                    href="{{ url('permissions') }}">
                                    <i class="ph-check-square-offset me-2"></i>Permission
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users-role.index') ? 'active' : null }}"
                                    href="{{ route('users-role.index') }}">
                                    <i class="ph-user-gear me-2"></i>{{ __('User') }} Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('ids.index') ? 'active' : null }}"
                                    href="{{ route('ids.index') }}">
                                    <i class="ph-user-gear me-2"></i>{{ __('ID') }} Types
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('insurance_types.index') ? 'active' : null }}"
                                    href="{{ route('insurance_types.index') }}">
                                    <i class="ph-check-square-offset me-2"></i>Insurance Types
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('commission.index') ? 'active' : null }}"
                                    href="{{ route('commission-configuration.index') }}">
                                    <i class="ph-check-square-offset me-2"></i>Commission Payment Configuration

                                </a>
                            </li>
                        </ul>

                    </li>
                @endcan




            </ul>
        </div>
        <!-- /main navigation -->

    </div>
</div>
