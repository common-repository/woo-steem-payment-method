<?php
/**
 * WC_Steem_Order_Handler
 *
 * @package WooCommerce Steem Payment Method
 * @category Class Handler
 * @author ReCrypto
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class WC_Steem_Order_Handler {

	public static function init() {
		$instance = __CLASS__;

		add_action('wc_order_steem_status', array($instance, 'default_order_steem_status'));

		add_action('woocommerce_view_order', array($instance, 'payment_details'), 5);
		add_action('woocommerce_thankyou', array($instance, 'payment_details'), 5);
	}

	public static function default_order_steem_status($status) {
		return $status ? $status : 'pending';
	}

	public static function payment_details($order_id) {
		$order = wc_get_order($order_id);

		if ($order->get_payment_method() != 'wc_steem') 
			return; ?>

		<section class="woocommerce-steem-order-payment-details">

			<h2 class="woocommerce-steem-order-payment-details__title"><?php _e( 'Steem Payment details', 'wc-steem' ); ?></h2>

			<p class="woocommerce-steem-payment-memo-prompt"><em>If you haven't already completed your payment:</em> Please don't forget to include the <strong>"MEMO"</strong> when making a transfer for this transaction to Steem.</p>
			
			<table class="woocommerce-table woocommerce-table--steem-order-payment-details shop_table steem_order_payment_details">
				<tbody>
					<tr>
						<th><?php _e('Payee', 'wc-steem'); ?></th>
						<td><?php echo wc_order_get_steem_payee($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Memo', 'wc-steem'); ?></th>
						<td><?php echo wc_order_get_steem_memo($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Amount', 'wc-steem'); ?></th>
						<td><?php echo wc_order_get_steem_amount($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Currency', 'wc-steem'); ?></th>
						<td><?php echo wc_order_get_steem_amount_currency($order_id); ?></td>
					</tr>
					<tr>
						<th><?php _e('Status', 'wc-steem'); ?></th>
						<td><?php echo wc_order_get_steem_status($order_id); ?></td>
					</tr>
				</tbody>
			</table>

			<?php do_action( 'wc_steem_order_payment_details_after_table', $order ); ?>

		</section>

		<?php if ($transfer = get_post_meta($order->get_id(), '_wc_steem_transaction_transfer', true)) : ?>
		<section class="woocommerce-steem-order-transaction-details">

			<h2 class="woocommerce-steem-order-transaction-details__title"><?php _e( 'Steem Transfer details', 'wc-steem' ); ?></h2>

			<table class="woocommerce-table woocommerce-table--steem-order-transaction-details shop_table steem_order_payment_details">
				<tbody>
					<tr>
						<th><?php _e('Steem Transaction', 'wc-steem'); ?></th>
						<td><?php echo $transfer['transaction']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Time', 'wc-steem'); ?></th>
						<td><?php echo $transfer['time']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Memo', 'wc-steem'); ?></th>
						<td><?php echo $transfer['memo']; ?></td>
					</tr>					
				</tbody>
			</table>

			<?php do_action( 'wc_steem_order_transaction_details_after_table', $order ); ?>

		</section>
		<?php endif; ?>

		<?php
	}
}

WC_Steem_Order_Handler::init();
