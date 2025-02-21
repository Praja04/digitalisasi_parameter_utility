 <div class="app-menu navbar-menu" id="navbar-menu2">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="{{ route('dashboard.crm') }}" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('material/assets/images/logo-sm.png') }}" alt="" height="22" />
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('material/assets/images/logo-dark.png') }}" alt="" height="17" />
             </span>
         </a>
         <!-- Light Logo-->
         <a href="index.html" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('material/assets/images/logo-sm.png')}}" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('material/assets/images/logo-light.png')}}" alt="" height="17">
             </span>
         </a>
     </div>

     <div id="scrollbar">
         <div class="container-fluid">
             <div id="two-column-menu"></div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="menu-title">
                     <span data-key="t-menu">Menu</span>
                 </li>

                 <!-- end Dashboard Menu -->
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                         <i class="mdi mdi-view-grid-plus-outline"></i>
                         <span data-key="t-apps">Dashboard CRM</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarApps">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('dashboard.crm') }}" class="nav-link" data-key="t-dashboard">
                                     Dashboard CRM
                                 </a>
                             </li>


                         </ul>
                     </div>
                 </li>

                 <!-- end Dashboard Menu -->

                 <li class="menu-title">
                     <i class="ri-more-fill"></i>
                     <span data-key="t-pages">Management</span>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                         <i class="mdi mdi-account-circle-outline"></i>
                         <span data-key="t-authentication">Management CRM</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarAuth">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('users.index') }}" class="nav-link" data-key="t-users">
                                     Management user
                                 </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('customers') }}" class="nav-link" data-key="t-customers">
                                     Management customer
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