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
                        <li class="breadcrumb-item"><a class="my-active" href="javascript:void(0)">نمایش
                                نتیجه قرعه کشی با کد ({{$lottery->code}})</a></li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-3">نمایش
                                نتیجه قرعه کشی با کد ({{$lottery->code}})</h3>
                        </div>

                        <div class="card-body table-responsive p-0">

                            <div class="alert alert-success text-center">
                                <p>نام و نام خانوادگی : {{$lottery->user->fullName}}</p>
                                <p>کد : {{$lottery->code}}</p>
                                <p>تاریخ : {{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($lottery['created_at']))}}</p>
                            </div>

                            <a class="btn btn-info" href="{{route('lotteries.index')}}">بازگشت به عقب</a>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@include('admin.layout.footer')
