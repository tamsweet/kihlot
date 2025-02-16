<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/colorbox.js') }}"></script> <!-- colorbox js -->
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<script
    src="{{ url('vendor/counter/waypoints.min.js') }}"></script> <!-- facts count js required for jquery.counterup.js file -->
<script src="{{ url('vendor/counter/jquery.counterup.js') }}"></script> <!-- facts count js-->
<?php
$language = Session::get('changed_language'); //or 'english' //set the system language
$rtl = array('ar', 'he', 'ur', 'arc', 'az', 'dv', 'ku', 'fa'); //make a list of rtl languages
?>
@if (in_array($language,$rtl))
    <script src="{{ url('vendor/owl/js/owl.carouselrtl.min.js') }}"></script> <!-- owl carousel js -->
@else
    <script src="{{ url('vendor/owl/js/owl.carousel.min.js') }}"></script> <!-- owl carousel js -->
@endif
<script src="{{ url('vendor/smoothscroll/smooth-scroll.js') }}"></script> <!-- smooth scroll js -->
<script src="{{ url('vendor/popup/jquery.magnific-popup.min.js')}}"></script> <!-- popup js-->
<script src="{{ url('vendor/navigation/menumaker.js') }}"></script> <!-- navigation js-->
<script src="{{ url('vendor/mailchimp/jquery.ajaxchimp.js') }}"></script> <!-- mail chimp js -->
<script src="{{ url('vendor/protip/protip.js') }}"></script> <!-- protip js -->
<script src="{{ url('js/theme.js') }}"></script> <!-- custom js -->
<script src="{{ url('js/FWDUVPlayer.js') }}"></script> <!-- player js -->
<script src="{{ url('js/jquery.owl-filter.js') }}"></script> <!-- filter js -->
<script src="{{ url('js/fontawesome-iconpicker.js')}}"></script><!-- iconpicker js -->
<script src="{{ url('js/tinymce.min.js')}}"></script>
<script src="{{ url('js/protip.js') }}"></script> <!-- protip js -->
<script src="{{ url('js/select2.min.js') }}"></script> <!-- select2 -->
<script src="{{ URL::asset('js/pace.min.js') }}"></script>
<script src="{{ url('js/custom-js.js')}}"></script>

<script src="{{ asset('js/share.js') }}"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="{{ url('js/sweetalert2@9.js')}}"></script>


<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gsetting->google_ana }}"></script>

<script src="{{ asset('js/venom-button.min.js') }}"></script>


@if(isset($gsetting->chat_bubble))
    <script src="{{ $gsetting->chat_bubble }}" async></script>
@endif

<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', '{{ $gsetting->google_ana }}');
</script>

@if($gsetting->rightclick=='1')
    <script>
        (function ($) {
            "use strict";
            $(function () {
                $(document).on("contextmenu", function (e) {
                    return false;
                });
            });
        })(jQuery);
    </script>
@endif
@if($gsetting->inspect=='1')
    <script>
        (function ($) {
            "use strict";
            document.onkeydown = function (e) {
                if (event.keyCode == 123) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
                    return false;
                }
                if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
                    return false;
                }
            }
        })(jQuery);
    </script>
@endif

<script>

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('{{ url('sw.js') }}')
                .then((reg) => {
                    console.log('Service worker registered.', reg);
                });
        });
    }
</script>


<script>
    $('.prime-cat').on('click', function () {

        var url = $(this).data('url');

        location.href = url;

    });

    $('.sub-cate').on('click', function () {

        var url = $(this).data('url');

        location.href = url;

    });

    $('.child-cate').on('click', function () {

        var url = $(this).data('url');

        location.href = url;

    });
</script>


@if($gsetting->wapp_enable=='1')
    <script type="text/javascript">

        $('#myButton').venomButton({
            phone: '{{ $gsetting->wapp_phone }}',
            popupMessage: '{{ $gsetting->wapp_popup_msg }}',
            message: "",
            showPopup: true,
            position: "{{ $gsetting->wapp_position }}",
            linkButton: false,
            showOnIE: false,
            headerTitle: '{{ $gsetting->wapp_title }}',
            headerColor: '{{ $gsetting->wapp_color }}',
            backgroundColor: '#25d366',
            zIndex: 999999999999,
            buttonImage: '<img src="{{ asset('images/icons/whatsapp.svg') }}" />'
        });

    </script>

@endif



@yield('custom-script')
