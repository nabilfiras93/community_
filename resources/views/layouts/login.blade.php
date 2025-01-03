<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="Community App">

    <link href="{{ asset('login_asset') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('login_asset') }}/css/fontawesome-all.min.css" rel="stylesheet">
    <link href="{{ asset('login_asset') }}/font/flaticon.css" rel="stylesheet">
    <link href="{{ asset('login_asset') }}/css/star-animation.css" rel="stylesheet">
    <link href="{{ asset('login_asset') }}/style.css" rel="stylesheet">
    <link href="{{asset('metch')}}/plugins/global/plugins.bundlef552.css?v=7.1.8" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body>
    <style type="text/css">
        .not-allowed {
            cursor: not-allowed !important;background-color: #ff00007d !important;
        }
    </style>
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
    <section class="fxt-template-animation fxt-template-layout22" >
        <!-- Star Animation Start Here -->
        <div class="star-animation">
            <div id="stars1"></div>
            <div id="stars2"></div>
            <div id="stars3"></div>
            <div id="stars4"></div>
            <div id="stars5"></div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12 fxt-none-991">
                    <div class="fxt-header text-center">
                        <div class="fxt-transformY-50 fxt-transition-delay-1">
                        </div>
                        <br>
                        <div class="fxt-transformY-50 fxt-transition-delay-2 ">
                            <h1>Community</h1>
                        </div>
                        <div class="fxt-transformY-50 fxt-transition-delay-3">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 fxt-bg-color circle">
                    <div class="fxt-content">
                        <div class="fxt-form">
                            <h2>Login</h2>
                            <form id="login_form">
                                <div class="form-group">
                                    <label for="username" class="input-label text-black ">Email</label>
                                    <input type="username" id="username" class="form-control" name="username" placeholder="username" required="required">
                                    <i class="fa fa-fw fa-user field-icon"></i>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="input-label text-black">Password</label>
                                    <input id="password" type="password" class="form-control" name="password" placeholder="password" required="required">
                                    <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                                </div>
                                <div class="form-group">
                                    <div class="fxt-checkbox-area">
                                        <div class="checkbox">
                                            <input id="checkbox1" type="checkbox" name="remember">
                                            <label for="checkbox1" class=" text-black">Ingat saya</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="fxt-btn-fill btn-circle button-login  rounded" >Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- jquery-->
    <script src="{{asset('metch')}}/plugins/global/plugins.bundlef552.js?v=7.1.8"></script>
    <script src="{{ asset('login_asset') }}/js/jquery-3.5.0.min.js" rel="stylesheet"></script>
    <script src="{{ asset('login_asset') }}/js/bootstrap.min.js" rel="stylesheet"></script>
    <script src="{{ asset('login_asset') }}/js/imagesloaded.pkgd.min.js" rel="stylesheet"></script>
    <script src="{{ asset('login_asset') }}/js/validator.min.js" rel="stylesheet"></script>
    <script src="{{ asset('login_asset') }}/js/main.js" rel="stylesheet"></script>
    <script type="text/javascript">

        $(document).ready(function() {

            login_form.onsubmit = async (e) => {
                e.preventDefault();
                $('.button-login').attr('disabled',true).addClass('not-allowed').html('Mohon tunggu..');
                let formData = new FormData($('#login_form')[0]);

                try {
                    result = await $.ajax({
                        headers: {"X-CSRF-TOKEN": '{{ csrf_token() }}'},
                        url: "<?= url('login_') ?>",
                        type: "POST",
                        data: formData,
                        enctype: 'multipart/form-data',
                        processData: false,  // Important!
                        contentType: false,
                        cache: false,
                        dataType: 'json',
                        success: function (resp) {
                            if(resp.status == false){
                                toastr.error(resp.message);
                                $('.button-login').removeAttr('disabled').html('Login').removeClass('not-allowed');
                                refreshReCaptchaV3('contact_us_id', 'contact_us_action');
                                return false;
                            }
                            toastr.success(resp.message);
                            setTimeout(function(){ window.location.href = "<?= url('/panel/posts') ?>"; }, 100); 
                        },
                        error: function (jqXHR, exception) {
                            toastr.error(exception);
                            $('.button-login').removeAttr('disabled').html('Login').removeClass('not-allowed');
                            setTimeout(function(){ window.location.reload(); }, 1500); 
                        },
                    });
                    return result;
                } catch (error) {
                    toastr.error(error);
                    setTimeout(function(){ window.location.reload(); }, 1500); 
                }
            };
        
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

</body>
</html>