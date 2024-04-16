/**
 * Alpha Radar Chart Library
 * 
 * @package Alpha FrameWork
 * @version 1.0
 */

'use strict';

window.theme = window.theme || {};

( function ( $ ) {
    theme.initRadarChart = function ( selector ) {
        if ( 'undefined' == typeof ( Chart ) ) {
            return;
        }
        theme.$( selector ).each( function () {
            var $chart = $( this ),
                $chart_canvas = $chart.find( '.radar-chart' ),
                data = $chart.data( 'chart' ) || {},
                options = $chart.data( 'options' ) || {};

            if ( true === options.show_tooltip ) {
                options.tooltips.callbacks = {
                    label: function ( tooltipItem, data ) {
                        return ' ' + data.labels[ tooltipItem.index ] + ': ' + data.datasets[ tooltipItem.datasetIndex ].data[ tooltipItem.index ];
                    }
                }
            }

            if ( !$chart.length ) {
                return;
            }

            var intObsOptions = {
                rootMargin: '200px 0px 200px 0px'
            };

            theme.appear( $chart_canvas[ 0 ], function () {
                // If chart is created, return
                if ( $chart.find( '.chartjs-size-monitor' ).length && !$chart_canvas.hasClass( 'repeat-appear-animate' ) ) {
                    return;
                }
                var chartInstance = new Chart( $chart_canvas, {
                    type: 'radar',
                    data: data,
                    options: options
                } );
            }, intObsOptions );
        } );
    }

    $( window ).on( 'alpha_complete', function () {
        theme.initRadarChart( '.radar-chart-container' );
    } )
} )( jQuery );