@section('admin_title')
    <title>پنل مدیریت تسک فرکیو | کاربران</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">مدیریت کاربران</a></li>
                        <li class="breadcrumb-item"><a class="my-active" href="{{route('users.create')}}">ایجاد
                                کاربران</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-primary">

                        <div class="card-header">
                            <h3 class="card-title">ایجاد کاربران</h3>
                        </div>

                        <form id="store_user_form" action="{{route('users.store')}}"
                              method="post">

                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="f_name">نام کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('f_name') is-invalid @enderror"
                                           value="{{ old('f_name') }}" id="f_name" name="f_name"
                                           placeholder="لطفا نام کاربر را وارد کنید"
                                           autocomplete="f_name" autofocus>

                                    @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="l_name">نام خانوادگی کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('l_name') is-invalid @enderror"
                                           value="{{ old('l_name') }}" id="l_name" name="l_name"
                                           placeholder="لطفا نام خانوادگی کاربر را وارد کنید"
                                           autocomplete="l_name" autofocus>

                                    @error('l_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">ایمیل کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="text"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" id="email" name="email"
                                           placeholder="لطفا ایمیل کاربر را وارد کنید" autocomplete="email"
                                           autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">رمز عبور کاربر *</label>
                                    <input onkeyup="this.value=removeSpaces(this.value)" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           value="{{ old('password') }}" id="password" name="password"
                                           placeholder="لطفا رمز عبور کاربر را وارد کنید"
                                           autocomplete="password" autofocus>

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">ارسال</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@section('admin_js')
    <script type="text/javascript">

        $(document).ready(function () {

            $('#store_user_form').validate({

                rules: {
                    f_name: {
                        required: true
                    },

                    l_name: {
                        required: true
                    },

                    email: {
                        required: true,
                        email: true
                    },

                    password: {
                        required: true,
                        minlength: 8
                    }
                },

                messages: {
                    f_name: {
                        required: "لطفا نام کاربر را وارد کنید"
                    },

                    l_name: {
                        required: "لطفا نام خانوادگی کاربر را وارد کنید"
                    },

                    email: {
                        required: "لطفا ایمیل کاربر را وارد کنید",
                        email: "لطفا ایمیل کاربر را صحیح وارد کنید"
                    },

                    password: {
                        required: "لطفا رمز عبور کاربر را وارد کنید",
                        minlength: "لطفا رمز عبور کاربر را حداقل 8 کاراکتر وارد کنید"
                    }
                }

            });

        });

    </script>
@endsection

@include('admin.layout.footer')
