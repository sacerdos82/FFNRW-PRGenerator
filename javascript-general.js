// Cookies auslesen
var url 	= $.cookie( 'vfnnrw-prgenerator-url' );



// Allgemeine Rückgaben im Kopfbereich
function headerNotification( value ) { $( '#target-headerNotification' ).slideDown( 200 ).html( value ).delay( 2000 ).slideUp( 500 ); }
function headerNotification_ON( value ) { $( '#target-headerNotification' ).slideDown( 200 ).html( value ); }
function headerNotification_QuickON( value ) { $( '#target-headerNotification' ).show().html( value ); }
function headerNotification_OFF( value ) { $( '#target-headerNotification' ).slideUp( 200 ); }



$( document ).ready( function() { 

	$( '#target-headerNotification' ).hide();
	
	$('[data-toggle="tooltip"]').tooltip()
	
	drawDisplay();
	$( window ).resize( function () { drawDisplay(); });

});


// Darstellung
function drawDisplay() {
	
	var windowWidth 	= $( window ).width();
	var windowHeight 	= $( window ).height();
	var headerHeight 	= $( 'header' ).height() + 40;
	var footerHeight 	= $( 'footer' ).height();
	var contentHeight 	= windowHeight - headerHeight - footerHeight
	
	$( '#content' ).height( contentHeight );

	$( '#sidebar' ).height( contentHeight - 20 + 'px');
	$( '#sidebar-inner' ).slimScroll({ height: contentHeight - 20 + 'px', distance: '0px' });

	$( '#canvas').height( contentHeight );
	$( '#canvas').width( windowWidth - $( '#sidebar' ).width() - 15 + 'px' );
	
	if( windowWidth < 600 ) {
		
		$( '#windowLock' ).width( windowWidth - 100 );
		$( '#windowLock' ).height( windowHeight );
		$( '#windowLock' ).show();
		
	} else {
		
		$( '#windowLock' ).hide();
	}
	
}