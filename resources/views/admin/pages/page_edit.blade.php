@extends('admin/layouts.master')
@section('title', 'Edit Page - Admin')
@section('body')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"> {{ __('adminstaticword.Edit') }} - {!! $find->title !!}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <form id="demo-form2" method="post" action="{{url('page/'.$find->id)}}"
                                  data-parsley-validate class="form-horizontal form-label-left"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{method_field('PATCH')}}

                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="exampleInputName">{{ __('adminstaticword.Title') }}:</label>
                                        <input type="text" class="form-control" name="title" id="exampleInputTitle"
                                               value="{{$find->title}}">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="exampleInputSlug">{{ __('adminstaticword.Slug') }}:</label>
                                        <input type="text" class="form-control" name="slug" id="exampleInputPassword1"
                                               value="{{$find->slug}}">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.Status') }}:</label>
                                        <li class="tg-list-item">
                                            <input class="tgl tgl-skewed" id="cb10"
                                                   type="checkbox" {{ $find->status==1 ? 'checked' : '' }}>
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                   for="cb10"></label>
                                        </li>
                                        <input type="hidden" name="status" value="{{ $find->status }}" id="j">
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputDetails">{{ __('adminstaticword.Detail') }}:</label>
                                        <textarea name="details" rows="5" id="editor2"
                                                  class="form-control">{{$find->details}}</textarea>
                                    </div>
                                </div>
                                <br>

                                <div class="box-footer">
                                    <button type="submit"
                                            class="btn btn-md col-md-2 btn-primary">{{ __('adminstaticword.Save') }}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('scripts')

    <script>
        tinymce.init({
            selector: '#editor1,#editor2,.editor',
            height: 350,
            menubar: 'edit view insert format tools table tc',
            autosave_ask_before_unload: true,
            autosave_interval: "30s",
            autosave_prefix: "{path}{query}-{id}-",
            autosave_restore_when_empty: false,
            autosave_retention: "2m",
            image_advtab: true,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks fullscreen',
                'insertdatetime media table paste wordcount'
            ],
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media  template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
            content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
    </script>
@endsection
