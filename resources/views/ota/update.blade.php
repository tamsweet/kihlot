<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('installer/css/shards.min.css') }}">
    <link rel="stylesheet" href="{{url('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ url('installer/css/custom.css') }}">
    
    <title>{{ __('-|| Updater ||-') }}</title>

</head>

<body>
    @include('admin.message')
    @include('sweetalert::alert')
   

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="m-3 text-center text-dark ">
                    {{ __('Welcome To Update Wizard') }}
                </h3>
            </div>
            <div class="card-body" id="stepbox">
                <form autocomplete="off" action="{{ route('update.proccess') }}" id="updaterform" method="POST"
                    class="needs-validation" novalidate>
                    @csrf
                    <blockquote class="text-justify text-dark font-weight-normal">
                        <p class="font-weight-bold text-primary"><i class="fa fa-check-circle"></i> Before update make
                            sure you take your database backup and script backup from server so in case if anything goes
                            wrong you can restore it.</p>
                        <hr>
                        
                        <p>Before update make sure you read this <b>FAQ.</b></p>
                        <ul>
                            <li><b>Q.</b> Will This Update affect my existing data eg. product data, orders?
                                <br>
                                <b>Answer:</b> No it will not affect your existing .
                            </li>
                            <br>
                            
                            <li><b>Q.</b> Will This Update affect my customization eg. in <b>CSS,JS or in Core code</b>
                                ?
                                <br>
                                <b>Answer:</b> Yes it will affect your changes if you did changes in code files <br> If you customize <B>CSS or JS</B> using <b>Admin -> Custom Style Setting</b> Than all your change will not affect else it will affect.
                            </li>
                        </ul>


                    </blockquote>
                    <hr>
                    <div class="custom-control custom-checkbox">
                        <input required="" type="checkbox" class="custom-control-input" id="customCheck1" name="eula" />
                        <label class="custom-control-label"
                            for="customCheck1"><b>{{ __('I read the update procedure carefully and I take backup already.') }}</b></label>
                    </div>
                    <small class="font-weight-normal text-center">
                        <a target="__blank"
                            href="https://codecanyon.net/item/eclass-learning-management-system/25613271">Read
                            complete changelog of update by clicking here.</a>
                    </small>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <button class="updatebtn btn btn-primary" type="submit">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center m-3 text-white">&copy;{{ date('Y') }} | {{ __('eclass Updater') }} | <a class="text-white"
                href="http://mediacity.co.in">{{ __('Mediacity') }}</a></p>
    </div>

    <div class="corner-ribbon bottom-right sticky green shadow">{{ __('Updater') }} </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ url('installer/js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ url('installer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('installer/js/additional-methods.min.js') }}"></script>
    <!-- Essential JS UI widget -->
    <script src="{{ url('installer/js/ej.web.all.min.js') }}"></script>
    <script src="{{ url('installer/js/popper.min.js') }}"></script>
    <script src="{{ url('installer/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('installer/js/shards.min.js') }}"></script>
    <script>
        var baseUrl = "<?= url('/') ?>";
    </script>
    <script src="{{ url('js/minstaller.js') }}"></script>
    <script>
        $("#updaterform").on('submit', function () {

            if ($(this).valid()) {
                $('.updatebtn').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> Updating...');
            }

        });
    </script>
</body>

</html>