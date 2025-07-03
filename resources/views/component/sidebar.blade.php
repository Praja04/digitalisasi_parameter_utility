<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        @if(Session::get('jabatan') === 'dept_head' || Session::get('jabatan') === 'supervisor' )
        <a href="{{ url('menu') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="100">
            </span>
        </a>
        @else
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="100">
            </span>
        </a>
        @endif
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                @if(Session::get('jabatan') === 'dept_head' )
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="mdi mdi-tools"></i> <span data-key="t-dashboards">Dashboard Eng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('eng/dept_head/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Boiler</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('eng/supervisor/dashboard/utility') }}" class="nav-link" data-key="t-analytics">Analytics Utility</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('eng/dept_head/todo') }}" class="nav-link" data-key="t-analytics"> Todo List ENG </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsQC" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsQC">
                        <i class="mdi mdi-check-circle"></i> <span data-key="t-dashboards">Dashboard QC</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsQC">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('qc/dept_head/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsPRD" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsPRD">
                        <i class="mdi mdi-package-variant"></i> <span data-key="t-dashboards">Dashboard PRD</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsPRD">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('prd/dept_head/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('prd/dept_head/menu_retail') }}" class="nav-link" data-key="t-analytics"> Analytics Retail</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsWarehouse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsWarehouse">
                        <i class="mdi mdi-home-group-plus"></i> <span data-key="t-dashboards">Dashboard Warehouse</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsWarehouse">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('wh/dept_head/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics P2H </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Lainnya</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMesin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMesin">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-authentication">Data Mesin</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMesin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarBoiler" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBoiler">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-apps">Boiler</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarBoiler">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('boiler/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('boiler/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarDailytank" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDailytank">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Daily Tank</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarDailytank">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('daily-tank/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('daily-tank/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarDissolver" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDissolver">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Dissolver</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarDissolver">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('dissolver/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('dissolver/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarGlucose" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGlucose">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Glucose</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarGlucose">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('glucose/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('glucose/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarOlahsari" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOlahsari">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Olah Sari</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarOlahsari">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('olahsari/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('olahsari/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarPasteur1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPasteur1">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Pasteurisasi 1</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPasteur1">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi1/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi1/realtime-pasteurizer') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarPasteur2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPasteur2">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Pasteurisasi 2</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPasteur2">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi2/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi2/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarStk400" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarStk400">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">STK 400</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarStk400">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('stk400/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('stk400/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarSt53" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSt53">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">ST53</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSt53">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('st53/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('st53/realtime-tankA') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('dept_head/manajemen_user') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Manage User</span>
                    </a>
                </li>
                <!-- supervisor -->
                @elseif(Session::get('jabatan') === 'supervisor' && Session::get('departemen') === 'engineering')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="mdi mdi-tools"></i> <span data-key="t-dashboards">Dashboard Eng</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('eng/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Boiler</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('eng/supervisor/dashboard/utility') }}" class="nav-link" data-key="t-analytics">Analytics Utility</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('eng/dept_head/todo') }}" class="nav-link" data-key="t-analytics"> Todo List ENG </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsUtility" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsUtility">
                        <i class="mdi mdi-tools"></i> <span data-key="t-dashboards">Data Utility </span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsUtility">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('eng/supervisor/data/utility') }}" class="nav-link" data-key="t-analytics"> Data Utility</a>
                            </li>


                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMesin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMesin">
                        <i class="mdi mdi-view-grid-plus-outline"></i> <span data-key="t-authentication">Data Mesin</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMesin">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarBoiler" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBoiler">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-apps">Boiler</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarBoiler">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('boiler/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('boiler/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarDailytank" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDailytank">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Daily Tank</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarDailytank">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('daily-tank/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('daily-tank/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarDissolver" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDissolver">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Dissolver</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarDissolver">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('dissolver/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('dissolver/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarGlucose" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarGlucose">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Glucose</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarGlucose">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('glucose/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('glucose/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarOlahsari" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarOlahsari">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Olah Sari</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarOlahsari">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('olahsari/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('olahsari/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarPasteur1" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPasteur1">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Pasteurisasi 1</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPasteur1">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi1/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi1/realtime-pasteurizer') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarPasteur2" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPasteur2">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">Pasteurisasi 2</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarPasteur2">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi2/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('pasteurisasi2/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarStk400" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarStk400">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">STK 400</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarStk400">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('stk400/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('stk400/realtime') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link" href="#sidebarSt53" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSt53">
                                    <i class="mdi mdi-speedometer"></i>
                                    <span data-key="t-dashboards">ST53</span>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSt53">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ url('st53/datatren') }}" class="nav-link" data-key="t-analytics">
                                                Analytics Data Trend
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('st53/realtime-tankA') }}" class="nav-link" data-key="t-crm">
                                                Dashboard Realtime
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>

                @elseif(Session::get('jabatan') === 'supervisor' && Session::get('departemen') === 'qc')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsQC" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsQC">
                        <i class="mdi mdi-check-circle"></i> <span data-key="t-dashboards">Dashboard QC</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsQC">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('qc/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsPRD" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsPRD">
                        <i class="mdi mdi-package-variant"></i> <span data-key="t-dashboards">Dashboard PRD</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsPRD">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('prd/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>

                        </ul>
                    </div>
                </li>
                @elseif(Session::get('jabatan') === 'supervisor' && Session::get('departemen') === 'produksi')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsPrd" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsPrd">
                        <i class="mdi mdi-check-circle"></i> <span data-key="t-dashboards">Dashboard PRD</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsPrd">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('qc/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardsPRD" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardsPRD">
                        <i class="mdi mdi-package-variant"></i> <span data-key="t-dashboards">Dashboard PRD</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardsPRD">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('prd/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics Pasteurisasi 1</a>
                            </li>

                        </ul>
                    </div>
                </li>
                @elseif(Session::get('jabatan') === 'supervisor' && Session::get('departemen') === 'warehouse')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboardswarehouse" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboardswarehouse">
                        <i class="mdi mdi-check-circle"></i> <span data-key="t-dashboards">Dashboard Warehouse</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboardswarehouse">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('wh/supervisor/dashboard') }}" class="nav-link" data-key="t-analytics"> Analytics P2H</a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/supervisor/detail/p2h') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Data P2H</span>
                    </a>
                </li>
                <!-- end supervisor -->

                <!-- foreman -->
                @elseif(Session::get('jabatan') === 'foreman' && Session::get('departemen') === 'qc')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('qc/foreman/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form input AfterCooling</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('qc/operator/list') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">List Data AfterCooling</span>
                    </a>
                </li>
                @elseif(Session::get('jabatan') === 'foreman' && Session::get('departemen') === 'engineering')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('eng/foreman/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Dashboard Utility</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('eng/foreman/form') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form Utility</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('eng/foreman/data/utility') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Data Utility</span>
                    </a>
                </li>

                @elseif(Session::get('jabatan') === 'foreman' && Session::get('departemen') === 'produksi')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/foreman/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form input Batch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/operator/history') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">List History Batch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/operator/status_running') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Status Running Produksi</span>
                    </a>
                </li>
                @elseif(Session::get('jabatan') === 'foreman' && Session::get('departemen') === 'warehouse')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/foreman/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Foreman Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/foreman/form/p2h') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form P2H</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/foreman/detail/p2h') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Data P2H</span>
                    </a>
                </li>
                <!-- end foreman -->

                <!-- operator -->
                @elseif(Session::get('jabatan') === 'operator' && Session::get('departemen') === 'produksi')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/operator/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form input Batch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/operator/history') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">List History Batch</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('prd/operator/status_running') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Status Running Produksi</span>
                    </a>
                </li>

                @elseif(Session::get('jabatan') === 'operator' && Session::get('departemen') === 'qc')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('qc/operator/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form input AfterCooling</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('qc/operator/list') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">List Data AfterCooling</span>
                    </a>
                </li>
                @elseif(Session::get('jabatan') === 'operator' && Session::get('departemen') === 'engineering')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('eng/operator/form') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form Utility</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('eng/operator/data/utility') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Data Utility</span>
                    </a>
                </li>

                @elseif(Session::get('jabatan') === 'operator' && Session::get('departemen') === 'warehouse')
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/operator/dashboard') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Form P2H</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ url('wh/operator/detail/p2h') }}">
                        <i class="mdi mdi-card-account-details"></i> <span data-key="t-widgets">Data P2H</span>
                    </a>
                </li>
                @endif
                <!-- end operator -->
            </ul>
        </div>
        <!-- Sidebar -->
    </div>


    <div class="sidebar-background"></div>
</div>