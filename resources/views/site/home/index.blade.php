@section('site_title')
    <title>تسک فرکیو | خانه</title>
@endsection

@section('site_css')
    <link type="text/css" rel="stylesheet"
          href="{{asset('assets/backend/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('site.layout.header')

<main>
    <div class="container-fluid" style="height: 900px">
        <div class="row">

            <div class="col-md-3 col-sm-4 col-xs-12">
                <ul class="nav nav-pills nav-pills-success nav-stacked">
                    <li class="active"><a data-toggle="pill" href="#lotteries">نتایج قرعه کشی</a></li>
                    @auth()
                        <li><a data-toggle="pill" href="#about">بیوگرافی</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="tab-content">

                    <div id="lotteries" class="tab-pane fade in active">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-3 text-center">نتایج قرعه کشی ها</h3>

                                <div class="card-tools">

                                    <form id="dateForm" method="get"
                                          action="{{route('lotteries.index')}}">
                                        <div class="input-group input-group-sm" style="width: 300px;">
                                            <input readonly id="date" value="{{request()->input('date')}}" type="text"
                                                   name="date"
                                                   class="form-control float-right"
                                                   placeholder="جستجو بر اساس تاریخ">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <br>

                                    <form id="filterForm" method="get"
                                          action="{{route('lotteries.index')}}">
                                        <div class="input-group input-group-sm" style="width: 300px;">
                                            <input onkeyup="this.value=removeSpaces(this.value)" id="search"
                                                   value="{{request()->input('search')}}" type="text"
                                                   name="search"
                                                   class="form-control float-right"
                                                   placeholder="جستجو بر اساس کاربر و کد">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                            <br>

                            <div class="card-body table-responsive p-0 mt-5">
                                <table class="table table-hover table-bordered text-center">

                                    <tr>
                                        <th class="text-center">ردیف</th>
                                        <th class="text-center">کاربر</th>
                                        <th class="text-center">کد</th>
                                        <th class="text-center">تاریخ</th>
                                    </tr>

                                    @if(count($lotteries))

                                        @foreach($lotteries as $key=>$value)

                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->user->fullName}}</td>
                                                <td>{{$value->code}}</td>
                                                <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value['created_at']))}}</td>
                                            </tr>

                                        @endforeach

                                    @else

                                        <div class="alert alert-danger text-center">
                                            <p>اطلاعات این بخش ثبت نشده است</p>
                                        </div>

                                    @endif

                                </table>

                            </div>

                            <div class="pagination mt-3 center-block">
                                {!! $lotteries->withQueryString()->links() !!}
                            </div>

                        </div>
                    </div>

                    @auth()
                        <div id="about" class="tab-pane fade">
                            <h3 class="text-center">بیوگرافی</h3>
                            <p><span><i class="fa fa-user-circle"></i><strong>نام :</strong></span> {{auth()->user()->f_name}} </p>
                            <p><span><i class="fa fa-user-circle"></i><strong>نام خانوادگی :</strong></span> {{auth()->user()->l_name}} </p>
                            <p><span><i class="fa fa-envelope"></i><strong>ایمیل :</strong></span> {{auth()->user()->email}}
                            </p>
                        </div>
                    @endauth

                </div>
            </div>

        </div>
    </div>
</main>

@section('site_js')
    <script type="text/javascript"
            src="{{asset('assets/backend/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>

    <script type="text/javascript">

        $("#date").persianDatepicker({formatDate: "YYYY-0M-0D"});

        $('#dateForm').on('submit', function (e) {
            e.preventDefault();
            var base_url = '{{cleanExtraQueryString(['date'],null,'home')}}';
            var route = "{{route('home')}}";
            var date = $('#date').val();

            if (date.length !== 0) {

                if (base_url.indexOf('?' + 'date' + '=') != -1 || base_url.indexOf('&' + 'date' + '=') != -1) {
                    var new_url = replaceUrlParam(base_url, 'date', date);
                    window.location.href = removeURLParameter(new_url, 'page');
                } else {
                    if (base_url === route) {
                        this.submit();
                    } else {
                        var new_url = base_url + '&date=' + date;
                        window.location.href = removeURLParameter(new_url, 'page');
                    }
                }

            }

        })

        $('#filterForm').on('submit', function (e) {
            e.preventDefault();
            var base_url = window.location.href;
            var route = "{{route('home')}}";
            var search = $('#search').val();

            if (search.length !== 0) {
                if (base_url.indexOf('?' + 'search' + '=') != -1 || base_url.indexOf('&' + 'search' + '=') != -1) {
                    var new_url = replaceUrlParam(base_url, 'search', search);
                    window.location.href = removeURLParameter(new_url, 'page');
                } else {
                    if (base_url === route) {
                        this.submit();
                    } else {
                        var new_url = base_url + '&search=' + search;
                        window.location.href = removeURLParameter(new_url, 'page');
                    }
                }
            }

        })


    </script>
@endsection

@include('site.layout.footer')
