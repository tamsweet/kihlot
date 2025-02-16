@extends('admin/layouts.master')
@section('body')
@section("title","Edit Language")

<section class="content">
    @include('admin.message')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                    <h3 class="box-title"> {{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Language') }}</h3>
                </div>
                <div class="panel-body">


                    <form id="demo-form2" method="post" action="{{route('languages.update',$language->id)}}"
                          data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-md-5">
                                <label for="local">{{ __('adminstaticword.Local') }}:<sup
                                        class="redstar">*</sup></label>
                                <input class="form-control" type="text" name="local" value="{{ $language->local }}"
                                       placeholder="Please enter language local name" required>
                            </div>
                            <div class="col-md-5">
                                <label for="name">{{ __('adminstaticword.Name') }}:<sup class="redstar">*</sup></label>
                                <input type="text" class="form-control" name="name" value="{{ $language->name }}"
                                       id="sub_heading" placeholder="Please enter language name eg:English" required>
                            </div>
                            <div class="col-md-2">
                                <label for="">{{ __('adminstaticword.SetDefault') }}</label>
                                <br>
                                <label class="switch">
                                    <input name="def" {{ $language->def==1 ? "checked" : "" }} type="checkbox"
                                           class="checkbox-switch" id="logo_chk">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <br>


                        <div class="box-footer">
                            <button type="submit"
                                    class="btn btn-md btn-primary">{{ __('adminstaticword.Save') }}</button>
                        </div>


                    </form>
                </div>
                <!-- /.panel body -->
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>

@endsection

