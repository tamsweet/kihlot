@extends('theme.master')
@section('title', 'Refund')
@section('content')

@include('admin.message')

<section id="refund-block" class="refund-main-block">
	<div class="container">
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-4">
					@if($order->courses['preview_image'] !== NULL && $order->courses['preview_image'] !== '')
                    	<a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}"><img src="{{ asset('images/course/'. $order->courses->preview_image) }}" class="img-fluid" alt="course"></a>
                    @else
                    	<a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}"><img src="{{ Avatar::create($order->courses->title)->toBase64() }}" class="img-fluid" alt="course"></a>
                    @endif
                    <br>
                    <br>
                    <div class="purchase-history-course-title">
                        <a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}">{{ $order->courses->title }}</a>
                    </div>

                    

                    
				</div>
				<div class="col-lg-8">
					<h5 class="">{{ __('frontstaticword.RefundPolicy') }}</h5>
					@php
                    	$refund_amt = ($order->total_amount/100)*$policy->amount
                    @endphp

					<div class="refund-policy">
						<ul>
							<li>Order price: {{ $order->total_amount }}</li>
							<li>Refund amount: {{ $refund_amt }}</li>
							<li>Refund Policy: {!! $policy->detail !!}</li>
						</ul>
					</div>
					<br>
					<h5 class="">{{ __('frontstaticword.RefundRequest') }}</h5>

					<div class="purchase-history-course-title">
                        <a href="{{ route('user.course.show',['id' => $order->courses->id, 'slug' => $order->courses->slug ]) }}">{{ $order->courses->title }}</a>
                    </div>
                    <br>


                    @php
                        $order_id = Crypt::encrypt($order->id);
                    @endphp


                    <form action="{{ route('refund.request',$order_id) }}" method="POST" enctype="multipart/form-data">
		        	{{ csrf_field() }}
		            {{ method_field('POST') }}


		            	<input type="hidden" name="user_id"  value="{{Auth::User()->id}}" />
					    <input type="hidden" name="course_id"  value="{{$order->courses->id}}" />
					    <input type="hidden" name="course_id"  value="{{$order->order_id}}" />
					    <input type="hidden" name="ammount"  value="{{$order->total_amount}}" />
					    <input type="hidden" name="payment_method"  value="{{$order->payment_method}}" />

	                    <div class="form-group">
	                        <label for="name">{{ __('frontstaticword.Reason') }}</label>
	                        <input type="text" id="reason" name="reason" class="form-control" placeholder="Enter Reason">
	                    </div>

	                    <div class="form-group">
	                        <label for="bio">{{ __('frontstaticword.Detail') }}</label>
	                        <textarea id="detail" name="detail" rows="4" class="form-control" placeholder="Enter Detail" value=""></textarea>
	                    </div>

	                    <div class="form-group">
                            <label for="city_id">{{ __('frontstaticword.Choosemodeofrefund') }}:</label>
			                <select id="country_id" class="form-control js-example-basic-single" name="country_id">
			                  	<option value="none" selected disabled hidden> 
			                      {{ __('frontstaticword.SelectanOption') }}
			                    </option>
			                  
			                 
			                    <option value="original" >Original Source</option>
			                    <option value="bank" >Bank Transfer</option>
			                </select>
                        </div>
	                    

	                    <div class="mark-read-button txt-rgt">
                            <button type="submit" class="btn btn-md btn-primary">
                                {{ __('frontstaticword.RefundRequest') }}
                            </button>
                        </div>

                    </form>


				</div>
			</div>
		</div>
	</div>
</section>
@endsection
