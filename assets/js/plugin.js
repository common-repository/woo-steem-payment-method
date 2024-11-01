(function($) {
	"use strict";

	function wc_get_base_currency() {
		return (wc_steem !== 'undefined' && 'cart' in wc_steem && 'base_currency' in wc_steem.cart) ? wc_steem.cart.base_currency : 'USD';
	}

	function wc_get_amount($currency) {
		return (wc_steem !== 'undefined' && 'cart' in wc_steem && 'amounts' in wc_steem.cart) ? wc_steem.cart.amounts[$currency + '_' + wc_get_base_currency()] : -1;
	}
	
	$(document).on('change', 'select[name="wc_steem-amount_currency"]', function(event) {
		var $currency = this.value;
		var $amount = wc_get_amount($currency);

		if ($amount > -1) {
			$('#wc_steem-amount').html($amount + ' ' + $currency);
		}
	});

	$(document).on('show_variation', '.variations_form', function(event, variation) {
		var $prices_html = 'prices_html' in variation ? variation.prices_html : null;

		if ($prices_html != null) {
			$(this).find('.woocommerce-variation-price').append($prices_html);
		}
	});
})(jQuery);
