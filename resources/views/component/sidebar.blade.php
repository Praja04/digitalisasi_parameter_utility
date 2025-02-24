<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Light Logo-->
        <a href="{{ url('menu') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/icon-utility/kecap.png') }}" alt="" height="100">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>
    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarBoiler" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBoiler">
                        <i class="mdi mdi-view-grid-plus-outline"></i>
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
                    <a class="nav-link menu-link" href="#sidebarDailytank" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarDailytank">
                        <i class="mdi mdi-speedometer"></i>
                        <span data-key="t-dashboards">Daily Tank</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDailytank">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url('dailytank/datatren') }}" class="nav-link" data-key="t-analytics">
                                    Analytics Data Trend
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('dailytank/realtime') }}" class="nav-link" data-key="t-crm">
                                    Dashboard Realtime
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDissolver" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarDissolver">
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
                    <a class="nav-link menu-link" href="#sidebarGlucose" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarGlucose">
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
                    <a class="nav-link menu-link" href="#sidebarOlahsari" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarOlahsari">
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

                <!-- end Dashboard Menu -->

                <!-- <li class="menu-title">
                    <i class="ri-more-fill"></i>
                    <span data-key="t-pages">Management</span>
                </li> -->

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPasteur1" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarPasteur1">
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
                                <a href="{{ url('pasteurisasi1/realtime') }}" class="nav-link" data-key="t-crm">
                                    Dashboard Realtime
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPasteur2" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarPasteur2">
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
                    <a class="nav-link menu-link" href="#sidebarStk400" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarStk400">
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
                    <a class="nav-link menu-link" href="#sidebarSt53" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarSt53">
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
                                <a href="{{ url('st53/realtime') }}" class="nav-link" data-key="t-crm">
                                    Dashboard Realtime
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>


    <div class="sidebar-background"></div>
</div>