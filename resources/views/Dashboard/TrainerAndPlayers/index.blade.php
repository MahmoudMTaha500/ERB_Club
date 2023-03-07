@extends('Dashboard.includes.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم الايصالات</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}">لوحة التحكم</a></li>
                                <li class="breadcrumb-item active">كل الايصالات</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            @if(Session::has('message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{session()->get('message')}}</strong>
                </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{session()->get('error')}}</strong>
                </div>
            @endif

            <div class="content-body">
                <!-- Recent Transactions -->
                <div class="row">
                    <div id="recent-transactions" class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"></h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">

                                        <li>
                                            {{--                                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="{{route('receipt.create')}}"> <i class="ft-plus ft-md"></i> اضافة ايصال جديد</a>--}}
                                        </li>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div id="calendarModalDetails" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">×</span> <span class="sr-only">close</span>
                                            </button>
                                            <h4 id="modalTitle" class="modal-title"></h4>
                                        </div>
                                        <div id="modalBody" class="modal-body">

                                            <form class="form" action="" method="POST"
                                            >
                                                @csrf
                                                <div class="form-body">
<div class="row">
    <div class="col-md-6">
        <h2 id="stadium_name"> </h2>
    </div>
    <div class="col-md-6">
        <h2 id="trainer_name"> </h2>

    </div>
</div>
                                                    <div class="table-responsive">
                                                        <table class="table" id="table_details">
                                                            <thead>
                                                            <tr >
                                                                <th>الاعب </th>

                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr id="player_name"></tr>


                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="deleteEvent" class="btn btn-danger"
                                            >حذف
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">غلق
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="calendarModal" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span
                                                    aria-hidden="true">×</span> <span class="sr-only">close</span>
                                            </button>
                                            <h4 id="modalTitle" class="modal-title"></h4>
                                        </div>
                                        <div id="modalBody" class="modal-body">

                                            <form class="form" id="form_id" action="" method="POST"
                                            >
                                                @csrf
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> الملعب </label>
                                                                <select
                                                                    class=" form-control"
                                                                    name="stadium_id" id="stadium_id">
                                                                    @foreach($stadiums as $stadium)
                                                                        <option
                                                                            value="{{$stadium->id}}">{{$stadium->name}}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> المدرب </label>
                                                                <select
                                                                    class=" form-control"
                                                                    name="user_id" id="user_id">
                                                                    @foreach($users as $user)
                                                                        <option
                                                                            value="{{$user->id}}">{{$user->name}}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> اللاعب </label>
                                                                <select style="width: 100% !important;"
                                                                    class="select2 form-control " multiple="multiple"
                                                                    name="player_id"
                                                                    id="player_id">
                                                                    @foreach($players as $player)
                                                                        <option
                                                                            value="{{$player->id}}">{{$player->name}}</option>

                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="saveEvent" class="btn btn-primary"
                                            >save
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id='calendar'>

                            </div>
                        </div>
                    </div>
                </div>

                <!--/ Recent Transactions -->
            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function () {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },


                events: "{{ route('trainer-and-player.create') }}",
                selectable: true,
                selectHelper: true,

                select: function ( start, end, allDay) {
                    $("#calendarModal").modal("show");
                    $("#saveEvent").click(function () {
                        console.log(start);
                        var day = $.fullCalendar.formatDate(start, 'Y-MM-DD ');
                        var stadium_id = $('#stadium_id').val();
                        var player_id = $('#player_id').select2("val");
                        var user_id = $('#user_id').val();
                        var from = $('#from').val();
                        var from_date = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');

                        var to = $('#to').val();
                        var to_date = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');


                        if (user_id) {
                            var Route = "{{route('store-event')}}";
                            jQuery.ajax({
                                url: Route,
                                type: "POST",
                                dataType: 'json',
                                data: {
                                    stadium_id: stadium_id,
                                    player_id: player_id,
                                    user_id: user_id,
                                    day : day,
                                     from: from_date,
                                    to: to_date
                                },
                                success: function (data) {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("تم اضافه موعد جديد  ");
                                    $("#calendarModal").modal("hide");
                                    location.reload();

                                }

                            });
                        }

                    });

                },
                editable: true,
                eventResize: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    var Route = "{{route('update-event')}}";

                    $.ajax({
                        url: Route,
                        type: "post",
                        data: {
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            // alert("تم تعديل المعاد  ");
                        }
                    })
                    die();

                },
                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    var Route = "{{route('update-event')}}";

                    $.ajax({
                        url: Route,
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            type: 'update'
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            // alert("تم تعديل الميعاد  ");
                        }
                    })
                },

                eventClick: function (event) {

                    var id = event.id;
                    var Route = "{{route('show-event')}}";
                    $.ajax({
                        url: Route,
                        type: "get",
                        data: {
                            id: id,
                            type: "show"
                        },
                        success: function (response) {
                            $('#player_name').html(response.players);
                            $('#stadium_name').html(response.stadium_name);
                            $('#trainer_name').html(response.trainer_name);
                            $("#calendarModalDetails").modal("show");

                        }
                    })

                    $('#deleteEvent').click(function(){

                    if (confirm("هل انت  متاكد من حذف هذا اليعاد")) {
                        var id = event.id;
                        var Route = "{{route('delete-event')}}";
                        $.ajax({
                            url: Route,
                            type: "POST",
                            data: {
                                id: id,
                                type: "delete"
                            },
                            success: function (response) {
                                calendar.fullCalendar('refetchEvents');
                                $("#calendarModalDetails").modal("hide");

                                // alert("تم حذف الميعاد من التقويم  ");
                            }
                        })
                    }
                    });

                }
            });

        });

    </script>

@endsection

