<div class="main-sidebar" >
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="/">Corporate Platform</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm"  >
        <a href="/">CPF</a>
      </div>
      <ul class="sidebar-menu">
          <li class="menu-header" style="font-weight: bold; color: black">Dashboard</li>
          <li class="nav-item dropdown">
            <a href="/" class="nav-link "><i class="iconify" data-icon="bx:bxs-dashboard" style="font-size: 20px;font-weight: bold; color: black" ></i><span style="padding: 10px;font-weight: bold; color: black"> Dashboard </span></a>
          </li>

        <!-- Authentication Links -->
        @guest
        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
        @else

          <li class="nav-item dropdown">
            @can('task-list')
            <a href="{{ route('tasks.index') }}"  class="nav-link " ><i  class="iconify" data-icon="eos-icons:project" style="font-size: 25px;font-weight: bold; color: black"></i>
            </i><span style="padding: 10px;font-weight: bold; color: black">Project</span></a>
            @endcan
            </li>

            @if(auth()->user()->can('user-list') || auth()->user()->can('role-list'))
            <li class="nav-item dropdown">
            <a  class="nav-link has-dropdown "><i class="fas fa-users" style="font-size: 20px;font-weight: bold; color: black"></i><span style="padding: 1px;font-weight: bold; color: black">Manage User</span></a>
            <ul class="dropdown-menu">

                @can('user-list')
                <li><a href="{{ route('users.index') }}" class="nav-link "><i class="iconify" data-icon="bx:bxs-user-circle" style="font-size: 25px;font-weight: bold; color: black" ></i> <span style="padding: 10px;font-weight: bold; color: black"> Users</span></a></li>
                @endcan
                @can('role-list')
                <li> <a href="{{ route('roles.index') }}" class="nav-link "style="font-weight: bold; color: black"><i class='eos-icons' >role_binding</i>Roles</a></li>
                @endcan
            </li>
            @endif
            @endguest
                <li class="nav-item dropdown">
            <a href="/profile" class="nav-link "><i class="iconify" data-icon="ant-design:setting-filled" style="font-size: 20px;font-weight: bold; color: black" ></i><span style="padding: 10px;font-weight: bold; color: black"> Setting</span></a>
            </li>
        </ul>
    </ul>

    </aside>
  </div>
