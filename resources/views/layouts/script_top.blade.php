<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('title', 'Rekrutmen')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('uploads')}}/dalwa.ico">
    <!--begin::Fonts-->
    <link href="{{asset('metch')}}/css/fonts.css" rel="stylesheet" type="text/css" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{asset('metch')}}/plugins/custom/fullcalendar/fullcalendar.bundlef552.css?v=7.1.8" rel="stylesheet"
        type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{asset('metch')}}/plugins/global/plugins.bundlef552.css?v=7.1.8" rel="stylesheet" type="text/css" />
    <link href="{{asset('metch')}}/plugins/custom/prismjs/prismjs.bundlef552.css?v=7.1.8" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('metch')}}/css/style.bundlef552.css?v=7.1.8" rel="stylesheet" type="text/css" />
    <link href="{{asset('metch')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{asset('metch')}}/css/themes/layout/header/base/lightf552.css?v=7.1.8" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('metch')}}/css/themes/layout/header/menu/lightf552.css?v=7.1.8" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('metch')}}/css/themes/layout/brand/darkf552.css?v=7.1.8" rel="stylesheet" type="text/css" />
    <link href="{{asset('metch')}}/css/themes/layout/aside/darkf552.css?v=7.1.8" rel="stylesheet" type="text/css" />
    <link href="{{asset('metch')}}/uiicon/css/uicons-regular-rounded.css" rel="stylesheet">
    {{-- cdn --}}
    <link href="{{asset('metch')}}/css/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="{{asset('metch')}}/css/spinkit.min.css" rel="stylesheet" type="text/css" />

    {{-- csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- table styling --}}
    <style>
        select[readonly].select2-hidden-accessible + .select2-container {
            pointer-events: none;
            touch-action: none;
        }
        select[readonly].select2-hidden-accessible + .select2-container .select2-selection {
            background: #eee;
            box-shadow: none;
        }
        select[readonly].select2-hidden-accessible + .select2-container .select2-selection__arrow, select[readonly].select2-hidden-accessible + .select2-container .select2-selection__clear {
            display: none;
        }
        input[readonly]{
            background-color: #d3d3d3!important;
        }
        .paginate_button .current {
            background: blue;
        }
        @media (min-width: 992px){
        .header-fixed.subheader-fixed.subheader-enabled .wrapper {
             padding-top: 70px !important; 
        }
        table.dataTable tbody td {
            /*word-break: break-word;
            vertical-align: top;*/
        }
        .modal {
            overflow-y:auto;
        }
    </style>
    <script>
        function swag_logout() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Log out',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
        const randomNum = () => Math.floor(Math.random() * (235 - 52 + 1) + 52);
        const randomRGB = () => `rgb(${randomNum()}, ${randomNum()}, ${randomNum()}, 0.7)`;

    </script>
    <script src="{{asset('metch')}}/plugins/custom/chart.js/dist/chart.umd.js"></script>
    <script src="{{asset('metch')}}/plugins/custom/chart.js/dist/chartjs-gauge.js"></script>
</head>