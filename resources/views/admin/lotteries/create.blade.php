@section('admin_title')
    <title>پنل مدیریت تسک فرکیو | قرعه کشی ها</title>
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('lotteries.index')}}">مدیریت قرعه کشی ها</a></li>
                        <li class="breadcrumb-item"><a class="my-active" href="{{route('lotteries.create')}}">ایجاد
                                قرعه کشی ها</a></li>
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
                            <h3 class="card-title">ایجاد قرعه کشی ها</h3>
                        </div>

                        <form id="store_lottery_form" action="{{route('lotteries.store')}}"
                              method="post">

                            @csrf

                            <div class="card-body">

                                <div class="form-group">
                                    {!! app('captcha')->display(); !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block" role="alert">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                    @endif
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
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?explicit&hl=fa" async defer></script>

    <script type="text/javascript">

        $(document).ready(function () {

            $('#store_lottery_form').validate({

                rules: {},

                messages: {},
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

@include('admin.layout.footer')
