@php
    $settings = App\Models\Setting::findOrFail(1);
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link d-flex justify-content-center p-0" style="text-decoration: none">
        @if (isset($settings))
            <img src="{{ $settings->logo ? \Storage::url($settings->logo) : '' }}" alt="Vemto Logo"
                class="brand-image object-fit-contain img-fluid"
                style="max-height: 56px; line-height:0%; margin-left:0%;margin-right:0%;margin-top:0%">
        @endif
        {{-- <span class="brand-text font-weight-light">Event Photo Sharing</span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu">

                @auth
                    @role('super-admin')
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon icon ion-md-pulse"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endrole

                    @role('super-admin')
                    <li class="nav-item">
                        <a href="{{ route('order.index') }}" class="nav-link">
                            <i class="nav-icon icon ion-md-radio-button-off"></i>
                            <p>Orders</p>
                        </a>
                    </li>
                    @endrole

                    @role('user')
                        @can('view gallery', App\Models\Photo::class)
                            <li class="nav-item">
                                <a href="{{ route('gallery') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Gallery</p>
                                </a>
                            </li>
                        @endcan
                    @else
                        @can('view-any', App\Models\User::class)
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                        @endcan
                        @can('view-any', App\Models\Event::class)
                            <li class="nav-item">
                                <a href="{{ route('events.index') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Events</p>
                                </a>
                            </li>
                        @endcan
                        @can('view-any', App\Models\Photo::class)
                            <li class="nav-item">
                                <a href="{{ route('photos.index') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Photos</p>
                                </a>
                            </li>
                        @endcan
                        @can('view gallery', App\Models\Photo::class)
                            <li class="nav-item">
                                <a href="{{ route('gallery') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Gallery</p>
                                </a>
                            </li>
                        @endcan
                        @can('view-any', App\Models\Invitation::class)
                            <li class="nav-item">
                                <a href="{{ route('invitations.index') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Invitations</p>
                                </a>
                            </li>
                        @endcan
                        @can('view-any', App\Models\Comment::class)
                            <li class="nav-item">
                                <a href="{{ route('comments.index') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Comments</p>
                                </a>
                            </li>
                        @endcan

                        @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                                Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))
                            <li class="nav-item have-children">
                                <a href="javascript:void(0);" class="nav-link">
                                    <i class="nav-icon icon ion-md-key"></i>
                                    <p>
                                        Access Management
                                        <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @can('view-any', Spatie\Permission\Models\Role::class)
                                        <li class="nav-item">
                                            <a href="{{ route('roles.index') }}" class="nav-link">
                                                <i class="nav-icon icon ion-md-radio-button-off"></i>
                                                <p>Roles</p>
                                            </a>
                                        </li>
                                    @endcan

                                    @can('view-any', Spatie\Permission\Models\Permission::class)
                                        <li class="nav-item">
                                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                                <i class="nav-icon icon ion-md-radio-button-off"></i>
                                                <p>Permissions</p>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif
                    @endrole

                    @role('organizer')
                    <li class="nav-item">
                        <a href="{{ route('contact') }}" class="nav-link">
                            <i class="nav-icon icon ion-md-radio-button-off"></i>
                            <p>Contact</p>
                        </a>
                    </li>
                    @endrole

                    <li class="nav-item have-children">
                        <a href="javascript:void(0);" class="nav-link">
                            <i class="nav-icon ion-md-settings"></i>
                            <p>
                                Settings
                                <i class="nav-icon right icon ion-md-arrow-round-back"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('profile') }}" class="nav-link">
                                    <i class="nav-icon icon ion-md-radio-button-off"></i>
                                    <p>Profile</p>
                                </a>
                            </li>


                            @role('super-admin')
                                <li class="nav-item">
                                    <a href="{{ route('smtp.setting') }}" class="nav-link">
                                        <i class="nav-icon icon ion-md-radio-button-off"></i>
                                        <p>SMTP</p>
                                    </a>
                                </li>
                            @endrole

                            @role('super-admin')
                                <li class="nav-item">
                                    <a href="{{ route('print-option.index') }}" class="nav-link">
                                        <i class="nav-icon icon ion-md-radio-button-off"></i>
                                        <p>Print Options</p>
                                    </a>
                                </li>
                            @endrole

                            @role('super-admin')
                                <li class="nav-item">
                                    <a href="{{ route('shipping.index') }}" class="nav-link">
                                        <i class="nav-icon icon ion-md-radio-button-off"></i>
                                        <p>Shipping</p>
                                    </a>
                                </li>
                            @endrole

                        </ul>
                    </li>
                @endauth

                {{-- <li class="nav-item">
                    <a href="https://adminlte.io/docs/3.1//index.html" target="_blank" class="nav-link">
                        <i class="nav-icon icon ion-md-help-circle-outline"></i>
                        <p>Docs</p>
                    </a>
                </li> --}}

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="nav-icon icon ion-md-exit"></i>
                            <p>{{ __('Logout') }}</p>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

{{-- <script>
    jQuery(function(){
        jQuery('.nav-item a').click(function(e)){
            console.log(jQuery(this).attr('href'));
        }
    })
</script> --}}