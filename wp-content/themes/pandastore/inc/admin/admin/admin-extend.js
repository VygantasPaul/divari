/*global woocommerce_admin_meta_boxes */
jQuery( function ( $ ) {

    $( document ).on( 'click', '#general_product_data .sale-price-pos-checkbox', function ( e ) {
        var $this = $( this ),
            checked = $this.prop( 'checked' );

        if ( checked ) {
            $this.attr( 'value', 'yes' );
        } else {
            $this.attr( 'value', 'no' );
        }
    } )

    // Sale price schedule.
    $( '.sale_price_pos_field' ).each( function () {
        var $these_sale_pos = $( this );
        var sale_schedule_set = false;
        var $wrap = $these_sale_pos.closest( 'div, table' );

        $these_sale_pos.find( 'input' ).each( function () {
            if ( 'no' != $( this ).val() ) {
                sale_schedule_set = true;
            }
        } );

        if ( 'none' == $( '.sale_price_dates_fields' ).css( 'display' ) ) {
            $wrap.find( '.sale_price_pos_field' ).hide();

        } else {
            $wrap.find( '.sale_price_pos_field' ).show();
        }

    } );
    $( '#woocommerce-product-data' ).on( 'click', '.sale_schedule', function () {
        var $wrap = $( this ).closest( 'div, table' );

        $( this ).hide();
        $wrap.find( '.cancel_sale_schedule' ).show();
        $wrap.find( '.sale_price_pos_field' ).show();
    } );
    $( '#woocommerce-product-data' ).on( 'click', '.cancel_sale_schedule', function () {
        var $wrap = $( this ).closest( 'div, table' );

        $( this ).hide();
        $wrap.find( '.sale_schedule' ).show();
        $wrap.find( '.sale_price_pos_field' ).hide();
        $wrap.find( '.sale_price_pos_field' ).find( 'input' ).val( '' );
    } );
} );
