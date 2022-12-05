jQuery(document).ready(

    function ($) {
        // array which will store all the artworks we want to upload
        const artworksToUpload = []
        // array which will store all the designs we want to upload
        const designsToUpload = []
        // array which will store all the frames we want to upload
        const framesToUpload = []

        var admin_url = akpd_admin_php_vars.admin_url;

        // $(document).on('click','.customUploadButton',function (e) { 

        //     e.preventDefault();

        //     var current_btn=$(this);

        //     upload_featred_additinol($, current_btn);

        // });
        var colorsList = document.getElementsByClassName("colorpicker-product"); 
        document.getElementById("uploadColor").onclick = function(){
            var colorId;
        for(var i=0;i<colorsList.length;i++){
            colorId=parseInt(colorsList[i].getAttribute("data-id"))+1;
        }
            var tag = document.createElement("input");
            tag.setAttribute("type","color");
            tag.setAttribute("class","colorpicker-product");
            tag.setAttribute("data-id",colorId);
            tag.setAttribute("name","colors_list["+colorId+"]")
            tag.setAttribute("id","product-color-"+colorId);
            var colorsBlock = document.getElementById("colors-block");
            colorsBlock.appendChild(tag);

        }    

        $(document).on("input", "input[name='artwork_text']", function () {
            const parent=this.parentNode;
            const arrayIndex=parent.querySelector("input[name='addedArtworkArrayIndex']").getAttribute("data-artwork-array-index");
            artworksToUpload[arrayIndex]={...artworksToUpload[arrayIndex],artworkName:this.value}
            console.log(artworksToUpload);
        })


        $(document).on("input", "input[name='artwork_price']", function () {
            const parent=this.parentNode;
            const arrayIndex=parent.querySelector("input[name='addedArtworkArrayIndex']").getAttribute("data-artwork-array-index");
            artworksToUpload[arrayIndex]={...artworksToUpload[arrayIndex],artworkPrice:this.value}
            console.log(artworksToUpload);
        })



        document.getElementById("uploadImage")?.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                designsToUpload.push({
                    image: this.files[0]
                })
                reader.onload = function (e) {
            var designs = document.getElementsByClassName("design_display_data_div1");
            designCount=designs.length;

            $("#productLayoutImageContainer").append(`<div class="design_display_data_div1">
            <img  src="${e.target.result}" />
            <input name="addedDesignArrayIndex" data-design-array-index=${designCount} hidden/>
            <input type="text" value="${e.target.result}" name="designs_list[${designCount}][image]" hidden/>
             <div class="input-icons">
                <i class="fa fa-dollar icon"></i>
                <input class="input-field" type="number" name="designs_list[${designCount}][price]"  placeholder="Design Price">
            </div>
            <input type="text" name="designs_list[${designCount}][title]"  placeholder="Design name">
            </div>`);

                }
                reader.readAsDataURL(this.files[0]);
            }


        })

        $(document).on("input", "input[name='image_text']", function () {
            const parent=this.parentNode;
            const arrayIndex=parent.querySelector("input[name='addedArtworkArrayIndex']").getAttribute("data-artwork-array-index");
            designsToUpload[arrayIndex]={...designsToUpload[arrayIndex],designName:this.value}
            console.log(designsToUpload);
        })


        $(document).on("input", "input[name='image_price']", function () {
            const parent=this.parentNode;
            const arrayIndex=parent.querySelector("input[name='addedArtworkArrayIndex']").getAttribute("data-artwork-array-index");
            designsToUpload[arrayIndex]={...designsToUpload[arrayIndex],designPrice:this.value}
            console.log(designsToUpload);
        })


        var frameCount =0;
        document.getElementById("uploadFrame")?.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                designsToUpload.push({
                    image: this.files[0]
                })
                reader.onload = function (e) {

                   var frames = document.getElementsByClassName("frame_display_data_div1");
                   frameCount=frames.length;
                    $("#productLayoutFrameContainer").append(`<div class="frame_display_data_div1">
                <img  src="${e.target.result}" />
                <input name="addedFrameArrayIndex" data-frame-array-index=${frameCount} hidden/>
                <input type="text" value="${e.target.result}" name="frames_list[${frameCount}][image]" hidden/>
             <div class="input-icons">
                <i class="fa fa-dollar icon"></i>
            <input class="input-field" type="number" name="frames_list[${frameCount}][price]"  placeholder="Frame Price">
            </div>
            <input type="text" name="frames_list[${frameCount}][title]"  placeholder="Frame name">
            </div>`);

                }
                reader.readAsDataURL(this.files[0]);
            }


        })

        function upload_featred_additinol($, current_btn) {



            var image = wp.media(

                {

                    title: 'Upload Image',

                    // multiple: true if you want to upload multiple files at once

                    multiple: true

                }

            ).open()

                .on('select', function () {

                    var uploaded_image = image.state().get('selection').first();

                    var image_url = uploaded_image.toJSON().url;

                    var fileName = image_url;

                    var fileExtension = (fileName.split('.').pop()).toUpperCase();

                    var upload_image_with = current_btn.data('upload_image_with') + current_btn.data('current-option-id');



                    $('.error_message').hide();



                    if ('PNG' == fileExtension) {


                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        console.log(uploaded_image);
                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        jQuery('#wpb_image_url').val(image_url);
                        jQuery('#featured_image_main').attr("src", image_url);



                    }



                }

                );

        }

    });



