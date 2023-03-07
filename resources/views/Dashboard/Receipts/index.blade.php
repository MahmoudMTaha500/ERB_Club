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
                                <h4 class="card-title">الايصالات ({{$receipts->total()}})</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">

                                        <li>
                                            <a class="btn btn-sm btn-success box-shadow-2 round btn-min-width pull-right" href="{{route('receipt.create')}}"> <i class="ft-plus ft-md"></i> اضافة ايصال جديد</a>
                                        </li>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="tablecontents" class="table table-hover table-xl mb-0 sortable">
                                        <thead>
                                        <tr>
                                            <th class="border-top-0">  اسم المستلم</th>
                                            <th class="border-top-0"> من </th>
                                            <th class="border-top-0"> الي </th>

                                            <th class="border-top-0">   كلي\جزئي</th>
                                            <th class="border-top-0">   المدفوع</th>
                                            <th class="border-top-0">   المتبقي</th>
                                            <th class="border-top-0">   المبلغ</th>
                                            <th class="border-top-0">   تاريخ الايصال</th>


                                            <th class="border-top-0">التحكم</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($receipts as $receipt )

                                            <tr class="row1" data-id="{{ $receipt->id }}" >
                                                <td>{{$receipt->user->name}}</td>

                                                @php
                                                    $id =  $receipt->from;
                                                    $name ='';
                                                    if($receipt->type_of_from=='players'){
                                                       $player = \App\models\Players::find($id);
                                                       $name = $player->name;
                                                    }
                                                    if($receipt->type_of_from=='others'){
                                                      $receiptType = \App\Models\ReceiptTypes::find($id);
                                                       $name = $receiptType->name;

                                                    }

                                                    $remain = 0;
                                                    if($receipt->type_of_amount == 'part'){
                                                      $remain =  $receipt->amount - $receipt->paid;
                                                    }
                                                @endphp
                                                <td>{{$name}}</td>
                                                <td>{{$receipt->receiptType->name}}</td>

                                                <td>{{ $receipt->type_of_amount == '' ? 'كلي ' : 'جزئي' }}</td>

                                                <td>{{ $receipt->paid ?? $receipt->amount }}</td>


                                                <td>
                                                 {{ $remain }}
                                                </td>
                                                <td>
                                                 {{ $receipt->amount }}
                                                </td>
                                                <td>
                                                 {{ $receipt->date_receipt }}
                                                </td>


                                                <td class="text-truncate">
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{route('receipt.edit', $receipt->id)}}" class="btn btn-info btn-sm round"> تعديل</a>
                                                        <form action="{{route('receipt.destroy' ,$receipt->id)}}" method="POST" class="btn-group">
                                                            @csrf @method('delete')
                                                            <button

                                                                class="btn btn-danger btn-sm round"
                                                                onclick="return confirm('حذف هذا الايصال سيقوم بحذف جميع الفروع و الالعاب المتعلقه به!! هل انت متاكد من الحذف ؟')"
                                                            >
                                                                حذف
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                لايوجد ايصالات حاليا
                                            </tr>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($receipts->hasPages())
                    {{$receipts->appends(request()->input())->links('pagination::bootstrap-4')}}
                @endif
                <!--/ Recent Transactions -->
            </div>
        </div>
    </div>
@endsection

