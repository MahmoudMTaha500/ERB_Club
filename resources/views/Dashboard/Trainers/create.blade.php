@extends('Dashboard.includes.admin')

@section('content')

    <div class="app-content content vue-app">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم المدربين</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a >لوحة التحكم</a></li>
                                <li class="breadcrumb-item"><a > المدربين</a></li>
                                <li class="breadcrumb-item active">اضافة مدرب</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Recent Transactions -->
                <div class="row justify-content-md-center">
                    <div class="col-lg-10">
                        <div class="card" style="zoom: 1;">
                            <div class="card-header">
                                <h4 class="card-title" id="bordered-layout-card-center">اضافة مدرب جديد</h4>
                                <a href="/sat/courses/create.php" class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">
                                    <form class="form" action="{{route('trainer.store')}}" method="POST">
                                        @csrf
                                        @include('Dashboard.includes.alerts.errors')


                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">اسم المدرب</label>
                                                        <input type="text" id="projectinput1" class="form-control" required placeholder="ادخل اسم المدرب" name="name" value="{{old('name')}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="projectinput1">هاتف </label>
                                                        <input type="number" id="projectinput1" class="form-control"  placeholder="ادخل هاتف المدرب" name="phone" value="{{old('phone')}}" maxlength="11" />

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> هاتف اخر </label>
                                                        <input type="number" id="phone2" class="form-control"  placeholder="ادخل هاتف  اخر المدرب" name="phone2" value="{{old('phone2')}}" maxlength="11" />

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">البريد الإلكتروني</label>
                                                        <input type="email" id="projectinput1" class="form-control" required placeholder="ادخل البريد الإلكتروني" name="email" value="{{old('email')}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">كلمه السر </label>
                                                        <input type="text" id="projectinput3" rows="20" class="form-control" required placeholder="كلمه السر" name="password" value="{{old('password')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">العنوان </label>
                                                        <input type="text" id="projectinput1" class="form-control"  placeholder="ادخل عنوان المدرب" name="address" value="{{old('address')}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
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
        $(".trainer").change(function(){
            if($(this).val() == 'user'){
                $('#permiossn').show()
            }else{
                $('#permiossn').hide()
            }
        });


    </script>
@endsection
