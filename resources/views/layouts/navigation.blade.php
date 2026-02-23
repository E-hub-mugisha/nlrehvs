<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="d-inline-block align-top" style="height: 40px;" />
        </a>

        <!-- Hamburger for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(auth()->user()->role === 'admin')
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <!-- Employees -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}" href="{{ route('employees.index') }}">
                        Employees
                    </a>
                </li>

                <!-- Employers -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employers.*') ? 'active' : '' }}" href="{{ route('employers.index') }}">
                        Employers
                    </a>
                </li>

                <!-- Employment History -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employment-histories.*') ? 'active' : '' }}" href="{{ route('employment-histories.index') }}">
                        Employment History
                    </a>
                </li>

                <!-- Disputes (Admin only) -->

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.disputes.*') ? 'active' : '' }}" href="{{ route('admin.disputes.index') }}">
                        Disputes
                    </a>
                </li>

            </ul>
            @elseif(auth()->user()->role === 'employee')
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <!-- My Profile -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                        href="{{ route('profile.edit') }}">
                        My Profile
                    </a>
                </li>

                <!-- My Employment History -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.history') ? 'active' : '' }}"
                        href="{{ route('employee.history') }}">
                        My Employment History
                    </a>
                </li>

                <!-- My Disputes -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('employee.disputes.*') ? 'active' : '' }}"
                        href="{{ route('employee.disputes.index') }}">
                        My Disputes
                    </a>
                </li>

            </ul>
            @endif
            <!-- User Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>