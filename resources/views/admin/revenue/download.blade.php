<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2019.
**********************************************************************************************************  -->
<!--
Template Name: NextClass
Version: 1.0.0
Author: Media City
-->
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<html lang="en">
<!-- <![endif]-->
<!-- head -->
<!-- theme styles -->
<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
<link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css"/> <!-- custom css -->
<!-- google fonts -->

<!-- end theme styles -->
</head>


<!-- end head -->
<!-- body start-->
<body>
<!-- terms end-->
<!-- about-home start -->
<section id="wishlist-home" class="invoice-home-main-block ">
    <div class="container-fluid">
        <h1>{{ __('frontstaticword.Invoice') }}</h1>
    </div>
</section>
<!-- about-home end -->
<section id="purchase-block" class="Invoice-main-block">
    <div class="container-fluid">
        <div class="panel-body">

            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-header">
                        @php
                            $setting = App\setting::first();
                        @endphp
                        <div class="download-logo">
                            @if($setting['logo_type'] == 'L')
                                <img src="{{ asset('images/logo/'.$setting['logo']) }}" class="img-fluid" alt="logo">
                            @else()
                                <a href="{{ url('/') }}"><b>
                                        <div class="logotext">{{ $setting['project_title'] }}</div>
                                    </b></a>
                            @endif
                        </div>
                        <br>
                        <small class="purchase-date">{{ __('frontstaticword.Puchasedon') }}
                            : {{ date('jS F Y', strtotime($payout['created_at'])) }}</small>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="view-order">
                <table class="table table-striped">
                    <thead>
                    <th class="col-sm-4 invoice-col">
                        From:
                        <address>
                            <strong>{{ $payout->payer['fname'] }}</strong><br>


                            {{ __('frontstaticword.address') }}: {{ $payout->payer['address'] }}<br>
                            @if($payout->payer->state_id == !NULL)
                                {{ $payout->payer->state['name'] }},
                            @endif
                            @if($payout->payer->country_id == !NULL)
                                {{ $payout->payer->country['name'] }}
                            @endif
                            <br>

                            {{ __('frontstaticword.Phone') }}: {{ $payout->payer['mobile'] }}<br>
                            {{ __('frontstaticword.Email') }}: {{ $payout->payer['email'] }}
                        </address>

                    </th>
                    <!-- /.col -->
                    <th class="col-sm-4 invoice-col">
                        To:
                        <address>
                            <strong>{{ $payout->user['fname'] }}</strong><br>
                            {{ __('frontstaticword.address') }}: {{ $payout->user['address'] }}<br>
                            @if($payout->user->state_id == !NULL)
                                {{ $payout->user->state['name'] }},
                            @endif
                            @if($payout->user->country_id == !NULL)
                                {{ $payout->user->country['name'] }}
                            @endif
                            <br>
                            {{ __('frontstaticword.Phone') }}: {{ $payout->user['mobile'] }}<br>
                            {{ __('frontstaticword.Email') }}: {{ $payout->user['email'] }}
                        </address>
                    </th>
                    <!-- /.col -->
                    <th class="col-sm-4 invoice-col">
                        <b>{{ __('frontstaticword.OrderID') }}:</b>
                        @foreach($payout->order_id as $order)
                            @php
                                $id= App\Order::find($order);
                            @endphp
                            {{ $id['order_id'] }},

                        @endforeach<br>
                        <b>{{ __('frontstaticword.PaymentMode') }}:</b> {{ $payout['payment_method'] }}<br>
                        <b>{{ __('frontstaticword.Currency') }}:</b> {{ $payout['currency'] }}</br>
                        <b>{{ __('frontstaticword.PaymentStatus') }}:</b>
                        @if($payout->pay_status ==1)
                            {{ __('frontstaticword.Recieved') }}
                        @else
                            {{ __('frontstaticword.Pending') }}
                        @endif
                    </th>
                    </thead>
                </table>

            </div>
            <!-- /.row -->
            <div class="order-table table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{ __('adminstaticword.Instructor') }}</th>
                        <th>{{ __('adminstaticword.Currency') }}</th>

                        <th>{{ __('adminstaticword.Total') }}</th>
                        <th>{{ __('adminstaticword.PaymentMethod') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $payout->user['fname'] }}</td>
                        <td>{{ $payout['currency'] }}</td>
                        <td><i class="fa {{ $payout['currency_icon'] }}"></i>{{ $payout['pay_total'] }}</td>
                        <td>{{ $payout->payment_method }}</td>


                        </td>
                    </tr>
                    </tbody>
                </table>


            </div>
        </div>

    </div>
    </div>
</section>
<!-- footer start -->

<!-- footer end -->
<!-- jquery -->
<script src="{{ url('js/jquery-2.min.js') }}"></script> <!-- jquery library js -->
<script src="{{ url('js/bootstrap.bundle.js') }}"></script> <!-- bootstrap js -->
<!-- end jquery -->
</body>
<!-- body end -->
</html>



