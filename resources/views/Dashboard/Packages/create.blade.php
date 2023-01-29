@extends('Dashboard.includes.admin')

@section('content')


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم المستويات</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">لوحة التحكم</a></li>
                                <li class="breadcrumb-item active">اضافة مستوي</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                @include('Dashboard.includes.alerts.errors')

                <div class="row justify-content-md-center">
                    <div class="col-lg-10">
                        <div class="card" style="zoom: 1;">
                            <div class="card-header">
                                <h4 class="card-title" id="bordered-layout-card-center">اضافة مستوي جديد</h4>
                                <a href="/sat/courses/create.php" class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <form class="form" action="{{route('level.store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">  اسم المستوي </label>
                                                        <input type="text" class="form-control" name="name"  required>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">  الفرع</label>
                                                        <select class=" form-control" id="branch_id" name="sport_id" >
                                                            @foreach($sports as $sport)
                                                                <option value="{{$sport->id}}">{{$sport->name}}</option>

                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>



                                                <div class="row targetDiv" id="div0">
                                                    <div class="col-md-12">
                                                        <div id="group1" class="fvrduplicate">
                                                            <div class="row entry">
                                                                <div class=" col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="projectinput2">  الالعاب</label>
                                                                        <select class=" form-control sport_val"  name="sport_id[]" onchange="getPrice( this)" >
                                                                            <option  selected value="0">حدد اللعبه</option>

                                                                        @foreach($sports as $sport)
                                                                                <option value="{{$sport->id}}">{{$sport->name}}</option>

                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group price_row">
                                                                        <label>سعر اللعبه</label>
                                                                        <input class="form-control form-control-sm price_list" name="price[]" type="number" placeholder="سعر اللعبه">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-3">
                                                                    <div class="form-group">
                                                                        <label>عدد التمرينه </label>
                                                                        <input class="form-control form-control-sm " name="number_of_training[]"
                                                                               onchange="getTotal(this)"
                                                                               type="number" placeholder="عدد التمرينات">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-2">
                                                                    <div class="form-group">
                                                                        <label> اجمالي سعر التمرينه </label>
                                                                        <input class="form-control form-control-sm total_amount" name="total_of_training[]" type="number" placeholder=" اجمالي سعر التمرينه">
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-1 mt-2">

                                                                        <button type="button" class="btn btn-success btn-add">
                                                                            <i class="fa fa-plus" aria-hidden="true">+</i>
                                                                        </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                              </div>
                                            <div class="form-actions center">
                                                <button type="submit" class="btn btn-primary w-100"><i class="la la-check-square-o"></i> حفظ</button>
                                            </div>
                                </form>
                                </div>
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

        function getPrice(selectObject){
            var value = selectObject.value;
            var  route = "{{route('get-price')}}";
            $.ajax(route,   // request url
                {
                    type: 'GET',  // http method
                    data: { "sport_id": value },
                    success: function (data, status, xhr) {// success callback function
                        $(selectObject).parent().parent().parent().find('.price_list').val(data.price);

                    }
                });
        }
                function getTotal(object){
                   var num  =object.value*1;
                  var price =   $(object).parent().parent().parent().find('.price_list').val()*1;
                  var total_price = num*price;
                    $(object).parent().parent().parent().find('.total_amount').val(total_price);



                }

        $(function() {
            $(document).on('click', '.btn-add', function(e) {
                e.preventDefault();
                var controlForm = $(this).closest('.fvrduplicate'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);
                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<i class="fa fa-minus" aria-hidden="true">-</i>');
            }).on('click', '.btn-remove', function(e) {
                $(this).closest('.entry').remove();
                return false;
            });
        });
    </script>
@endsection
