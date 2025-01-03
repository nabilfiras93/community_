<!DOCTYPE html>
<html lang="en">

@include('layouts.script_top')

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

    @include('layouts.header')

    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            {{-- ini menu --}}
            @include('layouts.menu')
            <!--end::Aside-->

            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <!--begin::Header-->
                @include('layouts.headbar')
                <!--end::Header-->

                <!--begin::Content-->
                @yield('content')
                <!--end::Content-->

                @include('layouts.footer')
            </div>
        </div>

        <audio id="sound_start" style="display:none;">
            <source src="{{asset('uploads') }}/start.webm" type="audio/ogg">
        </audio>
        <audio id="sound_finish" style="display:none;">
            <source src="{{asset('uploads') }}/finish.webm" type="audio/ogg">
        </audio><br>
    </div>

    @include('layouts.script_bottom')
    
</body>
</html>
