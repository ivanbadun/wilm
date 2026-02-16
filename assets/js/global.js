;
(function( $ ) {

	const $header = $('.header');
	const $alertBar = $('#alert-bar');
	const $adminBar = $('#wpadminbar');
	const $homeSlides = $('#home-slider .slick-slide');
	const $backToTopButton = $('#back-to-top');

	// var scrollOut;
	let lazyLoadInstance;

	function handleFirstTab(e) {
		var key = e.key || e.keyCode;
		if ( key === 'Tab' || key === '9' ) {
			$( 'body' ).removeClass( 'no-outline' );

			window.removeEventListener('keydown', handleFirstTab);
			window.addEventListener('mousedown', handleMouseDownOnce);
		}
	}

	function handleMouseDownOnce() {
		$( 'body' ).addClass( 'no-outline' );

		window.removeEventListener('mousedown', handleMouseDownOnce);
		window.addEventListener('keydown', handleFirstTab);
	}

	window.addEventListener('keydown', handleFirstTab);

	// Fit slide video background to video holder
	function resizeVideo() {
		var $holder = $( '.videoHolder' );
		$holder.each( function() {
			var $that = $( this );
			var ratio = $that.data( 'ratio' ) ? $that.data( 'ratio' ) : '16:9',
				width = parseFloat( ratio.split( ':' )[0] ),
				height = parseFloat( ratio.split( ':' )[1] );
			$that.find( '.video' ).each( function() {
				if ( $that.width() / width > $that.height() / height ) {
					$( this ).css( { 'width': '100%', 'height': 'auto' } );
				} else {
					$( this ).css( { 'width': $that.height() * width / height, 'height': '100%' } );
				}
			} );
		} );
	}

	// Debounce function that prevent multiple function call

	function debounce(callback, time) {
		var timeout;

		return function() {
			var context = this;
			var args = arguments;
			if (timeout) {
				clearTimeout(timeout);
			}
			timeout = setTimeout(function() {
				timeout = null;
				callback.apply(context, args);
			}, time);
		}
	}

	// Back to top button
	function scrollFunction() {
		if ($(window).scrollTop() > 30) {
			$backToTopButton.addClass('back-to-top_show');
		} else {
			$backToTopButton.removeClass('back-to-top_show');
		}
	}

	function scrollToTop() {
		window.scrollTo({
			top: 0,
			behavior: 'smooth'
		});
	}

	function updateHomeSlidesHeight() {
		if (!$homeSlides.length) return;

		let headerHeight = $header.outerHeight() || 0;
		let alertHeight = $alertBar.outerHeight() || 0;
		let adminHeight = $adminBar.outerHeight() || 0;
		let offset = headerHeight + alertHeight + adminHeight;

		let resultHeight = 'calc(100dvh - ' + offset + 'px)';
		$homeSlides.css('max-height', resultHeight);
	}

	// Scripts which runs after DOM load
	$( document ).on( 'ready', function() {

		// Init LazyLoad
		lazyLoadInstance = new LazyLoad({
			elements_selector: 'img[data-lazy-src],.pre-lazyload',
			data_src: 'lazy-src',
			data_srcset: 'lazy-srcset',
			data_sizes: 'lazy-sizes',
			skip_invisible: false,
			class_loading: 'lazyloading',
			class_loaded: 'lazyloaded',
		});
		// Add tracking on adding any new nodes to body to update lazyload for the new images (AJAX for example)
		window.addEventListener(
			'LazyLoad::Initialized',
			function () {
				// Get the instance and puts it in the lazyLoadInstance variable
				if (window.MutationObserver) {
					let observer = new MutationObserver(function (mutations) {
						mutations.forEach(function (mutation) {
							mutation.addedNodes.forEach(function (node) {
								if (typeof node.getElementsByTagName !== 'function') {
									return;
								}
								let imgs = node.getElementsByTagName('img');
								if (0 === imgs.length) {
									return;
								}
								lazyLoadInstance.update();
							});
						});
					});
					let b = document.getElementsByTagName('body')[0];
					let config = { childList: true, subtree: true };
					observer.observe(b, config);
				}
			},
			false
		);

		// Detect element appearance in viewport
		// scrollOut = ScrollOut( {
		// 	offset: function() {
		// 		return window.innerHeight - 200;
		// 	},
		// 	once: true,
		// 	onShown: function( element ) {
		// 		if ( $( element ).is( '.ease-order' ) ) {
		// 			$( element ).find( '.ease-order__item' ).each( function( i ) {
		// 				var $this = $( this );
		// 				$( this ).attr( 'data-scroll', '' );
		// 				window.setTimeout( function() {
		// 					$this.attr( 'data-scroll', 'in' );
		// 				}, 300 * i );
		// 			} );
		// 		}
		// 	}
		// } );


		// Init parallax
		/*$('.jarallax').jarallax({
			speed: 0.5,
		});

		$('.jarallax-inline').jarallax({
			speed: 0.5,
			keepImg: true,
			onInit : function() { lazyLoadInstance.update(); }
		});*/

		// IE Object-fit cover polyfill
		if ( $( '.of-cover, .stretched-img' ).length ) {
			objectFitImages( '.of-cover, .stretched-img' );
		}

		//Remove placeholder on click
		$( 'input,textarea' ).each( function() {
			$( this ).data( 'holder', $( this ).attr( 'placeholder' ) );

			$( this ).on( 'focusin', function() {
				$( this ).attr( 'placeholder', '' );
			} );

			$( this ).on( 'focusout', function() {
				$( this ).attr( 'placeholder', $( this ).data( 'holder' ) );
			} );
		} );

		//Make elements equal height
		$( '.matchHeight' ).matchHeight();


		// Add fancybox to images
		// $( '.gallery-item' ).find('a[href$="jpg"], a[href$="png"], a[href$="gif"]').attr( 'rel', 'gallery' ).attr( 'data-fancybox', 'gallery' );
		// $( 'a[rel*="album"], .fancybox, a[href$="jpg"], a[href$="png"], a[href$="gif"]' ).fancybox( {
		// 	minHeight: 0,
		// 	helpers: {
		// 		overlay: {
		// 			locked: false
		// 		}
		// 	}
		// } );

		/**
		 * Scroll to Gravity Form confirmation message after form submit
		 */
		$( document ).on( 'gform_confirmation_loaded', function( event, formId ) {
			var $target = $( '#gform_confirmation_wrapper_' + formId );
			if ( $target.length ) {
				$( 'html, body' ).animate( {
					scrollTop: $target.offset().top - 50,
				}, 500 );
				return false;
			}
		} );

		/**
		 * Hide gravity forms required field message on data input
		 */
		$( 'body' ).on( 'change keyup', '.gfield input, .gfield textarea, .gfield select', function() {
			var $field = $( this ).closest( '.gfield' );
			if ( $field.hasClass( 'gfield_error' ) && $( this ).val().length ) {
				$field.find( '.validation_message' ).hide();
			} else if ( $field.hasClass( 'gfield_error' ) && !$( this ).val().length ) {
				$field.find( '.validation_message' ).show();
			}
		} );

		/**
		 * Close responsive menu on orientation change
		 */
		$( window ).on( 'orientationchange', function() {
			$( '#main-menu' ).dropdown( 'hide' );
		} );

		resizeVideo();

		/*
		*  This function will render each map when the document is ready (page has loaded)
		*/

		$('.acf-map').each(function(){
			render_map( $(this) );
		});

		scrollFunction();
		$backToTopButton.on('click', function () {
			scrollToTop();
		});

		updateHomeSlidesHeight();
	} );


	// Scripts which runs after all elements load

	$( window ).on( 'load', function() {

		// scrollOut.update();

		//jQuery code goes here
		if ( $( '.preloader' ).length ) {
			$( '.preloader' ).addClass( 'preloader--hidden' );
		}

		// Update LazyLoad images before Slide change
		$('.slick-slider').on('afterChange', function (event, slick, currentSlide) {
			lazyLoadInstance.update();
		});
	} );

	// Scripts which runs at window resize

	var resizeVideoCallback = debounce( resizeVideo, 200 );
	var closeMenuCallback = debounce( function() {
		$( '#main-menu' ).dropdown( 'hide' );
	}, 200 );
	$( window ).on( 'resize', function() {

		//jQuery code goes here
		resizeVideoCallback();

		// Close responsive menu on Responsive menu breakpoint pass
		var $navBar = $( '.header' ).find( '.navbar' );
		var classes = $.grep( $navBar[0].className.split( ' ' ), function( v, i ) {
			return v.indexOf( 'navbar-expand' ) !== -1;
		} ).join();

		if ( classes.length ) {
			var menuBreakpoint = classes.replace( 'navbar-expand-', '' );
			// Get ::root var value
			var breakpointWidth = getComputedStyle( document.body ).getPropertyValue( '--breakpoint-' + menuBreakpoint ).replace( /\D/g, '' );
			if ( (window.innerWidth > breakpointWidth) && ($navBar.find( '.dropdown-menu' ).hasClass( 'show' ) || $( '#main-menu' ).hasClass( 'show' )) ) {
				closeMenuCallback();
			}
		}

		updateHomeSlidesHeight();
	} );

	// Scripts which runs on scrolling

	$( window ).on( 'scroll', function() {

		//jQuery code goes here
		scrollFunction();
	} );

	/*
	 *  This function will render a Google Map onto the selected jQuery element
	 */

	function render_map( $el ) {
		// var
		var $markers = $el.find( '.marker' );
		// var styles = []; // Uncomment for map styling

		// vars
		var args = {
			zoom: 16,
			center: new google.maps.LatLng( 0, 0 ),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			// styles : styles // Uncomment for map styling
		};

		// create map
		var map = new google.maps.Map( $el[0], args );

		// add a markers reference
		map.markers = [];

		// add markers
		$markers.each( function() {
			add_marker( $( this ), map );
		} );

		// center map
		center_map( map );
	}

	/*
	 *  This function will add a marker to the selected Google Map
	 */

	var infowindow;

	function add_marker( $marker, map ) {
		// var
		var latlng = new google.maps.LatLng( $marker.attr( 'data-lat' ), $marker.attr( 'data-lng' ) );

		// create marker
		var marker = new google.maps.Marker( {
			position: latlng,
			map: map,
			//icon: $marker.data('marker-icon') //uncomment if you use custom marker
		} );

		// add to array
		map.markers.push( marker );

		// if marker contains HTML, add it to an infoWindow
		if ( $.trim( $marker.html() ) ) {
			// create info window
			infowindow = new google.maps.InfoWindow();

			// show info window when marker is clicked
			google.maps.event.addListener( marker, 'click', function() {
				// Close previously opened infowindow, fill with new content and open it
				infowindow.close();
				infowindow.setContent( $marker.html() );
				infowindow.open( map, marker );
			} );
		}
	}

	/*
	*  This function will center the map, showing all markers attached to this map
	*/

	function center_map( map ) {
		// vars
		var bounds = new google.maps.LatLngBounds();

		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ) {
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		} );

		// only 1 marker?
		if ( map.markers.length == 1 ) {
			// set center of map
			map.setCenter( bounds.getCenter() );
		} else {
			// fit to bounds
			map.fitBounds( bounds );
		}
	}

}( jQuery ));
