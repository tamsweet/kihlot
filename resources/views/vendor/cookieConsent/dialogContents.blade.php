<style>
    #cookieWrapper {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 100;
        margin: 0;
        border-radius: 0;
    }
    .bg-primary {
	    background-color: #0284A2!important;
	}
	.btn-warning {
	    background-color: #F44A4A!important;
	    border: 1px solid #F44A4A!important;
	    color: #FFF;
	}
</style>

<div id="cookieWrapper" class="bg-primary text-white w-100 py-3 text-center cookierbar js-cookie-consent cookie-consent">
    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}&nbsp;&nbsp;
    </span>
    <button class="btn btn-sm btn-warning js-cookie-consent-agree cookie-consent__agree">
        {{ trans('cookieConsent::texts.agree') }}
    </button>
</div>
