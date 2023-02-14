@extends('Dashboard.includes.admin')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم المدربيين</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
{{--                                <li class="breadcrumb-item"><a href="{{url('/admin')}}">لوحة التحكم</a></li>--}}
                                <li class="breadcrumb-item active">كل المدربيين</li>
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
                                <h4 class="card-title">المدربيين ({{$users->total()}})</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">

                                            <li>
                                                <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="{{route('trainer.create')}}"> <i class="ft-plus ft-md"></i> اضافة مدرب جديد</a>
                                            </li>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tablecontents" class="table table-hover table-xl mb-0 sortable">
                                        <thead>
                                        <tr>
                                            <th class="border-top-0">اسم المدرب</th>
                                            <th class="border-top-0">البريد الإلكتروني </th>
                                            <th class="border-top-0"> الهاتف </th>
                                            <th class="border-top-0"> الهاتف الاخر </th>
                                            <th class="border-top-0"> العنوان  </th>
{{--                                            <th class="border-top-0">قسم الوظف</th>--}}


                                            <th class="border-top-0">التحكم</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($users as $user )

                                            <tr class="row1" data-id="{{ $user->id }}" >
                                                <td class="text-truncate"> {{$user->name}} </td>
                                                <td class="text-truncate">{{$user->email}}</td>
                                                <td class="text-truncate">{{$user->phone ?? '------'}}</td>
                                                <td class="text-truncate">{{$user->phone2 ?? '------'}}</td>
                                                <td class="text-truncate">{{$user->address ?? '------'}}</td>


                                                <td class="text-truncate">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                            <a href="{{route('trainer.edit', $user->id)}}" class="btn btn-info btn-sm round"> تعديل</a>
                                                            <form action="{{route('trainer.destroy' ,$user->id)}}" method="POST" class="btn-group">
                                                                @csrf @method('delete')
                                                                <button

                                                                    class="btn btn-danger btn-sm round"
                                                                    onclick="return confirm('حذف هذه المدرب سيقوم بحذف جميع الالعاب و المتدربين المتعلقين به !! هل انت متاكد من الحذف ؟')"
                                                                >
                                                                    حذف
                                                                </button>
                                                            </form>
                                                    </div>
                                                </td>
                                            </tr>

                                        @empty
                                        <tr>
                                            <td colspan="8">
                                                لايوجد مدربيين  حاليا

                                            </td>
                                        </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($users->hasPages())
                    {{$users->appends(request()->input())->links('pagination::bootstrap-4')}}
                @endif
                <!--/ Recent Transactions -->
            </div>
        </div>
    </div>
@endsection

