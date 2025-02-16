@section('title', 'Class')
@include('theme.head')
@include('admin.message')

<body>

<section id="class-nav" class="class-nav-block">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="class-logo">

                    <a href="{{ url('/') }}" title="logo"><img src="{{ asset('images/favicon/'.$gsetting->favicon) }}"
                                                               class="img-fluid" alt="logo"></a>
                </div>
                @php
                    $courses = App\Course::where('id', $course)->first();
                @endphp
                <div class="class-nav-heading">{{ $courses->title }}</div>
            </div>
            <div class="col-lg-3">
                <div class="class-button">
                    <ul>
                        <li>
                            <a href="{{ route('mycourse.show') }}" class="course_btn"> <i
                                    class="fa fa-chevron-left"></i>{{ __('frontstaticword.MyCourses') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('user.course.show',['id' => $courses->id, 'slug' => $courses->slug ]) }}"
                               class="course_btn"> {{ __('frontstaticword.Coursedetails') }} <i
                                    class="fa fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="iframe-video" class="iframe-video-class">
    <div class="body">
        <div style="left: 0; width: 100%; height: 0; position: relative; padding-bottom: 56.25%;">
            <iframe src="{{ $url.'?modestbranding=1' }}"
                    style="border: 0; top: 0; left: 0; width: 100%; height: 100%; position: absolute;" allowfullscreen
                    scrolling="no" allow="encrypted-media">

            </iframe>
        </div>
    </div>
</section>


<!-- jquery -->
@include('theme.scripts')
<!-- end jquery -->
</body>
<!-- body end -->
</html>
