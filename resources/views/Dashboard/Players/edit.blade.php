@extends('Dashboard.includes.admin')

@section('content')


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم اللاعبيين</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">لوحة التحكم</a></li>
                                <li class="breadcrumb-item active">تعديل لاعب</li>
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
                                <h4 class="card-title" id="bordered-layout-card-center">تعديل لاعب </h4>
                                <a href="/sat/courses/create.php" class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <form class="form" action="{{route('player.update', $player->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')

                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-user"></i>  بيانات اللاعب</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">اسم اللاعب </label>
                                                        <input type="text" id="projectinput1" class="form-control" placeholder="اسم اللاعب "
                                                               name="name" value="{{ $player->name }}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">تاريخ الميلاد </label>
                                                        <input type="date" id="projectinput2" class="form-control"
                                                               name="birth_day"
                                                               value="{{ $player->birth_day->format('Y-m-d')  }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">تاريخ الانضمام</label>
                                                        <input type="date" id="" class="form-control"
                                                               name="join_date" value="{{ $player->join_day->format('Y-m-d') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"> العنوان</label>
                                                        <input type="text" id="" class="form-control"  name="address" placeholder="اكتب العنوان" value="{{ $player->address }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"> الدراسه</label>
                                                        <input type="text" id="" class="form-control"  name="study" value="{{ $player->study  }}" placeholder="اكتب الدراسه">
                                                    </div>
                                                </div>
                                            </div>


                                            <h4 class="form-section"><i class="ft-user"></i> بيانات ولي الامر</h4>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName">اسم الاب</label>
                                                        <input type="text" id="" class="form-control" placeholder="اسم الاب"
                                                               name="father_name" value="{{ $player->father_name }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="companyName">رقم الهاتف </label>
                                                        <input type="text" id="" class="form-control" placeholder="رقم هاتف  الاب"
                                                               name="father_phone" value="{{ $player->father_phone }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="companyName">رقم الهاتف اخر </label>
                                                        <input type="number" id="" class="form-control" placeholder="رقم هاتف  الاب"
                                                               name="anther_phone" value="{{ $player->anther_phone }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName"> الوظيفه</label>
                                                        <input type="text" id="" class="form-control" placeholder="وظيفه الاب"
                                                               name="father_job" value="{{ $player->father_job }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName"> البريدالالكتروني </label>
                                                        <input type="text" id="" class="form-control" placeholder="البريدالالكتروني  للاب"
                                                               name="father_email" value="{{ $player->father_email }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section"><i class="icon-game-controller"></i>   الرياضه</h4>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">  الفرع</label>
                                                        <select class=" form-control " id="branch_id"  name="branch_id" >
                                                            <option value="0"> حدد الفرع</option>

                                                            @foreach($branches as $branch)
                                                                <option value="{{$branch->id}}" @if($player->branch_id == $branch->id) selected @endif>{{$branch->name}}</option>

                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">  اللعبه</label>
                                                        <select class=" form-control select2-placeholder-multiple "    id="sport_id" name="sport_id" >
                                                            <option value=""></option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="projectinput2">     المستويات</label>
                                                        <select class="select2-placeholder-multiple form-control" id="level_id" name="level_id" >
                                                            <option value="" selected>اختر مستوي </option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="projectinput2">     قائمه الاسعار</label>
                                                        <select class="select2-placeholder-multiple form-control"  multiple="multiple" id="price_list" name="price_list[]" >
                                                            <option value="" selected>اختر  قائمه سعر  </option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="projectinput2">  الباكدج</label>
                                                        <select class=" form-control" id="package_id"  name="package_id" >
                                                            <option value="0"> حدد الباكدج</option>
                                                            @foreach($packages as $package)
                                                                <option value="{{$package->id}}"  @if($player->package_id  == $package->id) selected @endif>{{$package->name}}</option>

                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName"> الرياضات الاخري</label>
                                                        <input type="text" id="" class="form-control" placeholder="الرياضات الاخري"
                                                               name="anther_sports" value="{{ $player->anther_sport}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="companyName"> الانضمام عن طريق </label>
                                                        <input type="text" id="" class="form-control" placeholder="الانضمام عن طريق"
                                                               name="join_by" value="{{ $player->join_by}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="row_file">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="" class="control-label mb-1"> اسم الملف:</label>
                                                        <input  name="name_of_file[]" type="text" class="form-control"    value="" placeholder="type your File">
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group">
                                                        <label for="cc-payment" class="control-label mb-1">الملف/صوره:</label>
                                                        <input  name="file[]" type="file" class="form-control"   value="">

                                                    </div>
                                                </div>

                                                <div class="col-1">
                                                    <div class="form-group">
                                                        <button type="button" id="add_ele" class="   btn btn-success" style="margin-top: 30px;"><i class="la la-plus"></i></button>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput8">الهدف من اللعبه </label>
                                                        <textarea id="projectinput8" rows="5" class="form-control" name="goal_of_sport" placeholder="الهدف من اللعبه ">
                                                    {{ $player->goal_of_sport }}
                                                </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput8"> ملاحظات  </label>
                                                        <textarea id="projectinput8" rows="5" class="form-control" name="note" placeholder=" ملاحظات ">
                                                            {{ $player->note }}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section">
                                                <i class="ft-clipboard"></i>
                                                الاوراق المطلوبه
                                            </h4>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label for=""> 2 صورة شخصية</label>
                                                    <input class="form-control" type="checkbox"  @if($player->personal_image=="1") checked @endif name="personal_image" id="" value="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for=""> صورة بطاقة</label>
                                                    <input class="form-control" type="checkbox" name="father_national_image"  @if($player->father_national_image=="1") checked @endif id="" value="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">شهادة ميلاد</label>
                                                    <input class="form-control" type="checkbox"  @if($player->birth_certificate=="1") checked @endif name="birth_certificate" id="" value="1">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="">شهادة المؤهل</label>
                                                    <input class="form-control" type="checkbox"  @if($player->medical=="1") checked @endif name="medical" id="" value="1">
                                                </div>
                                            </div>
                                            <hr class="form-group">

                                        </div>
                                        <div class="form-actions">

                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> حفظ
                                            </button>
                                        </div>
                                    </form>


                                </div>
                                <hr>
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2"> Student Media</h3>
                                    </div>

                                    <div class="table-responsive table--no-card m-b-30">
                                        <table class="table table-borderless table-striped table-earning">
                                            <thead>
                                            <tr>

                                                <th>Media</th>
                                                <th>Control</th>
                                            </tr>

                                            </thead>
                                            <tbody class="text-left">


                                                @forelse($player->players_files as $pf)
                                                    <tr>

                                                        <td >
                                                            <a href="{{url('/public/'.$pf->file_path)}}" target="_blank">
                                                                {{ $pf->file_name }}
                                                            </a>
                                                        </td>
                                                        <td><a href="{{url('admin/file/delete/'.$pf->id)}} " onclick="return confirm('Are You Sure For Delete This  Media')"> <i class="la la-trash"></i></a></td>
                                                        @empty
                                                            <td> Opps! there are no media Here. </td>
                                                    </tr>

                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
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

        $(window).on( 'load', function () {
            getSports();


            // getPriceList();
        });
        $('#branch_id').on('change', function () {
            getSports()
        });


        $('#sport_id').on('change', function () {
            getLevels();
            getPriceList();
        });
        function getSports(){
            var ids =$("#branch_id").val();
            var  route = "{{route('get-sports-player')}}";
            $.ajax(route,   // request url
                {
                    type: 'GET',  // http method
                    data: { "branch_id[]": ids , "player_id": "{{$player->id}}" },
                    success: function (data, status, xhr) {// success callback function
                        $("#sport_id").html(data.data);

                    }
                });
        }
        function getLevels(){
            var ids =$("#sport_id").select2("val");
            alert(ids);
            var  route = "{{route('get-levels')}}";
            $.ajax(route,   // request url
                {
                    type: 'GET',  // http method
                    data: { "sport_id": ids },
                    success: function (data, status, xhr) {// success callback function
                        $("#level_id").html(data.data);

                    }
                });
        }

        $("#level_id").on('change',function (){
            getPriceList();
        });
        function  getPriceList() {
            var sport_id = $("#sport_id").select2("val");
            var level_id = $("#level_id").select2("val");

            var route = "{{route('get-price-list-player')}}";
            $.ajax(route,   // request url
                {
                    type: 'GET',  // http method
                    data: {"sport_id": sport_id, "level_id": level_id},
                    success: function (data, status, xhr) {// success callback function
                        $('#price_list').html(data.price_list);

                    }
                });
        }
        $('#add_ele').click(function(){
            var html = ' <div class="row remve_ele"> <div class="col-6"><div class="form-group"> <label for="" class="control-label mb-1"> Name Of File:</label> <input  name="name_of_file[]" type="text" class="form-control" required   value="" placeholder="type your File">  </div>';
            html += '</div><div class="col-5"> <div class="form-group"><label for="cc-payment" class="control-label mb-1">File :</label><input  name="file[]" type="file" class="form-control" required  value=""></div></div> <div class="col-1">';
            html += ' <div class="form-group">  <button type="button" class=" remove_ele btn btn-primary " style="margin-top: 30px;"><i class="la la-trash"></i></button>   </div></div></div>';
            // alert(11)
            $('#row_file').after(html);

        });
        $(document).on('click' , ".remove_ele",function(){
            $(this).parent().parent().parent().remove();
        });

    </script>
@endsection
