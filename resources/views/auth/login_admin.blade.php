
@extends('layouts.app')

@section('content')
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
                    <!-- <p>Grursus mal suada faci lisis Lorem ipsum dolarorit more ametion consectetur elit. Vesti at bulum nec odio aea the dumm ipsumm ipsum that dolocons rsus mal suada and fadolorit to the dummy consectetur elit the Lorem Ipsum genera.</p> -->
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-12 fxt-bg-color circle">
            <div class="fxt-content">
                <div class="fxt-form">
                    <h2>Login</h2>
                    <!-- <p>Login into your pages account</p> -->
                    <form id="login_form">
                        <div class="form-group">
                            <label for="username" class="input-label">Username</label>
                            <input type="username" id="username" class="form-control" name="username" placeholder="username" required="required">
                            <i class="fa fa-fw fa-user field-icon"></i>
                        </div>
                        <div class="form-group">
                            <label for="password" class="input-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" placeholder="password" required="required">
                            <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                        </div>

                        <div class="form-group">
                            <button class="fxt-btn-fill btn-circle button-login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    $(document).ready(function() {
        login_form.onsubmit = async (e) => {
            e.preventDefault();
            $('.button-login').attr('disabled',true).addClass('not-allowed').html('Mohon tunggu..');
            let formData = new FormData($('#login_form')[0]);

            try {
                result = await $.ajax({
                    headers: {"X-CSRF-TOKEN": '{{ csrf_token() }}'},
                    url: "<?= url('login') ?>",
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
                            return false;
                        }
                        toastr.success(resp.message);
                        setTimeout(function(){ window.location.href = "<?= url('/home') ?>"; }, 100); 
                    },
                    error: function (jqXHR, exception) {
                        toastr.error(exception);
                        $('.button-login').removeAttr('disabled').html('Login').removeClass('not-allowed');
                        // setTimeout(function(){ window.location.reload(); }, 1500); 
                    },
                });
                return result;
            } catch (error) {
                toastr.error(error);
                setTimeout(function(){ window.location.reload(); }, 1500); 
            }
        };
    });

</script>