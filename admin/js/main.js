jQuery(document).ready(function( $ ) {

    $("#pdf-preview-button").click(function(){
        //get value
        var pdf_fay_url = $('#pdf-url-fay').val();
        var pdf_fay_width = $('#pdf-width-fay').val()+$('#pdf-width-type').val();
        var pdf_fay_height = $('#pdf-height-fay').val()+$('#pdf-height-type').val();
        var pdf_fay_align = $('#pdf-align-fay').val();

        //Set value to iframe
        $('#preview-iframe').attr('width',pdf_fay_width);
        $('#preview-iframe').attr('height',pdf_fay_height);
        $('#container-iframe').css('text-align',pdf_fay_align);
        if(pdf_fay_url === ''){
            $('#preview-iframe').attr('src','');
            Swal.fire(
                'Error!',
                'Url of PDF is empty!',
                'error'
            );
        }
        else {
            var pdf_fay_short_code = "[pdf_fay src='"+pdf_fay_url+ "' width='"+pdf_fay_width+"' height='"+pdf_fay_height+"' position='"+pdf_fay_align+"'/]";
            $('#pdf-input-generate').val(pdf_fay_short_code);

            $('#preview-iframe').attr('src',pdf_fay_url);
        }
    });

    $("#pdf-btn-generate").click(function(){
        //get value
        var pdf_fay_url = $('#pdf-url-fay').val();
        var pdf_fay_width = $('#pdf-width-fay').val()+$('#pdf-width-type').val();
        var pdf_fay_height = $('#pdf-height-fay').val()+$('#pdf-height-type').val();
        var pdf_fay_align = $('#pdf-align-fay').val();

        if(pdf_fay_url === ''){
            Swal.fire(
                'Error!',
                'Url of PDF is empty!',
                'error'
            );
            $('#preview-iframe').attr('src','');
            return false;
        }
        $('#preview-iframe').attr('width',pdf_fay_width);
        $('#preview-iframe').attr('height',pdf_fay_height);
        $('#preview-iframe').attr('src',pdf_fay_url);
        $('#container-iframe').css('text-align',pdf_fay_align);


        var pdf_fay_short_code = "[pdf_fay src='"+pdf_fay_url+ "' width='"+pdf_fay_width+"' height='"+pdf_fay_height+"' position='"+pdf_fay_align+"'/]";
        $('#pdf-input-generate').val(pdf_fay_short_code);
        Swal.fire(
            'Good job!',
            'Shortcode Generated!',
            'success'
        )
    });

    $("#pdf-copy-generate").click(function(){
        var pdf_fay_url = $('#pdf-url-fay').val();
        var pdf_generated_code = $('#pdf-input-generate').val();
        if(pdf_fay_url === '' || pdf_generated_code === ''){
            Swal.fire(
                'Error!',
                'Url of PDF OR ShortCode is empty!',
                'error'
            );
            return false;
        }
        else {
            var pdf_fay_width = $('#pdf-width-fay').val()+$('#pdf-width-type').val();
            var pdf_fay_height = $('#pdf-height-fay').val()+$('#pdf-height-type').val();
            var pdf_fay_align = $('#pdf-align-fay').val();

            // Get the text field
            var copyText = $("#pdf-input-generate").val();

            // Copy the text inside the text field


            navigator.clipboard.writeText(copyText).then(() => {
                // Alert the user that the action took place.
                // Nobody likes hidden stuff being done under the hood!
                Swal.fire(
                    'Good job!',
                    'Copy To Clipboard!',
                    'success'
                )
            });


        }
    });

});

