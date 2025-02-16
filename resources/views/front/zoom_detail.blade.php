@extends('theme.master')
@section('title', "$zoom->meeting_title")
@section('content')

    @include('admin.message')
    <!-- course detail header start -->
    <section id="about-home" class="about-home-main-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="about-home-block text-white">
                        <h1 class="about-home-heading text-white">{{ $zoom['meeting_title'] }}</h1>
                        <ul>

                            <ul>
                                <li><a href="#" title="about">{{ __('frontstaticword.Created') }}
                                        : {{ $zoom->user['fname'] }} </a></li>

                                @if($zoom->type != '3')
                                    <li><a href="#" title="about">Start
                                            At: {{ date('d-m-Y | h:i:s A',strtotime($zoom['start_time'])) }}</a></li>
                                @endif

                            </ul>
                    </div>
                </div>
                <!-- course preview -->
                <div class="col-lg-4">


                    <div class="about-home-product">
                        <div class="video-item hidden-xs">

                            <div class="video-device">
                                <img src="{{ Avatar::create($zoom['meeting_title'])->toBase64() }}"
                                     class="bg_img img-fluid" alt="Background">
                            </div>
                        </div>


                        <div class="about-home-dtl-training">
                            <div class="about-home-dtl-block btm-10">

                                <div class="about-home-btn btm-20">
                                    <a href="{{ $zoom->zoom_url }}" target="_blank" class="btn btn-secondary">Join
                                        Meeting</a>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- course header end -->
    <!-- course detail start -->
    <section id="about-product" class="about-product-main-block">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="requirements">
                        <h3>{{ __('frontstaticword.Agenda') }}</h3>
                        <ul>
                            <li class="comment more">

                                {!! $zoom->agenda !!}

                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- course detail end -->
@endsection

