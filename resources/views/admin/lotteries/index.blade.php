@section('admin_title')
    <title>پنل مدیریت تسک فرکیو | قرعه کشی ها</title>
@endsection

@section('admin_css')
    <link type="text/css" rel="stylesheet"
          href="{{asset('assets/backend/plugins/persianDatepicker/css/persianDatepicker-default.css')}}">
@endsection

@include('admin.layout.header')

@include('admin.layout.sidebar')

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="my-active" href="{{route('lotteries.index')}}">مدیریت
                                قرعه کشی ها</a></li>
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
                            <h3 class="card-title mb-3">مدیریت قرعه کشی ها</h3>

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

                        <div class="card-body table-responsive p-0 mt-5">
                            <table class="table table-hover table-bordered text-center">

                                <tr>
                                    <th>ردیف</th>
                                    <th>کاربر</th>
                                    <th>کد</th>
                                    <th>تاریخ</th>
                                    <th>حذف</th>
                                </tr>

                                @if(count($lotteries))

                                    @foreach($lotteries as $key=>$value)

                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value->user->fullName}}</td>
                                            <td>{{$value->code}}</td>
                                            <td>{{\Morilog\Jalali\CalendarUtils::strftime('Y/m/d', strtotime($value['created_at']))}}</td>
                                            <td><a href="{{ route('lotteries.destroy', $value->id) }}"
                                                   onclick="destroyLottery(event, {{ $value->id }})"><i
                                                        class="fa fa-remove text-danger"></i></a>
                                                <form action="{{ route('lotteries.destroy', $value->id) }}"
                                                      method="post" id="destroy-Lottery-{{ $value->id }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </td>

                                        </tr>

                                    @endforeach

                                @else

                                    <div class="alert alert-danger text-center">
                                        <p>اطلاعات این بخش ثبت نشده است</p>
                                    </div>

                                @endif

                            </table>

                        </div>

                        <div class="pagination mt-3">
                            {!! $lotteries->withQueryString()->links() !!}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

@section('admin_js')
    <script type="text/javascript"
            src="{{asset('assets/backend/plugins/persianDatepicker/js/persianDatepicker.min.js')}}"></script>

    <script type="text/javascript">

        $("#date").persianDatepicker({formatDate: "YYYY-0M-0D"});

        $('#dateForm').on('submit', function (e) {
            e.preventDefault();
            var base_url = '{{cleanExtraQueryString(['date'],null,'lotteries.index')}}';
            var route = "{{route('lotteries.index')}}";
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
            var route = "{{route('lotteries.index')}}";
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

        function destroyLottery(event, id) {
            event.preventDefault();
            Swal.fire({
                title: 'آیا از حذف اطمینان دارید ؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgb(221, 51, 51)',
                cancelButtonColor: 'rgb(48, 133, 214)',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`destroy-Lottery-${id}`).submit()
                }
            })
        }
    </script>
@endsection

@include('admin.layout.footer')
