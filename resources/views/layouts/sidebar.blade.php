
  <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset('admin/images/PentSpace.png') }}" srcset="{{ asset('admin/images/PentSpace.png') }} 2x" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset('admin/images/PentSpace.png') }}" srcset="{{ asset('admin/images/PentSpace.png') }} 2x" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                     <li class="nk-menu-heading">

                     </li>
                     <li class="nk-menu-item">
                         <a href="" class="nk-menu-link">
                             <span class="nk-menu-icon" style="color: white"><em class="icon ni ni-bag"></em></span>
                             <span class="nk-menu-text" style="color: white">Dashboard</span>
                         </a>
                     </li>

                       
                         <li class="nk-menu-item has-sub">
                             <a href="#" class="nk-menu-link nk-menu-toggle">
                                 <span class="nk-menu-icon" style="color: white"><em class="icon ni ni-task"></em></span>
                                 <span class="nk-menu-text" style="color: white">Users</span>
                             </a>
                             <ul class="nk-menu-sub">
                                 <li class="nk-menu-item">
                                     <a href="" class="nk-menu-link" style="color: white"><span
                                             class="nk-menu-text">App Users</span></a>
                                     <a href="" class="nk-menu-link" style="color: white"><span
                                             class="nk-menu-text">Admin Users</span></a>
                                 </li>

                             </ul>
                         </li>
                     
                    



                     @can('role-list')
                         <li class="nk-menu-item has-sub">
                             <a href="#" class="nk-menu-link nk-menu-toggle">
                                 <span class="nk-menu-icon" style="color: white"><em
                                         class="icon ni ni-share-alt"></em></span>
                                 <span class="nk-menu-text" style="color: white">Roles And Permissions</span>
                             </a>
                             <ul class="nk-menu-sub">
                                 <li class="nk-menu-item">
                                     <a href="{{ url('roles') }}" class="nk-menu-link" style="color: white"><span
                                             class="nk-menu-text">Roles</span></a>
                                 </li>
                                 <li class="nk-menu-item">
                                     <a href="{{ url('permissions') }}" class="nk-menu-link" style="color: white"><span
                                             class="nk-menu-text">Permissions</span></a>
                                 </li>

                             </ul><!-- .nk-menu-sub -->
                         </li><!-- .nk-menu-item -->
                     @endcan

                     

                    
                         {{-- <li class="nk-menu-item">
                             <a href="{{ url('services') }}" class="nk-menu-link">
                                 <span class="nk-menu-icon" style="color: white"><em
                                         class="icon ni ni-list-thumb-alt"></em></span>
                                 <span class="nk-menu-text" style="color: white">Services
                             </a>
                         </li> --}}
                    

                   
                         <li class="nk-menu-item">
                             <a href="{{ url('providers') }}" class="nk-menu-link">
                                 <span class="nk-menu-icon" style="color: white"><em class="icon ni ni-qr"></em></span>
                                 <span class="nk-menu-text" style="color: white">Providers
                             </a>
                         </li><!-- .nk-menu-item -->
                   


                   
                         <li class="nk-menu-item">
                             <a href="{{ url('downloads') }}" class="nk-menu-link">
                                 <span class="nk-menu-icon" style="color: white"><em
                                         class="icon ni ni-article"></em></span>
                                 <span class="nk-menu-text" style="color: white">Downloads
                             </a>
                         </li>
                    


                   
                         <li class="nk-menu-item">
                             <a href="{{ url('reports') }}" class="nk-menu-link">
                                 <span class="nk-menu-icon" style="color: white"><em
                                         class="icon ni ni-article"></em></span>
                                 <span class="nk-menu-text" style="color: white">Report 
                             </a>
                         </li>
                     

                     


                 </ul>
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->