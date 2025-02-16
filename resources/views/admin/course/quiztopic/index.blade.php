<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <a data-toggle="modal" data-target="#myModaltopic" href="#"
               class="btn btn-info btn-sm">+ {{ __('adminstaticword.Add') }}</a>

            <div class="table-responsive">

                <table id="example1" class="table table-bordered table-striped">

                    <thead>
                    <br>
                    <br>
                    <th>#</th>
                    <th>{{ __('adminstaticword.Question') }}</th>
                    <th>{{ __('adminstaticword.Marks') }}</th>
                    <th>{{ __('adminstaticword.Status') }}</th>
                    <th>{{ __('adminstaticword.Reattempt') }}</th>
                    <th>{{ __('adminstaticword.DueDays') }}</th>
                    <th>{{ __('adminstaticword.Action') }}</th>
                    </thead>
                    <tbody>
                    <?php $i = 0;?>
                    @foreach($topics as $topic)
                        <tr>
                            <?php $i++;?>
                            <td><?php echo $i;?></td>
                            <td>{{$topic->title}}</td>
                            <td>{{$topic->per_q_mark}}</td>

                            <td>
                                @if($topic->status==1)
                                    {{ __('adminstaticword.Active') }}
                                @else
                                    {{ __('adminstaticword.Deactive') }}
                                @endif
                            </td>
                            <td>
                                @if($topic->quiz_again==1)
                                    {{ __('adminstaticword.Yes') }}
                                @else
                                    {{ __('adminstaticword.No') }}
                                @endif
                            </td>
                            <td>

                                @if($topic->due_days)
                                    {{$topic->due_days}}
                                @else
                                    -
                                @endif
                            </td>

                            <td>


                                <div class="btn-group">
                                    <button type="button" class="btn btn-default">Action</button>
                                    <button type="button" class="btn btn-default dropdown-toggle"
                                            data-toggle="dropdown">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{url('admin/quiztopic/'.$topic->id)}}">Edit</a></li>
                                        <li><a href="{{route('answersheet', $topic->id)}}">Delete Answer</a></li>
                                        <li><a href="{{route('questions.show', $topic->id)}}">Add Question</a></li>
                                        <li><a href="{{route('show.quizreport', $topic->id)}}">Show Report</a></li>
                                        <li class="divider"></li>
                                        <li>
                                            <form method="post" action="{{url('admin/quiztopic/'.$topic->id)}}"
                                                  data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>


        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!--Model start-->
    <div class="modal fade" id="myModaltopic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"
                        id="myModalLabel"> {{ __('adminstaticword.Add') }} {{ __('adminstaticword.Quiz') }}</h4>
                </div>
                <div class="box box-primary">
                    <div class="panel panel-sum">
                        <div class="modal-body">
                            <form id="demo-form2" method="post" action="{{url('admin/quiztopic/')}}"
                                  data-parsley-validate class="form-horizontal form-label-left">
                                {{ csrf_field() }}

                                <input type="hidden" name="course_id" value="{{ $cor->id }}"/>


                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.QuizTopic') }}:<span
                                                class="redstar">*</span> </label>
                                        <input type="text" placeholder="Enter Quiz Topic" class="form-control "
                                               name="title" id="exampleInputTitle" value="">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputDetails">{{ __('adminstaticword.QuizDescription') }}
                                            :<sup class="redstar">*</sup></label>
                                        <textarea name="description" rows="3" class="form-control"
                                                  placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.Marks') }}:<span
                                                class="redstar">*</span> </label>
                                        <input type="number" placeholder="Enter Per Question Mark" class="form-control "
                                               name="per_q_mark" id="exampleInputTitle" value="">
                                    </div>
                                </div>
                                <br>


                                <div class="row display-none">
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.QuizTimer') }}:<span
                                                class="redstar">*</span> </label>
                                        <input type="text" placeholder="Enter Quiz Time" class="form-control"
                                               name="timer" id="exampleInputTitle" value="1">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.Days') }}:</label>
                                        <small>(Days after quiz will start when user enroll in course)</small>
                                        <input type="text" placeholder="Enter Due Days" class="form-control"
                                               name="due_days" id="exampleInputTitle">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="exampleInputDetails">{{ __('adminstaticword.Status') }}:</label>
                                        <li class="tg-list-item">
                                            <input class="tgl tgl-skewed" id="c18" name="status" type="checkbox"/>
                                            <label class="tgl-btn" data-tg-off="Deactive" data-tg-on="Active"
                                                   for="c18"></label>
                                        </li>
                                        <input type="hidden" name="free" value="1" id="t18">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="exampleInputTit1e">{{ __('adminstaticword.QuizReattempt') }}
                                            :</label>
                                        <li class="tg-list-item">
                                            <input class="tgl tgl-skewed" id="111" type="checkbox" name="quiz_again">
                                            <label class="tgl-btn" data-tg-off="Disable" data-tg-on="Enable"
                                                   for="111"></label>
                                        </li>
                                        <input type="hidden" name="free" value="0" for="status" id="13">
                                    </div>
                                </div>
                                <br>

                                <div class="box-footer">
                                    <button type="submit" value="Add Answer" class="btn btn-md col-md-3 btn-primary">
                                        + {{ __('adminstaticword.Save') }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Model close -->
</section>
