@if(session('my_name'))
<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
            </div>
        </div>
        <div class="topbar">
            <div class="topbar-item" onclick="swag_logout()">
                <div
                    class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2">
                    <span
                        class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hello, </span>
                    <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">
                        {{ session('my_name') }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold"><i
                                class="fas fa-power-off"></i></span>
                    </span>
                </div>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
                @csrf
            </form>
        </div>
    </div>
</div>
@else 
<div class="container-fluid justify-content-between mb-5" style="margin-top: -30px;">
    <h3 class="font-weight-bold"><a href="{{ url('/') }}"><i class="fa fa-arrow-left"></i></a></h3><br>
    <h3><center> Community</center></h3>
</div>
@endif