$( document ).ready( function() { 

	drawStatement();
	$( window ).resize( function () { drawStatement(); });
	
	$( '#receiver-name' ).bind('input', function() { $( '#target-receiver-name' ).html( this.value ); });
	$( '#receiver-salutation' ).bind('input', function() { $( '#target-receiver-salutation' ).html( this.value ); });
	
	$( '#sender-name' ).bind('input', function() { $( '#target-sender-name' ).html( this.value ); $( '#target-sender-name2' ).html( this.value ); $( '#target-sender-name3' ).html( this.value ); });
	$( '#sender-street' ).bind('input', function() { $( '#target-sender-street' ).html( this.value ); });
	$( '#sender-city' ).bind('input', function() { $( '#target-sender-city' ).html( this.value ); });
	$( '#sender-contact1' ).bind('input', function() { $( '#target-sender-contact1' ).html( this.value ); });
	$( '#sender-contact2' ).bind('input', function() { $( '#target-sender-contact2' ).html( this.value ); });
	
	$( '#community-name' ).bind('input', function() { $( '#target-community-name' ).html( this.value ); });
	$( '#community-website' ).bind('input', function() { $( '#target-community-website' ).html( this.value ); });
	$( '#community-email' ).bind('input', function() { $( '#target-community-email' ).html( this.value ); });
	
	$( '#organisation-website' ).bind('input', function() { $( '#target-organisation-website' ).html( this.value ); });
	
	$( '#content-text' ).bind('input', function() { $( '#target-content-text' ).html( this.value ); });
	
	
	$( '#trigger-render' ).click( function() { renderStatement(); });

});


// Grundgerüst rendern
function drawStatement() {
	
	var windowWidth 		= $( window ).width();
	var windowHeight 		= $( window ).height();
	var headerHeight 		= $( 'header' ).height() + 40;
	var footerHeight 		= $( 'footer' ).height();
	var contentHeight 		= windowHeight - headerHeight - footerHeight;
	
	var factor				= Math.round( $( '#canvas').width() / 210 ) - 1
	var ptFactor			= 0.351 * factor;
	
	$( '#target-download' ).hide();
	
	$( '#document' ).height( 297 * factor + 'px' );
	$( '#document' ).width( 210 * factor + 'px' );
	
	$( '#background-svg img' ).height( 297 * factor + 'px' );
	$( '#background-svg img' ).width( 210 * factor + 'px' ); 	

	$( '#document p').css( 'margin-bottom', 10 * ptFactor + 'px' );
	
	$( '#document h1').css( 'font-size', 14 * ptFactor + 'px' );
	$( '#document h1').css( 'top', 46 * factor + 'px' );
	$( '#document h1').css( 'left', 163.5 * factor + 'px' );
	
	$( '#project-infos').width( 35 * factor + 'px' );
	$( '#project-infos').css( 'font-size', 7 * ptFactor + 'px' );
	$( '#project-infos').css( 'top', 99 * factor + 'px' );
	$( '#project-infos').css( 'left', 163.5 * factor + 'px' );
	$( '#project-infos p').css( 'margin-bottom', 5 * ptFactor + 'px' );
	
	$( '#address-sender').css( 'font-size', 6 * ptFactor + 'px' );
	$( '#address-sender').css( 'line-height', 10 * ptFactor + 'px' );
	$( '#address-sender').css( 'width', 70 * factor + 'px' );
	$( '#address-sender').css( 'top', 45 * factor + 'px' );
	$( '#address-sender').css( 'left', 25 * factor + 'px' );
	
	$( '#address').css( 'font-size', 8 * ptFactor + 'px' );
	$( '#address').css( 'line-height', 14 * ptFactor + 'px' );
	$( '#address').css( 'width', 70 * factor + 'px' );
	$( '#address').css( 'top', 50 * factor + 'px' );
	$( '#address').css( 'left', 25 * factor + 'px' );
	
	$( '#lettertext').css( 'font-size', 8 * ptFactor + 'px' );
	$( '#lettertext').css( 'line-height', 14 * ptFactor + 'px' );
	$( '#lettertext').css( 'width', 120 * factor + 'px' );
	$( '#lettertext').css( 'top', 99 * factor + 'px' );
	$( '#lettertext').css( 'left', 25 * factor + 'px' );
	
}


// Rendern
function renderStatement() {
	
	var receiver_name	 		= $( 'input[name="receiver-name"]' ).val();
	var receiver_salutation		= $( 'input[name="receiver-salutation"]' ).val();
	
	var sender_name 			= $( 'input[name="sender-name"]' ).val();
	var sender_street 			= $( 'input[name="sender-street"]' ).val();
	var sender_city	 			= $( 'input[name="sender-city"]' ).val();
	var sender_contact1			= $( 'input[name="sender-contact1"]' ).val();
	var sender_contact2			= $( 'input[name="sender-contact2"]' ).val();
	
	var community_name			= $( 'input[name="community-name"]' ).val();
	var community_website		= $( 'input[name="community-website"]' ).val();
	var community_email			= $( 'input[name="community-email"]' ).val();
	
	var organisation_website	= $( 'input[name="organisation-website"]' ).val();
	
	var content_text			= $( '#content-text' ).val();
	
	var addRequest = $.ajax({
			
		type: "POST",
		url: url + '/api.php/generate/statement/tmg-2015-03-12',
		beforeSend: function() {
			$( '#target-download' ).hide();
		},
		data: {
			"receiver_name": 		receiver_name,
			"receiver_salutation": 	receiver_salutation,
			"sender_name":			sender_name,
			"sender_street":		sender_street,
			"sender_city":			sender_city,
			"sender_contact1":		sender_contact1,
			"sender_contact2":		sender_contact2,
			"community_name":		community_name,
			"community_website":	community_website,
			"community_email":		community_email,
			"organisation_website":	organisation_website,
			"content_text":			content_text
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