<?php
/**
 * WooGA Enhanced Ecommerce
 *
 * @package   wooga-enhanced-ecommerce
 * @author    Bartłomiej Dziewa <bartlomiej.dziewa@outlook.com>
 * @copyright 2022 WooGA Enhanced Ecommerce
 * @license   MIT
 * @link      https://github.com/Rakim09
 */

declare( strict_types = 1 );

namespace WoogaEnhancedEcommerce\App\Frontend;

use WoogaEnhancedEcommerce\Common\Abstracts\Base;
use TheIconic\Tracking\GoogleAnalytics\Analytics;
use WC_Order;
use WC_Order_Item_Product;
use WP_Term;

/**
 * Class GoogleAnalytics
 *
 * @package WoogaEnhancedEcommerce\App\Frontend
 * @since 1.0.0
 */
class GoogleAnalytics extends Base {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		/**
		 * This frontend class is only being instantiated in the frontend as requested in the Bootstrap class
		 *
		 * @see Requester::isFrontend()
		 * @see Bootstrap::__construct
		 *
		 * Add plugin code here
		 */
		
        add_action( 'woocommerce_checkout_create_order', [ $this, 'checkoutCreateOrder' ] );

        add_action( 'woocommerce_payment_complete', [ $this, 'paymentComplete' ] );
	}

    public function checkoutCreateOrder( WC_Order $order  )
    {
        $cid = preg_replace("/^.+\.(.+?\..+?)$/", "\\1", @$_COOKIE['_ga']);
        $order->update_meta_data( 'wooga_ga_cid', $cid );
    }

    public function paymentComplete( $order_id )
    {
        /**
         * @var WC_Order $order
         */
        $order = wc_get_order( $order_id );

        $analytics = new Analytics();

        $analytics->setProtocolVersion( '1' )
            ->setTrackingId( get_option( 'wooga_ga_tracking_id' ) )
            ->setClientId( $order->get_meta('wooga_ga_cid') )
            ->setUserId( $order->get_customer_id() );

        $analytics->setTransactionId( $order->get_order_number() )
            ->setAffiliation( get_the_title( get_option( 'woocommerce_shop_page_id' ) ) )
            ->setRevenue( (float) $order->get_total() )
            ->setTax( (float) $order->get_total_tax() )
            ->setShipping( (float) $order->get_shipping_total() )
            ->setCurrencyCode( $order->get_currency() )
            ->setCouponCode( implode( ', ',  $order->get_coupon_codes() ) );
        
        /**
         * @var WC_Order_Item_Product $item
         */
        foreach ( $order->get_items() as $item ) {
            /**
             * @var WC_Product $product
             */
            $product = $item->get_product();

            $_query_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();

            $_product_data = [
                'sku' => $product->get_sku(),
                'name' => $product->get_name(),
                'price' => (float) $item->get_total(), 
                'quantity' => $item->get_quantity(),
                'category' => $this->getProductTerm( $_query_id, 'product_cat' ),
                'brand' => $this->getProductTerm( $_query_id, get_option( 'wooga_brand_taxonomy' ) ),
            ];

            $analytics->addProduct( $_product_data );
        }
        $analytics->setProductActionToPurchase();

        $analytics->setEventCategory('Checkout')
            ->setEventAction('Purchase')
            ->sendEvent();
    }

    private function getProductTerm( int $product_id, string $taxonomy ): string
    {
        /**
         * @var WP_Term[] $_terms
         */
        $_terms = wp_get_post_terms( $product_id, $taxonomy, array( 'orderby' => 'parent', 'order' => 'ASC'));
        if ( ( is_array( $_terms ) ) && ( count( $_terms ) > 0 ) ) {
            $terms = $_terms[0]->name;
        }

        return $terms ?? '';
    }
}
