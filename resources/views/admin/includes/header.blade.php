<header class="container-fluid mb-4">
    <nav class="navbar">
        <div class="navbar-holder d-flex align-items-center justify-content-between">

          <a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars"> </i></a>

          <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">

            <li class="nav-item">
                <a class="dropdown-header-name" style="padding-right: 10px" href="{{route('cartpro.home')}}" target="_blank"><i class="dripicons-preview"></i> <span>View Website</span> </a>
            </li>

            <li class="nav-item">
                <a href="{{route('admin.order.index')}}">
                    <i class="dripicons-cart"></i>
                    <span class="badge badge-defaultr bg-danger" style="width:25px"><span class="text-light">  @if($orders) {{$orders->where('order_status','pending')->count()}} @else 0 @endif </span></span>
                </a>
            </li>

            <li class="nav-item"><a id="btnFullscreen"><i class="dripicons-expand"></i></a></li>

            @php


                 $languages = DB::table('languages')
                            ->select('id','language_name','local')
                            // ->where('default','=',0)
                            ->where('local','!=',Session::get('currentLocal'))
                            ->orderBy('language_name','ASC')
                            ->get();
            @endphp

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="dripicons-web">
                        @if (Session::has('currentLocal'))
                            {{ __(strtoupper(Session::get('currentLocal'))) }}
                        @endif
                    </i>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @foreach ($languages as $item)
                      <a class="dropdown-item" href="{{route('admin.setting.language.defaultChange',$item->id)}}">
                            {{ $item->language_name }} ({{__(strtoupper($item->local))}})
                      </a>
                    @endforeach
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/documentation')}}" target="_blank" data-toggle="tooltip"
                   title="{{__('Help')}}">
                    <i class="dripicons-information"></i>
                </a>
            </li>

            <li class="nav-item">
            <a rel="nofollow" href="#" data-target="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item">
                @if(auth()->user()->image && Illuminate\Support\Facades\File::exists(public_path(auth()->user()->image)))
                    <img class="profile-photo sm mr-1" src="{{asset('public/'.auth()->user()->image)}}">
                @else
                    <img class="profile-photo sm mr-1" src="https://dummyimage.com/1269x300/e5e8ec/e5e8ec&text=Admin">
                @endif
                <span> {{auth()->user()->username}}</span>
            </a>

              <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                <li>
                    <a href="{{route('admin.profile')}}">
                        <i class="dripicons-user"></i>
                        {{trans('file.Profile')}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.logout') }}"><i class="dripicons-power"></i>
                        {{trans('file.logout')}}
                    </a>
                  </li>
              </ul>
            </li>
          </ul>
        </div>
    </nav>
  </header>
