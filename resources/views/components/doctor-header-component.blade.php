<div>
    <div class="header-outer">
        <div class="header">
            <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fas fa-bars"
                    aria-hidden="true"></i></a>
            <a id="toggle_btn" class="float-left" href="javascript:void(0);">
                <i class="fas fa-th-large fa-3x component-icon"></i>
            </a>
            <ul class="nav user-menu float-right">
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle fixed-img" id="doctor-header"
                                src="{{ Auth::guard('doctors')->user()->image ? asset('storage/' . Auth::guard('doctors')->user()->image) : asset('img/profile/profile.png') }}"
                                width="30" height="30"
                                alt="{{ Auth::guard('doctors')->user()->name ?? 'Doctor' }}" class="fix-img">
                            <span class="status online"></span>
                        </span>
                        <span>{{ Auth::guard('doctors')->user()->name ?? 'Doctor' }}</span>
                    </a>

                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('doctor.profile') }}">My Profile</a>
                        <form action="{{ route('doctor.logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
            <!-- Mobile Menu -->
            <div class="dropdown mobile-user-menu float-right">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('doctor.profile') }}">My Profile</a>
                    <form action="{{ route('doctor.logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
