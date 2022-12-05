jQuery( document ).ready( function($){
/*	function convert(){
    var doc = new jsPDF();
    var imgData = '';
    console.log(imgData);
    doc.setFontSize(40);
    doc.text(30, 20, 'Hello world!');
    doc.addImage(imgData, 'JPEG', 15, 40, 180, 160);
    doc.output('datauri');
}
	convert();*/
	$("#heading_size").val($("#product_single_image_title").css("font-size"));
	$("#heading_color").val($("#product_single_image_title").css("color"));
	$("#sub_size").val($("#product_single_image_title_sub").css("font-size"));
	$("#sub_color").val($("#product_single_image_title_sub").css("color"));
if($("body").hasClass("woocommerce-checkout")){
var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};
 
 
$('#generatePDF').click(function () {
    doc.fromHTML($('#htmlContent').html(), 15, 15, {
        'width': 1000,
        'elementHandlers': specialElementHandlers
    });
    doc.save('purchased_product.pdf');
});
	document.getElementById("printPDF").onclick = function () {
    printElement(document.getElementById("htmlContent"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
	
	// Get the modal
var modal = document.getElementById("printModal");

// Get the button that opens the modal
var btn = document.getElementById("printButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
if(btn){
btn.onclick = function() {
  modal.style.display = "block";
}
}
// When the user clicks on <span> (x), close the modal
 if(span){
span.onclick = function() {
  modal.style.display = "none";
}
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
}
	  $(document).on('keyup','#product_title',function () {
		 $("#product_single_image_title").html( $("#product_title").val()); 
	  });
	$(document).on('keyup','#product_sub_title',function () {
		   $("#product_single_image_title_sub").html($("#product_sub_title").val()); 
	  });
	$(document).on('change','#ak_colors',function () {
		$("#product_single_featured_image img").css("background-color", $("#ak_colors").val());
		
	});
		$(document).on('change','#ak_frames',function () {
			//alert($(this).find(':selected').attr('data-frame'));
		$("#product_single_featured_image").css("background-image", "url(" +$(this).find(':selected').attr('data-frame')+ ")");
			$("#frame_url").val($(this).find(':selected').attr('data-frame'));
			$("#product_single_featured_image").css('background-repeat', 'no-repeat');
			$("#product_single_featured_image").css('background-size', '100% 650px');
			//alert($("#product_single_featured_image").css("background-image"));
		
	});
	$(document).on('click','.design-product-single',function () {
		$(".design-product-single").css("background-color", "white");
		$(this).css("background-color", "#E5E5E5");
		$("#image_url").val($(this).attr("src"));
		$(".product_single_featured_image img").attr("src", $(this).attr("src") );
		
	});
    var admin_url = akpd_front_php_vars.admin_url;
         $(document).on('click','.ak_poster_show',function () {
            var current_btn = $(this);
            var post_id = $(this).data('field_id');
                selected_image_data($, current_btn, admin_url, post_id);
         });
         setTimeout(function(){
            if ($('.selected_image_id') && $('.selected_image_id').is(':checked')) {
            console.log($('.selected_image_id').data('field_id'));
            var post_id = $(this).data('field_id');
            var current_btn = $(this);
            selected_image_data($, current_btn, admin_url, post_id)
         }
     },3000)
         $(document).on('click','.ak_frame_show',function (e) {
            $.ajax({
                url:        admin_url, 
                type:       'POST',
                data:{
                    action : 'ak_frame_to_show',
                },
                success: function(data){
                

                }
            });
         });

});

function selected_image_data($, current_btn, admin_url, post_id){
    var img_link = current_btn.data('img_link');
    console.log('img_link ' + img_link);
    if ( img_link ) {
        $('.woocommerce-product-gallery__image img').attr('src',img_link);
        $('.woocommerce-product-gallery__image--placeholder img').attr('src',img_link);
    }
    $.ajax({
                url:        admin_url,
                type:       'POST',
                data:{
                    action : 'ak_posters_to_show',
                    post_id : post_id,
                },
                success: function(response){
                $('.get_ajax_response').html(response['updated_file']);
                console.log(response);
                console.log(response['updated_file']);
                }
            });
}