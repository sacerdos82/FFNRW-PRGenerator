// Cookies auslesen
var url 	= $.cookie( 'vfnnrw-prgenerator-url' );


$( document ).ready( function() { 

	drawTabledisplay();
	$( window ).resize( function () { drawTabledisplay(); });
	
	$( '#community-name' ).bind('input', function() { $( '#tabledisplay-target-community-name' ).html( this.value ); });
	$( '#community-email' ).bind('input', function() { $( '#tabledisplay-target-community-email' ).html( this.value ); });
	$( '#community-website' ).bind('input', function() { $( '#tabledisplay-target-community-website' ).html( this.value ); });
	$( '#community-ssid' ).bind('input', function() { $( '#tabledisplay-target-community-ssid' ).html( this.value ); });
	
	$( '#organisation-website' ).bind('input', function() { $( '#tabledisplay-target-organisation-website' ).html( this.value ); });
	
	$( '#owner-name' ).bind('input', function() { $( '#tabledisplay-target-owner-name' ).html( this.value ); });
	$( '#owner-website' ).bind('input', function() { $( '#tabledisplay-target-owner-website' ).html( this.value ); });
	$( '#owner-infos' ).bind('input', function() { $( '#tabledisplay-target-owner-infos' ).html( this.value ); });
	
	
	$( '#trigger-render' ).click( function() { renderTabledisplay(); });

});


// Grundgerüst rendern
function drawTabledisplay() {
	
	var windowWidth 		= $( window ).width();
	var windowHeight 		= $( window ).height();
	var headerHeight 		= $( 'header' ).height() + 40;
	var footerHeight 		= $( 'footer' ).height();
	var contentHeight 		= windowHeight - headerHeight - footerHeight;
	
	var calcfactor			= Math.round( $( '#canvas').width() / 297 ) - 1
	if ( calcfactor < 3 ) { var factor = 3; } else { var factor = calcfactor; }

	var ptFactor			= 0.351 * factor;
	
	$( '#target-download' ).hide();
	
	$( '#document' ).height( 210 * factor + 'px' );
	$( '#document' ).width( 297 * factor + 'px' );

	$( '#background-svg img' ).height( 210 * factor + 'px' );
	$( '#background-svg img' ).width( 297 * factor + 'px' ); 	
	
	$( '#tabledisplay-target-community-ssid' ).width( 60 * factor + 'px' );
	$( '#tabledisplay-target-community-ssid' ).height( 10 * factor + 'px' );
	$( '#tabledisplay-target-community-ssid' ).css( 'bottom', 15 * factor + 'px' );
	$( '#tabledisplay-target-community-ssid' ).css( 'left', 15.5 * factor + 'px' );
	$( '#tabledisplay-target-community-ssid' ).css( 'font-size', 10 * ptFactor + 'px' );
	
	$( '#tabledisplay-information' ).width( 60 * factor + 'px' );
	$( '#tabledisplay-information' ).height( 15 * factor + 'px' );
	$( '#tabledisplay-information' ).css( 'top', 30 * factor + 'px' );
	$( '#tabledisplay-information' ).css( 'left', 195 * factor + 'px' );
	$( '#tabledisplay-information' ).css( 'font-size', 10 * ptFactor + 'px' );
	$( '#tabledisplay-information' ).css( 'line-height', 20 * ptFactor + 'px' );
	
	$( '#tabledisplay-community' ).width( 60 * factor + 'px' );
	$( '#tabledisplay-community' ).height( 35 * factor + 'px' );
	$( '#tabledisplay-community' ).css( 'top', 60 * factor + 'px' );
	$( '#tabledisplay-community' ).css( 'left', 195 * factor + 'px' );
	$( '#tabledisplay-community' ).css( 'font-size', 10 * ptFactor + 'px' );
	$( '#tabledisplay-community' ).css( 'line-height', 16 * ptFactor + 'px' );
	$( '#tabledisplay-community p' ).css( 'padding-bottom', 2 * factor + 'px' );
	
	$( '#tabledisplay-owner' ).width( 60 * factor + 'px' );
	$( '#tabledisplay-owner' ).height( 61 * factor + 'px' );
	$( '#tabledisplay-owner' ).css( 'top', 130 * factor + 'px' );
	$( '#tabledisplay-owner' ).css( 'left', 105 * factor + 'px' );
	$( '#tabledisplay-owner' ).css( 'font-size', 10 * ptFactor + 'px' );
	$( '#tabledisplay-owner' ).css( 'line-height', 16 * ptFactor + 'px' );
	$( '#tabledisplay-owner p' ).css( 'padding-bottom', 2 * factor + 'px' );
	
	$( '#tabledisplay-target-owner-name' ).css( 'font-size', 12 * ptFactor + 'px' );
	$( '#tabledisplay-target-owner-name' ).css( 'line-height', 18 * ptFactor + 'px' );
	
}



// Rendern
function renderTabledisplay() {
	
	var community_name			= $( 'input[name="community-name"]' ).val();
	var community_website		= $( 'input[name="community-website"]' ).val();
	var community_email			= $( 'input[name="community-email"]' ).val();
	var community_ssid			= $( 'input[name="community-ssid"]' ).val();

	var organisation_website	= $( 'input[name="organisation-website"]' ).val();

	var owner_name			= $( 'input[name="owner-name"]' ).val();
	var owner_website		= $( 'input[name="owner-website"]' ).val();
	var owner_infos			= $( '#owner-infos' ).val();

	
	var addRequest = $.ajax({
			
		type: "POST",
		url: url + '/api.php/generate/tabledisplay',
		beforeSend: function() {
			$( '#target-download' ).hide();
		},
		data: {
			"community_name":		community_name,
			"community_website":	community_website,
			"community_email":		community_email,
			"community_ssid":		community_ssid,
			"organisation_website":	organisation_website,
			"owner_name":			owner_name,
			"owner_website":		owner_website,
			"owner_infos":			owner_infos
		},
		dataType: "json"
		
	}).done( function( data ) {
		
		if( data.header.error != true ) {
			
			// window.open( data.body, 'pdf');
			$( '#target-download' ).html( '<a href="'+ data.body +'" target="_blank"><i class="fa fa-download"></i></a>' );
			$( '#target-download' ).slideDown();
			
		} else { headerNotification( data.header.code +' : '+ data.header.message ); }
		
	}).fail( function () { headerNotification( 'Konnte keine Verbindung zur API herstellen.' ); });
	
}