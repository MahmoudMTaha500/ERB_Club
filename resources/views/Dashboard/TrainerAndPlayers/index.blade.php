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
                                                                <label for="projectinput2">  الفرع</label>
                                                                <select class=" form-control" id="branch_id"  name="branch_id" >
                                                                    <option value="0"> حدد الفرع</option>
                                                                    @foreach($branches as $branch)
                                                                        <option value="{{$branch->id}}">{{$branch->name}}</option>

                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> الملعب </label>
                                                                <select
                                                                    class=" form-control"
                                                                    name="stadium_id" id="stadium_id">

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2">  اللعبه</label>
                                                                <select class=" form-control  "    id="sport_id" name="sport_id" >
                                                                    <option value=""></option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2">     المستويات</label>
                                                                <select class=" form-control" id="level_id" name="level_id" >
                                                                    <option value="" selected>اختر مستوي </option>
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="projectinput2"> المدرب </label>
                                                                <select
                                                                    class=" form-control"
                                                                    name="user_id" id="user_id">

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

                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="projectinput2"> من الساعه </label>
                                                                <input class="form-control" type="time" name="form" id="from_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="projectinput2"> الي الساعه </label>
                                                                <input class="form-control" type="time" name="to" id="to_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="projectinput2">  عدد المرات </label>
                                                                <input class="form-control" type="number" name="number" id="number">
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
            $('#branch_id').on('change', function () {
                var ids =$("#branch_id").val();

                var  route = "{{route('get-sports')}}";
                $.ajax(route,   // request url
                    {
                        type: 'GET',  // http method
                        data: { "branch_id[]": ids },
                        success: function (data, status, xhr) {// success callback function
                            $("#sport_id").html(data.data);

                        }
                    });
                getStadiums(ids);
            });
            $('#sport_id').on('change', function () {
                var ids =$("#sport_id").val();
                var  route = "{{route('get-levels')}}";
                $.ajax(route,   // request url
                    {
                        type: 'GET',  // http method
                        data: { "sport_id": ids },
                        success: function (data, status, xhr) {// success callback function
                            $("#level_id").html(data.data);

                        }
                    });
            });
            $("#level_id").on('change',function(){
                var level_id = $("#level_id").val();
                var sport_id = $("#sport_id").val();
                getTrainers(sport_id, level_id);
                getPlayers(sport_id, level_id);

            } )
function getStadiums(branch_id){
    var  route = "{{route('get-stadium')}}";
    $.ajax(route,   // request url
        {
            type: 'GET',  // http method
            data: { "branch_id": branch_id },
            success: function (data, status, xhr) {// success callback function
                $("#stadium_id").html(data.data);

            }
        });
}
   function getTrainers(sport_id, level_id)
   {
       var  route = "{{route('get-trainers')}}";

       $.ajax(route,   // request url
           {
               type: 'GET',  // http method
               data: { "sport_id": sport_id,"level_id":level_id },
               success: function (data, status, xhr) {// success callback function
                   $("#user_id").html(data.data);

               }
           });
   }
      function getPlayers(sport_id, level_id)
      {
          var  route = "{{route('get-players')}}";

          $.ajax(route,   // request url
              {
                  type: 'GET',  // http method
                  data: { "sport_id": sport_id,"level_id":level_id },
                  success: function (data, status, xhr) {// success callback function
                      $("#player_id").html(data.data);

                  }
              });
      }
            function resetForm() {

                document.getElementById("form_id").reset();

            }
            function saveEventCalendar(start){
                $("#saveEvent").click(function () {
                    var day = $.fullCalendar.formatDate(start, 'Y-MM-DD ');

                    var stadium_id = $('#stadium_id').val();
                    var player_id = $('#player_id').select2("val");
                    var user_id = $('#user_id').val();
                    var sport_id = $('#sport_id').val();
                    var level_id = $('#level_id').val();
                    var number = $('#number').val();
                    var hour_from= $("#from_date").val();
                    var hour_to= $("#to_date").val();

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
                                sport_id: sport_id,
                                level_id: level_id,
                                day : day,
                                from: hour_from,
                                to: hour_to,
                                number: number
                            },
                            success: function (data) {
                                // location.reload();
                                calendar.fullCalendar('refetchEvents');
                                alert("تم اضافه موعد جديد  ");

                                resetForm();
                                $("#calendarModal").modal("hide");


                            }

                        });
                    }

                });
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var calendar = $('#calendar').fullCalendar({
                editable: true,
                validRange: {
                    start: moment().format('YYYY-MM-DD'),
                    end: '2100-01-01' // hard coded goodness unfortunately
                },
                visibleRange: {
                    start: moment().subtract(30, 'days'), // set the start date of the visible range to 30 days ago
                    end: moment().add(30, 'days') // set the end date of the visible range to 30 days in the future
                },
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },

                events: "{{ route('trainer-and-player.create') }}",
                selectable: true,
                timezone: 'Egypt', // set timezone to Egypt
                defaultView: 'month', // set the default view to month
                defaultDate: moment(),
                selectHelper: true,
                slotDuration: '00:05:00',

                select: function ( start, end, allDay) {
                        $('#saveEvent').off("click"); // Added off click there
                        $("#calendarModal").modal("show");
                        saveEventCalendar(start);
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

