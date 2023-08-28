@extends('Dashboard.includes.admin')

@section('content')

    <div class="app-content content vue-app">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">قسم الموظفين</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a >لوحة التحكم</a></li>
                                <li class="breadcrumb-item"><a > الموظفين</a></li>
                                <li class="breadcrumb-item active">اضافة موظف</li>
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
                                <h4 class="card-title" id="bordered-layout-card-center">اضافة موظف جديد</h4>
                                <a href="/sat/courses/create.php" class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            </div>
                            <div class="card-content collpase show">
                                <div class="card-body">

                                    <img src="{{asset($user->image) ?? "----"}}"  style="max-width: 200px; float: left"  class="rounded-circle" alt="">
                                    <form class="form" action="{{route('employee.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        @include('Dashboard.includes.alerts.errors')


                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">اسم الموظف</label>
                                                        <input type="text" id="projectinput1" class="form-control" required placeholder="ادخل اسم الموظف" name="name" value="{{$user->name}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">قسم الموظف</label>
                                                        <select class="employee form-control text-left" required name="role" value="{{old('role')}}">
                                                            <option value="" onclick="admin_emp()">اختر</option>
                                                            <option  @if($user->hasRole('Administrator') || $user->hasRole('superadministrator')) selected   @endif  value="Administrator" onclick="admin_emp()">ادمن</option>
                                                            <option  @if($user->hasRole('user')) selected   @endif value="user" id="employee" >موظف</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">البريد الإلكتروني</label>
                                                        <input type="email" id="projectinput1" class="form-control" required placeholder="ادخل البريد الإلكتروني" name="email"  value="{{$user->email}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">كلمه السر </label>
                                                        <input type="text" id="projectinput3" rows="20" class="form-control"  placeholder="كلمه السر" name="password" value="{{ ($user->password_unhash) }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> تاريخ الميلاد</label>
                                                        <input type="date"  class="form-control"   placeholder="dd-mm-yyyy"
                                                               min="1910-01-01" max="2030-12-31" name="birth_day"  value="{{$user->birth_day->format('Y-m-d') }}" />
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"> الرقم القومي </label>
                                                        <input type="number" class="form-control"  placeholder="الرقم القومي" name="national_id"  value="{{$user->national_id}}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> شهاده التخرج</label>
                                                        <input type="text" class="form-control"  placeholder="   ادخل شهاده التخرج" name="degree" value="{{$user->degree}}"  />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"> الحاله العسكريه </label>
                                                        <input type="text"  rows="20" class="form-control"  placeholder="الحاله العسكريه " name="military_status" value="{{$user->military_status}}"  />
                                                    </div>
                                                </div>



                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="projectinput3">  صوره شخصيه  </label>
                                                        <input type="file"  rows="20" class="form-control"   name="image" value="{{old('image')}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            <h4 class="form-section">
                                                <i class="ft-clipboard"></i>
                                                الاوراق المطلوبه
                                            </h4>
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <label for=""> 2 صورة شخصية</label>
                                                    <input class="form-control" type="checkbox"  @if($user->personal_image=="1") checked @endif name="personal_image" id="" value="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for=""> صورة بطاقة</label>
                                                    <input class="form-control" type="checkbox" name="national_image"  @if($user->national_image=="1") checked @endif id="" value="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">شهادة ميلاد</label>
                                                    <input class="form-control" type="checkbox"  @if($user->birth_certificate=="1") checked @endif name="birth_certificate" id="" value="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">شهادة المؤهل</label>
                                                    <input class="form-control" type="checkbox"  @if($user->degree_certificate=="1") checked @endif name="degree_certificate" id="" value="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="">شهادة تجنيد</label>
                                                    <input class="form-control" type="checkbox"  @if($user->army_certificate=="1") checked @endif name="army_certificate" id="" value="1">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for=""> فيش</label>
                                                    <input class="form-control" type="checkbox"  @if($user->feish=="1") checked @endif name="feish" id="" value="1">
                                                </div>
                                            </div>
                                            <hr class="form-group">
                                            </div>
                                            <div class="row" id="permiossn" style="display: none;">
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الفروع</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('branches-create')) checked  @endif value="branches-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('branches-update')) checked  @endif value="branches-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox" @if($user->hasPermission('branches-read')) checked  @endif value="branches-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="sports[]" type="checkbox" @if($user->hasPermission('branches-delete')) checked  @endif value="branches-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الالعاب</h5>

                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('sports-create')) checked  @endif value="sports-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('sports-update')) checked  @endif value="sports-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('sports-read')) checked  @endif  value="sports-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('sports-delete')) checked  @endif  value="sports-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <h5 for=""> المستويات </h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('levels-create')) checked  @endif value="levels-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('levels-update')) checked  @endif value="levels-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('levels-read')) checked  @endif value="levels-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('levels-delete')) checked  @endif value="levels-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="checkbox">
                                                        <h5 for="">قائمه الاسعار</h5>

                                                        <label><input name="permession[]" type="checkbox" @if($user->hasPermission('price-list-create')) checked  @endif value="price-list-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox" @if($user->hasPermission('price-list-update')) checked  @endif value="price-list-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('price-list-read')) checked  @endif value="price-list-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox" @if($user->hasPermission('price-list-delete')) checked  @endif value="price-list-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الباكدج</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-create')) checked  @endif value="package-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('package-update')) checked  @endif value="package-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-read')) checked  @endif value="package-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-delete')) checked  @endif value="package-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">العقود</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-create')) checked  @endif value="contracts-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('contracts-update')) checked  @endif value="contracts-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-read')) checked  @endif value="contracts-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-delete')) checked  @endif value="contracts-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">عقود الشركاء</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-partners-create')) checked  @endif value="contracts-partners-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('contracts-partners-update')) checked  @endif value="contracts-partners-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-partners-read')) checked  @endif value="contracts-partners-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('contracts-partners-delete')) checked  @endif value="contracts-partners-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الاعبين</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('players-create')) checked  @endif value="players-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('players-update')) checked  @endif value="players-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('players-read')) checked  @endif value="players-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('players-delete')) checked  @endif value="players-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الانشاطه</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('activity-create')) checked  @endif value="activity-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('activity-update')) checked  @endif value="activity-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('activity-read')) checked  @endif value="activity-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('activity-delete')) checked  @endif value="activity-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">ايصالات التوريد</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Incoming-receipts-create')) checked  @endif value="Incoming-receipts-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('Incoming-receipts-update')) checked  @endif value="Incoming-receipts-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Incoming-receipts-read')) checked  @endif value="Incoming-receipts-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Incoming-receipts-delete')) checked  @endif value="Incoming-receipts-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">ايصالات الصرف</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Exchange-receipts-create')) checked  @endif value="Exchange-receipts-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('Exchange-receipts-update')) checked  @endif value="Exchange-receipts-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Exchange-receipts-read')) checked  @endif value="Exchange-receipts-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Exchange-receipts-delete')) checked  @endif value="Exchange-receipts-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">انواع الايصالات</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('type-receipts-create')) checked  @endif value="type-receipts-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('type-receipts-update')) checked  @endif value="type-receipts-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('type-receipts-read')) checked  @endif value="type-receipts-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('type-receipts-delete')) checked  @endif value="type-receipts-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">العهده</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('custody-create')) checked  @endif value="custody-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('custody-update')) checked  @endif value="custody-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('custody-read')) checked  @endif value="custody-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('custody-delete')) checked  @endif value="custody-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">تسويات العهده</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('settlements-create')) checked  @endif value="settlements-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('settlements-update')) checked  @endif value="settlements-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('settlements-read')) checked  @endif value="settlements-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('settlements-delete')) checked  @endif value="settlements-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الخصومات</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('deductions-create')) checked  @endif value="deductions-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('deductions-update')) checked  @endif value="deductions-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('deductions-read')) checked  @endif value="deductions-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('deductions-delete')) checked  @endif value="deductions-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">حضور الاعبين</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-players-create')) checked  @endif value="Attendance-players-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('Attendance-players-update')) checked  @endif value="Attendance-players-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-players-read')) checked  @endif value="Attendance-players-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-players-delete')) checked  @endif value="Attendance-players-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">حضور المدربين</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-trainers-create')) checked  @endif value="Attendance-trainers-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('Attendance-trainers-update')) checked  @endif value="Attendance-trainers-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-trainers-read')) checked  @endif value="Attendance-trainers-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('Attendance-trainers-delete')) checked  @endif value="Attendance-trainers-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">الملاعب</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-create')) checked  @endif value="stadiums-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('stadiums-update')) checked  @endif value="stadiums-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-read')) checked  @endif value="stadiums-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-delete')) checked  @endif value="stadiums-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">ايجار الملاعب و الصالات</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-rent-create')) checked  @endif value="stadiums-rent-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('stadiums-rent-update')) checked  @endif value="stadiums-rent-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-rent-read')) checked  @endif value="stadiums-rent-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('stadiums-rent-delete')) checked  @endif value="stadiums-rent-delete" />حذف</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <div class="checkbox">
                                                        <h5 for="">المسابقات</h5>
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('tournament-create')) checked  @endif value="tournament-create" />انشاء</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('tournament-update')) checked  @endif value="tournament-update" />تعديل</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('tournament-read')) checked  @endif value="tournament-read" />عرض</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('tournament-delete')) checked  @endif value="tournament-delete" />حذف</label>
                                                    </div>
                                                </div>
{{--                                                <div class="col-md-3 mb-3">--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <h5 for="">الباكدج</h5>--}}
{{--                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-create')) checked  @endif value="package-create" />انشاء</label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <label><input name="permession[]" type="checkbox"   @if($user->hasPermission('package-update')) checked  @endif value="package-update" />تعديل</label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-read')) checked  @endif value="package-read" />عرض</label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="checkbox">--}}
{{--                                                        <label><input name="permession[]" type="checkbox"  @if($user->hasPermission('package-delete')) checked  @endif value="package-delete" />حذف</label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                {{--                                                <div class="col-md-3">--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <h5 for="">الطلاب</h5>--}}

                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="students-create" />انشاء</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="students-update" />تعديل</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="students-read" />عرض</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="students-delete" />حذف</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-md-3">--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <h5 for="">طلابات الطلابه</h5>--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="student-requests-create" />انشاء</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="student-requests-update" />تعديل</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="student-requests-read" />عرض</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="student-requests-delete" />حذف</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="col-md-3">--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <h5 for="">الفيزا</h5>--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="visas-create" />انشاء</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="visas-update" />تعديل</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="visas-read" />عرض</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                    <div class="checkbox">--}}
                                                {{--                                                        <label><input name="permession[]" type="checkbox" value="visas-delete" />حذف</label>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
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
        showPermissions()
        $(".employee").change(function(){
            showPermissions()
        });
        function showPermissions(){
            if($(".employee").val() == 'user'){
                $('#permiossn').show()
            }else{
                $('#permiossn').hide()
            }
        }
    </script>
@endsection
