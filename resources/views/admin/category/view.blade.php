@extends('admin/layouts.master')
@section('title', 'View Category - Admin')
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
        @include('admin.message')
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ __('adminstaticword.Category') }}</h3>
                    </div>
                    <div class="box-header">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">
                            + {{ __('adminstaticword.Add') }}
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"
                                            id="myModalLabel">{{ __('adminstaticword.AddCategory') }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <form id="demo-form2" method="post" action="{{url('category/')}}"
                                              data-parsley-validate class="form-horizontal form-label-left"
                                              autocomplete="off" enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="c_name">{{ __('adminstaticword.Name') }}:<sup
                                                            class="redstar">*</sup></label>
                                                    <input placeholder="Enter your category" type="text"
                                                           class="form-control" name="title" required="">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="icon">{{ __('adminstaticword.Icon') }}:<sup
                                                            class="redstar">*</sup></label>
                                                    <input type="text" class="form-control icp-auto icp" name="icon"
                                                           required placeholder="Choose Icon">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label
                                                        for="exampleInputDetails">{{ __('adminstaticword.Featured') }}
                                                        :</label>
                                                    <li class="tg-list-item">
                                                        <input class="tgl tgl-skewed" id="featured" type="checkbox"
                                                               name="featured">
                                                        <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                                               for="featured"></label>
                                                    </li>
                                                    <input type="hidden" name="free" value="0" for="featured"
                                                           id="featured">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}
                                                        :</label>
                                                    <li class="tg-list-item">
                                                        <input class="tgl tgl-skewed" id="status" type="checkbox"
                                                               name="status">
                                                        <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                                               for="status"></label>
                                                    </li>
                                                    <input type="hidden" name="free" value="0" for="status" id="status">


                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>{{ __('adminstaticword.PreviewImage') }}:</label> - <p
                                                        class="inline info">size: 250x150</p>
                                                    <br>
                                                    <input type="file" name="image" id="image"
                                                           class="inputfile inputfile-1"/>
                                                    <label for="image">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17"
                                                             viewBox="0 0 20 17">
                                                            <path
                                                                d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                                        </svg>
                                                        <span>{{ __('adminstaticword.Chooseafile') }}&hellip;</span></label>

                                                </div>
                                            </div>

                                            <br>
                                            <button type="submit"
                                                    class="btn btn-primary">{{ __('adminstaticword.Save') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('adminstaticword.Image') }}</th>
                                    <th>{{ __('adminstaticword.Category') }}</th>
                                    <th>{{ __('adminstaticword.Icon') }}</th>
                                    <th>{{ __('adminstaticword.Slug') }}</th>
                                    <th>{{ __('adminstaticword.Featured') }}</th>
                                    <th>{{ __('adminstaticword.Status') }}</th>
                                    <th>{{ __('adminstaticword.Edit') }}</th>
                                    <th>{{ __('adminstaticword.Delete') }}</th>
                                </tr>
                                </thead>
                                <tbody id="sortable">
                                <?php $i = 0;?>
                                @foreach($cate as $cat)
                                    <?php $i++;?>
                                    <tr class="sortable" id="id-{{ $cat->id }}">
                                        <td><?php echo $i;?></td>
                                        <td>
                                            @if($cat['cat_image'] !== NULL && $cat['cat_image'] !== '')
                                                <img src="images/category/<?php echo $cat['cat_image'];  ?>"
                                                     class="img-responsive">
                                            @else
                                                <img src="{{ Avatar::create($cat->title)->toBase64() }}"
                                                     class="img-responsive">
                                            @endif
                                        </td>
                                        <td>{{$cat->title}}</td>
                                        <td><i class="fa {{$cat->icon}}"></i></td>
                                        <td>{{$cat->slug}}</td>
                                        <td>
                                            <form action="{{ route('categoryf.quick',$cat->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="Submit"
                                                        class="btn btn-xs {{ $cat->featured ==1 ? 'btn-success' : 'btn-danger' }}">
                                                    @if($cat->featured ==1)
                                                        {{ __('adminstaticword.Yes') }}
                                                    @else
                                                        {{ __('adminstaticword.No') }}
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('category.quick',$cat->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                <button type="Submit"
                                                        class="btn btn-xs {{ $cat->status ==1 ? 'btn-success' : 'btn-danger' }}">
                                                    @if($cat->status ==1)
                                                        {{ __('adminstaticword.Active') }}
                                                    @else
                                                        {{ __('adminstaticword.Deactive') }}
                                                    @endif
                                                </button>
                                            </form>
                                        </td>

                                        <td>
                                            <a class="btn btn-success btn-sm" href="{{url('category/'.$cat->id)}}"><i
                                                    class="glyphicon glyphicon-pencil"></i></a></td>
                                        <td>
                                            <form method="post" action="{{url('category/'.$cat->id)}}"
                                                  data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-fw fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        });

        $("#sortable").sortable({
            update: function (e, u) {
                var data = $(this).sortable('serialize');

                $.ajax({
                    url: "{{ route('category_reposition') }}",
                    type: 'get',
                    data: data,
                    dataType: 'json',
                    success: function (result) {
                        console.log(data);
                    }
                });

            }

        });
    </script>

@endsection


