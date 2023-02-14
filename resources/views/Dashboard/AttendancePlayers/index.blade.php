@extends('Dashboard.includes.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم الخضور و الانصراف للاعبيين </h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/admin')}}">لوحة التحكم</a></li>
                                <li class="breadcrumb-item active">كل الخضور و الانصراف للاعبيين </li>
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
                                <h4 class="card-title">الخضور و الانصراف للاعبيين  ({{$players->total()}})</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">

{{--                                        <li>--}}
{{--                                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="{{route('level.create')}}"> <i class="ft-plus ft-md"></i> اضافة مستوي جديد</a>--}}
{{--                                        </li>--}}
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tablecontents" class="table table-hover table-xl mb-0 sortable">
                                        <thead>
                                        <tr>
                                            <th class="border-top-0">  اسم اللاعب</th>
                                            <th class="border-top-0"> حضور</th>

                                            <th class="border-top-0">   انصراف</th>


                                            <th class="border-top-0">مشاهده التفاصيل </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($players as $player )

                                            <tr class="row1" data-id="{{ $player->id }}" >
                                                <td>{{$player->name}}</td>

                                                <td>
                                                    <form action="{{route('attendance-player.store')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="player_id" value="{{$player->id}}">

                                                        <button class="btn btn-success" name="check" value="in"> حضور </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{route('attendance-player.store')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="player_id" value="{{$player->id}}">

                                                        <button class="btn btn-danger" name="check" value="out"> انصراف </button>
                                                    </form>
                                                </td>
                                   <td>
                                       <button class="btn btn-bitbucket"> <i class="la la-eye"></i> </button>
                                   </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                لايوجد حضور و انصراف حاليا
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($players->hasPages())
                    {{$players->appends(request()->input())->links('pagination::bootstrap-4')}}
                @endif
                <!--/ Recent Transactions -->
            </div>
        </div>
    </div>
@endsection

