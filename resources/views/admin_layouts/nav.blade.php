<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('assets/images/logo.jpg')}}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">Swat Collegiate School</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-first-page'></i>
                </div>
            </div>
            <!--navigation-->
                <!-- Sidebar Menu -->
    {!! Menu::render('admin-sidebar-menu', 'adminltecustom'); !!}
    <!-- /.sidebar-menu -->
            {{-- <ul class="metismenu" id="menu">

            <li class="menu-label">MAIN MENU</li>

             <li>
                    <a href="{{ url('widgets') }}">
                        <div class="parent-icon"><i class='bx bx-home'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
             <li>
                    <a href="{{ url('campuses') }}">
                        <div class="parent-icon"><i class='bx bx-buildings'></i>
                        </div>
                        <div class="menu-title">Campuses</div>
                    </a>
                </li>
             <li>
                    <a href="{{ url('widgets') }}">
                        <div class="parent-icon"><i class='bx bx-globe'></i>
                        </div>
                        <div class="menu-title">Global Congigurtions</div>
                    </a>
                </li>
                <li class="menu-label">SUPPORT</li>
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-bar-chart-square'></i>
                        </div>
                        <div class="menu-title">Quick Analysis</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('index') }}"><i class="lni lni-eye"></i>Registration Report</a>
                        </li>
                        
                    </ul>
                </li>
                 <li>
                    <a href="{{ url('widgets') }}">
                        <div class="parent-icon"><i class='lni lni-envelope'></i>
                        </div>
                        <div class="menu-title">Feedback</div>
                    </a>
                </li>  
            </ul> --}}
            <!--end navigation-->
        </div>