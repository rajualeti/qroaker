

$(function () {
	var counter = 0;
	$('table.footable').footable({
		debug: true,
	});
});

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();   
});


/* google places api calling */
function getCityFromGoogle(id)
{
	var input = document.getElementById(id);
	if(input)
	{
		var autocomplete = new google.maps.places.Autocomplete(
		/** @type {HTMLInputElement} */(input),
		{
			types: ['(cities)'],
			componentRestrictions: {country: "ind"},
		});
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				return;
			}
			
			input.value = place.address_components[0].long_name;
		});
	}

}

function getLocationFromGoogle(id, latitude, longitude)
{
	var input = document.getElementById(id);
	if(input)
	{
		var autocomplete = new google.maps.places.Autocomplete(
		/** @type {HTMLInputElement} */(input),
		{
			types: ['(regions)'],
			componentRestrictions: {country: "ind"},
		});
		google.maps.event.addListener(autocomplete, 'place_changed', function() {
			var place = autocomplete.getPlace();
			if (!place.geometry) {
				return;
			}

			if (document.getElementById(latitude) != null) {
				document.getElementById(latitude).value = place.geometry.location.lat();
			}

			if (document.getElementById(longitude) != null) {
				document.getElementById(longitude).value = place.geometry.location.lng();
			}
		});
	}

}


/*table search javacript clear icon in list pages;*/
jQuery(function($) {

	function tog(v){return v?'addClass':'removeClass';} 
	
	$(document).on('input', '.clearable', function(){

		$(this)[tog(this.value)]('x');

	}).on('mousemove', '.x', function( e ){

		$(this)[tog(this.offsetWidth-30 < e.clientX-this.getBoundingClientRect().left)]('onX');  

	}).on('touchstart click', '.onX', function( ev ){

		ev.preventDefault();
	
		$(this).removeClass('x onX').val('').change();
		
		$('#table_search ').trigger('keyup');

		if (typeof search == 'function') {
			search(1);
		}
	});

});


/* jquery table search script */
$(document).ready(function () {

	(function ($) {

        $('#table_search').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.searchable tr').hide();
            $('.searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    }(jQuery));
	
	(function ($) {

        $('#from_search').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.tbl-from-searchable tr').hide();
            $('.tbl-from-searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    }(jQuery));
    
    (function ($) {

        $('#to_search').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.tbl-to-searchable tr').hide();
            $('.tbl-to-searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    }(jQuery));
    
    (function ($) {

        $('#trucktype_search').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.tbl-trucktype-searchable tr').hide();
            $('.tbl-trucktype-searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    }(jQuery));
    
    (function ($) {

        $('#material_search').keyup(function () {

            var rex = new RegExp($(this).val(), 'i');
            $('.tbl-material-searchable tr').hide();
            $('.tbl-material-searchable tr').filter(function () {
                return rex.test($(this).text());
            }).show();
        });

    }(jQuery));
    
});
/* end of jquery table search script */


/* multi selecet checbox script */
$(".qroak-multiselect h3 input:checkbox").cbFamily(function (){
  return $(this).parents("h3").next().find("input:checkbox");
});

/* multi selecet checbox script end */

$('#file-0b').change(function(){
	$('.img-old-logo').hide();
});

$('.fileinput-remove').on('click', function(){
	$('.img-old-logo').show();
});

/* number even for text boxess */
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/; 
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    if(phoneno)  
     {  
       	return true;  
     }  
     else  
     {  
        return false;  
     }  
}

/* it is for hover on dropdown menu in index pages */
$(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");                
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
            $('b', this).toggleClass("caret caret-up");                
        });
});

/* filters collapse script */
$('.collapse').on('shown.bs.collapse', function(){
	$(this).parent().find(".fa-chevron-down").removeClass("fa-chevron-down").addClass("fa-chevron-up");
}).on('hidden.bs.collapse', function(){
	$(this).parent().find(".fa-chevron-up").removeClass("fa-chevron-up").addClass("fa-chevron-down");
});


$('.js__p_close').on("click", function(){
	$('.bs-example-modal-md').hide();
});

$(document).ready(function() {
	enableSelectBoxes();
});
	
function enableSelectBoxes(){
	$('div.selectBox1').each(function(){
		$(this).children('span.selected1').html($(this).children('ul.selectOptions1').children('li.selectOption1:first').html());
		$('input.admin_users').attr('value',$(this).children('ul.selectOptions1').children('li.selectOption1:first').attr('data-value'));
		
		$(this).children('span.selected1,span.selectArrow1').click(function(){
			if($(this).parent().children('ul.selectOptions1').css('display') == 'none'){
				$(this).parent().children('ul.selectOptions1').css('display','block');
			}
			else
			{
				$(this).parent().children('ul.selectOptions1').css('display','none');
			}
		});
		
		$(this).find('li.selectOption1').click(function(){
			$(this).parent().css('display','none');
                                  $('input.admin_users').attr('value',$(this).attr('data-value'));
			$(this).parent().siblings('span.selected1').html($(this).html());
		});
	});				
}