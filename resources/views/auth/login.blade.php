@section('site_title')
    <title>تسک فرکیو | خانه</title>
@endsection

@section('site_css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/common/plugins/validation/css/validate.css')}}">
@endsection

@include('site.layout.header')

<main>
    <div class="container-fluid" style="height: 600px">
        <div class="row">

            <div style="margin-top: -100px" class="col-md-12 col-sm-12 col-xs-12">
                <div class="tab-content">

                    <div id="contact" class="tab-pane fade in active">
                        <h3 class="text-center">ورود</h3>

                        @if ($errors->has('failed'))
                            <div id="failed_alert" class="alert alert-danger text-center">
                                <i onclick="$('#failed_alert').hide();" style="cursor: pointer"
                                   class="fa fa-times-circle"></i>
                                <span>{{$errors->first('failed')}}</span>
                            </div>
                        @endif

                        <div class="card card-signup col-md-6 d-flex justify-content-between col-md-offset-3">
                            <form id="login_form" class="form" method="post" action="{{route('login')}}">

                                @csrf

                                <div class="content">

                                    <br>

                                    <div class="form-group">
                                        <label for="email">ایمیل
                                            <span>*</span>
                                        </label>
                                        <input value="{{old('email')}}" autocomplete="email" autofocus id="email"
                                               name="email" onkeyup="this.value=removeSpaces(this.value)" type="text"
                                               class="form-control @error('email') is-invalid @enderror" placeholder="لطفا ایمیل را وارد کنید">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                        @enderror
                                    </div>

                                    <br>

                                    <div class="form-group">
                                        <label for="password">رمز عبور
                                            <span>*</span>
                                        </label>
                                        <input value="{{old('password')}}" autocomplete="password" autofocus id="password"
                                               name="password" onkeyup="this.value=removeSpaces(this.value)" type="password"
                                               class="form-control @error('password') is-invalid @enderror" placeholder="لطفا رمز عبور را وارد کنید">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                        @enderror
                                    </div>

                                    <br>

                                    <div class="form-group">
                                        {!! app('captcha')->display(); !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block" role="alert">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>

                                <br>

                                <div class="footer text-center">
                                    <button type="submit" class="btn btn-simple btn-success btn-lg text-blue">ورود
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>

@section('site_js')

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?explicit&hl=fa" async defer></script>
    <script type="text/javascript"
            src="{{asset('assets/common/plugins/validation/js/jquery.validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/common/plugins/validation/js/methods.js')}}"></script>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#login_form').validate({

                rules: {
                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true
                    }
                },

                messages: {
                    email: {
                        required: "لطفا ایمیل را وارد کنید",
                        email: "لطفا ایمیل را صحیح وارد کنید"
                    },

                    password: {
                        required: "لطفا رمز عبور را وارد کنید"
                    }
                },
                submitHandler: function (form) {
                    if (grecaptcha.getResponse()) {
                        form.submit();
                    } else {
                        toastr['info']('لطفا ریکپچا را کامل کنید', 'پیام');
                    }
                }

            });

        });

    </script>

@endsection

@include('site.layout.footer')
