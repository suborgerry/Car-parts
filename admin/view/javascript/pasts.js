var pasts_parcel_method_code = 'pastterminal';
var pasts_parcel_method_code_1 = 'pastcirclek';
var pasts_parcel_method_code_2 = 'pastpickup';

(function($) {

	function buildTerminalList(geoZone, scName) { 
		$('select[name="shipping_method"]').closest('.form-group').after('<i class="fa fa-circle-o-notch fa-spin"></i>');
		var wrap = $('#pasts-parcel-list-wrap');
		if(wrap.length == 0) {
			var parent = $('select[name="shipping_method"]').closest('.form-group');
			$('' +
				'<div class="form-group" id="pasts-parcel-list-wrap" style="display:block">' +
					'<label class="col-sm-2 control-label">Choose</label>' +
					'<div class="col-sm-10">' +
						'<select name="shippingparcelId" class="form-control" id="pasts-parcel-list"></select>' +
					'</div>' +
				'</div>').insertAfter(parent);

		}

		var list = $('#pasts-parcel-list');
		list.empty();
			
		// Temporart detach AJAX interceptor
		useAjaxInterceptor(false);

		$.ajax({
	      type: 'GET',
	      url: 'index.php?route=extension/shipping/'+scName+'/getParcelSelect&user_token=' + window.url_token +'&order_id='+ window.orderref,
	      dataType: 'json',
	      data: {
	      	country_id: $('#input-shipping-country').val(),
	      	city: $('#input-shipping-city').val(),
			geoZone: geoZone,
	      },
	      beforeSend: function(){
	      	$('#pasts-parcel-list-wrap').hide();
	      },
	      success: function(response) {
	        $('.fa-spin').remove();
	        $('#pasts-parcel-list-wrap').show();
			$('#pasts-parcel-list').replaceWith(response.select);
	      },
	      error: function(xhr, options, error) {
	        console.error('Pasts error: ' + error);
	      },
	      complete: function() {
	      	// Need delay to reattach AJAX interceptor
	      	setTimeout(function() {
	      		useAjaxInterceptor(true);
	      	}, 1000);
	      }
	    });

	}

	function onShippingMethodChange(e) { 
		if( $(this).val().indexOf(pasts_parcel_method_code) > -1 || $(this).val().indexOf(pasts_parcel_method_code_1) > -1 || $(this).val().indexOf(pasts_parcel_method_code_2) > -1 ) {

			var sc = $(this).val().split('.');
			if(sc[0]){
				var scName = sc[0]; 
			}else{
				var scName = 'pastterminal'; 
			}

			buildTerminalList($(this).val(), scName);			
		} else {
			$('#pasts-parcel-list-wrap').remove();
			$('.fa-spin').remove();
		}
	}

	function init() {
		$('select[name="shipping_method"]').off('change').change(onShippingMethodChange);

		if($('select[name="shipping_method"]:visible').length > 0) {
			$('select[name="shipping_method"]').trigger('change');
		}
	}

	/**
	 * Manage AJAX interceptor
	 * 
	 * @param  {boolean} enabled
	 * @return {void}
	 */
	function useAjaxInterceptor(enabled) {
		if(enabled) {
			$(document).ajaxStop(function() {
				init();
			});
		} else {
			$(document).off('ajaxStop');
		}
	}

	$(document).ready(function() { 
		
		// Watch for AJAX calls to finish and bind events
		useAjaxInterceptor(true);
	});

})(jQuery)
