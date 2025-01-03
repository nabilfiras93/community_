<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Up-2.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
            height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path
                    d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                    fill="#000000" fill-rule="nonzero" />
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>
</div>
<!--end::Scrolltop-->

<div class="my-loader" style="display:none;">
    <div class="my-loader-inner">
        <div class="my-loader-line-wrap">
            <div class="my-loader-line"></div>
        </div>
        <div class="my-loader-line-wrap">
            <div class="my-loader-line"></div>
        </div>
        <div class="my-loader-line-wrap">
            <div class="my-loader-line"></div>
        </div>
        <div class="my-loader-line-wrap">
            <div class="my-loader-line"></div>
        </div>
        <div class="my-loader-line-wrap">
            <div class="my-loader-line"></div>
        </div>
    </div>
</div>

<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };

</script>
<script type="text/javascript">
    var userGroupSequence = "{{ session('group_sequence') }}";
    async function swal_success(message='', reload=false, timer=2000) {
        Swal.fire({
            // position: 'top-end',
            icon: 'success',
            title: message,
            showConfirmButton: false,
            timer: timer
        }).then((result) => {
            // if(reload) window.location.reload();
        });
    }
    async function swal_error(message='', reload=false, timer=2500) {
        Swal.fire({
            position: 'centered',
            icon: 'error',
            title: `${message}`,
            showConfirmButton: true,
            timer: timer
        }).then((result) => {
            if(reload) window.location.reload();
        });
    }
    function statusBadges(status) {
        let _return;
        if(status=='0' || status=='I' || status=='-'){
            _return = '<center><span class="btn-sm rounded btn-danger">Tidak</span></center>';
        } else if(status=='1' || status=='A'){
            _return = '<center><span class="btn-sm rounded btn-success">Ya</span></center>';
        } else if(status==null || status==undefined){
            _return = `<center><span class="btn-sm rounded btn-dark">${status}</span></center>`;
        } else {
            _return = `<center><span class="btn-sm rounded btn-primary">${status}</span></center>`;
        }
        return _return;
    }
    function showValidation(err, modalName=false) {
        $(`.invalid`).html('');
        $(`.header-invalid`).html('').removeClass('alert bg-light-danger d-flex align-items-center p-5 mb-10');
        if($.type(err) === 'string' || err == null){
            swal_error(err);
        }
        else if($.isArray(err)){
            $.each(err, function(i, val){
                if(Number.isInteger(i)){
                    swal_error(val);
                } else {
                    let errorId = val.split(" field is")[0].split("The ")[1];
                    if($(`.${errorId}`).hasClass('invalid')){
                        $(`.${errorId}`).html(`<div class="fs-7 fw-bold text-danger">${val}</div>`);
                    }
                    if(i==0){
                        if(modalName){
                            $(`.header-invalid`).html(`Mohon perhatikan kolom isian yang bertanda merah`);
                            $(`#${modalName}`).animate({scrollTop: $(`#${errorId}`).offset().top - 30}, 1000);
                        } else {
                            $('html, body').animate({scrollTop: $(`#${errorId}`).offset().top}, 2000);
                        }
                    }
                }
            });
        } 
        else {
            Object.entries(err).forEach(([key, val]) => {
                $.each(val, function(i, item){
                    $(`.invalid.${key}`).html(`<div class="fs-7 fw-bold text-danger">${item}</div>`);
                });
            });
            let firstObject = Object.entries(err)[0][0];
            if(modalName){
                $(`.header-invalid`).html(`Mohon perhatikan kolom isian yang bertanda merah`).addClass('alert alert-danger d-flex align-items-center p-5 mb-10');
                $(`#${modalName}`).animate({scrollTop: $(`#${firstObject}`).offset().top +'px'}, 1000);
            } else {
                $('html, body').animate({scrollTop: $(`#${firstObject}`).offset().top}, 2000);
            }
        }
    }

    const deleteFile = async (fileName, path) => {
        let result;
        result = await $.ajax({
            url: "{{ url('siswa/deleteFile') }}",
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}", Accept: "application/json",},
            type: "POST",
            data: {path:path, filename:fileName},
            success: function (res) {
            },
            error: function (data) {
            }
        });
        return result;
    }

    function sound_start() {
        let context = new AudioContext();
        let x = document.getElementById("sound_start").play();
    }

    function sound_finish() {
        let context = new AudioContext();
        let x = document.getElementById("sound_finish").play();
    }
</script>
{{-- <script src="{{asset('metch')}}/plugins/custom/datatables/datatables.bundlef552.js?v=7.1.8"></script> --}}
<script src="{{asset('metch')}}/plugins/global/plugins.bundlef552.js?v=7.1.8"></script>
{{-- <script src="{{asset('metch')}}/plugins/custom/prismjs/prismjs.bundlef552.js?v=7.1.8"></script> --}}
<script src="{{asset('metch')}}/js/scripts.bundlef552.js?v=7.1.8"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{asset('metch')}}/plugins/custom/fullcalendar/fullcalendar.bundlef552.js?v=7.1.8"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{asset('metch')}}/js/pages/widgetsf552.js?v=7.1.8"></script>
{{-- cdn datatable --}}
<script src="{{asset('metch')}}/js/pdfmake.min.js"></script>
<script src="{{asset('metch')}}/js/vfs_fonts.js"></script>
<script src="{{asset('metch')}}/js/datatables.min.js"></script>

<script type="text/javascript">
    $('document').ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true
        });
        $('.numeric').keyup(function (e) {
            this.value = this.value.replace(/\D/g,'');
        });
        $('.uppercase').keyup(function (e) {
            this.value = this.value.toUpperCase();
        });
    });

    $(document).on('click', '.collapse_all', function () {
        if($(this).hasClass('menu-opened')){
            $(this).removeClass('menu-opened');
            $(this).addClass('fa-angle-double-down').removeClass('fa-angle-double-up');
            $('.menu-item.menu-item-submenu').removeClass('menu-item-open');
        } else {
            $(this).addClass('menu-opened');
            $(this).addClass('fa-angle-double-up').removeClass('fa-angle-double-down');
            $('.menu-item.menu-item-submenu').addClass('menu-item-open');
        }
    });

    $(document).on('keyup change', ".uppercase", function (e) {
        this.value = this.value.toUpperCase();
    });
    $(document).on('keyup change', ".numeric", function (e) {
        this.value = this.value.replace(/\D/g,'');
    });
    $(document).on('keyup change', ".replace_comma", function (e) {
        this.value = this.value.replace(/,/g,'.');
    });
</script>
@stack('scripts')