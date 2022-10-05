jQuery(document).ready(function($){
	$('#selectall').click(function() {
		var checkboxes = $('#table_index').find(':checkbox');
		if($(this).is(':checked')) {
			//checkboxes.attr('checked', 'checked');
			$(':checkbox').prop('checked',true);
		} else {
			//checkboxes.removeAttr('checked');
			$(':checkbox').prop('checked',false);
		}
	});

    $(document).on('keyup', '#price, #acreage', function(event) {
        if(event.which >= 37 && event.which <= 40) return;
      
          // format number
          $(this).val(function(index, value) {
            return value
            .replace(/\D/g, "")
            .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            ;
          });
    })
    var place_select = $('.place_select');
    if(place_select.length>0){
        place_select.each(function(index, el) {
            $(this).on('change', function(){
                var type = $(this).data('type'),
                    child = $(this).data('child'),
                    id = $(this).val();
                get_place(type, id, child);
                get_address_full();
            });
        });
    }

    //delete post
    $('.delete-post').click(function(event) {
        var url = $(this).data('url');
        
        $.confirm({
            'title'     : 'Delete Confirmation',
            'message'   : 'You are about to delete this option. <br />It cannot be restored at a later time! Continue?',
            'buttons'   : {
                'Yes'   : {
                    'class' : 'blue',
                    'action': function(){
                        delete_post(url);
                    }
                },
                'No'    : {
                    'class' : 'gray',
                    'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
    });
});

function get_address_full() {
    var address_full = $( ".place_select" ).map(function() {
        var val = $(this).find('option:selected').val();
        if(val!='')
          return $( this ).find('option:selected').text();
    }).get();
    address_full = address_full.reverse();

    $('#address').val(address_full.join(', '));
  }

function get_place(type, id, child) {
    axios({
        method: 'post',
        url: 'place-select/'+type,
        data: {id:id}
    }).then(res => {
      $('.' + child).html(res.data);
    }).catch(e => console.log(e));
  
}

function select_all() {
    (function ($) {
        var checkboxes = $('#table_index').find(':checkbox').each(function(){
        	if($(this).is(':checked')) {
				//checkboxes.attr('checked', 'checked');
				$(':checkbox').prop('checked',true);
			} else {
				//checkboxes.removeAttr('checked');
				$(':checkbox').prop('checked',false);
			}
        });
    })(jQuery);
}
function delete_post(url) {
    arr = [];
    var post_list = $( 'input[name="post_list[]"]:checked' ).map(function() {
        arr.push($(this).val());
    }).get();
    axios({
        method: 'POST',
        url: url,
        data: {post_list:arr}
    }).then(res => {
        $('input[name="post_list[]"]:checked').each(function(){
           $('.item-'+ $(this).val()).remove();
        }); //each
        $.alert({
            'title'     : 'Delete done',
            'content'   : ''
        });
    }).catch(e => console.log(e));
}
function delete_id(type) {
    arr = new Array();
    var con = 0;
    $('input[name="seq_list[]"]:checked').each(function(){
       arr = $('input:checkbox').serializeArray();
       arr.push({ name: "_token", value: getMetaContentByName('csrf-token') });
       arr.push({ name: "type", value: type });
    }); //each

    if(arr.length==0){
        alert('Vui lòng chọn mục cần xóa!');
        return false;
    }
    var info_user_admin="";
    if(type=="user_admin"){
        info_user_admin = "Xóa tài khoản nhân viên sẽ xóa tất cả sản phẩm, đơn hàng thuộc tài khoản này! \n";
    }
    if(confirm(info_user_admin+"Are you sure delete?")){
        (function ($) {
            
            $.ajax({
                type: "POST",
                url: admin_url+"/delete-id",
            data: arr ,//pass the array to the ajax call
            cache: false,
            beforeSend: function() {

            },
            success: function(){
                location.reload();
            }
        });//ajax
        })(jQuery);
    }
    else{
        return false;
    }
}
function update_theme_fast(product_id) {
    (function ($) {
    	var origin_price=$('#origin-price-'+product_id).val();
	    var promotion_price=$('#promotion-price-'+product_id).val();
	    // var order_short=$('#order_short-'+product_id).val();
        var start_event = $('#start-event-'+product_id).val();
        var end_event = $('#end-event-'+product_id).val();
	    // if(order_short !=''){
	    //     order_short=parseInt($('#order_short-'+product_id).val());
	    // }else{
	    //     order_short=0;
	    // }
	    $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_theme_fast",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'id' : product_id,
                'origin_price':origin_price,
                'promotion_price':promotion_price,
                // 'order_short':order_short,
                'start_event': start_event,
                'end_event': end_event
            },
            dataType:"text",
            cache: false,
            beforeSend: function(){

            },
            success: function(status){
                $('#alert_'+product_id).html(status);
                $('#alert_'+product_id).show();
          	}
        });//ajax
    })(jQuery);
}
function new_item_click(product_id) {
    (function ($) {
        if($('#toggle-new-item-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_new_item",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function flash_sale_click(product_id) {
    (function ($) {
        if($('#toggle-flash-sale-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_flash_sale",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function sale_top_week_click(product_id) {
    (function ($) {
        if($('#toggle-sale-top-week-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_sale_top_week",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function propose_click(product_id) {
    (function ($) {
        if($('#toggle-propose-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_propose",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function store_status_click(product_id) {
    (function ($) {
        if($('#toggle-store-status-'+product_id+':checkbox:checked').length > 0){
            var check = 1;
        }else{
            var check = 0;
        }
        $.ajax({
            type: "POST",
            url: admin_url+"/ajax/process_store_status",
            data: {
                '_token': getMetaContentByName('csrf-token'),
                'check' : check,
                'sid':product_id
            },
            dataType:"text",
            cache: false,
            beforeSend: function() {
	            
            },
            success: function(status)
            {
                
            }
        });//ajax
    })(jQuery);
}

function loadFile(event){
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileIcon(event){
    var output = document.getElementById('output_icon');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileSlishow_pc(event){
    var output = document.getElementById('output_slishow_pc');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function loadFileSlishow_mobile(event){
    var output = document.getElementById('output_slishow_mobile');
    output.src = URL.createObjectURL(event.target.files[0]);
}

function getMetaContentByName(name,content){
   var content = (content==null)?'content':content;
   return document.querySelector("meta[name='"+name+"']").getAttribute(content);
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

// slider insert
jQuery(document).ready(function($) {
    var insert_slider = $('.insert-slider');
    if(insert_slider.length>0){
        $('#form-inserSlider, #form-editSlider').validate({
            onfocusout: false,
            onkeyup: false,
            onclick: false,
            rules: {
                name: "required",
                src: "required",
            },
            messages: {
                name: "Vui lòng nhập tên",
                src: "Chọn hình ảnh",
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxtModal',
            invalidHandler: function(event, validator) {
            }
        });

        $(document).on('click', ('.insert-slider'),function(){
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            //rest of your code
            
            var type = $(this).attr('data');
            var from = $('#form-inserSlider');
            if(type=='edit')
                from = $('#form-editSlider');
            
            if(from.valid()){
                var dataString = from.serialize();
                axios({
                    method: 'POST',
                    url: 'admin/slider/insert',
                    data: dataString,
                }).then(res => {
                    if(res.data!=''){
                        $('#inserSlider form')[0].reset();
                        $('#inserSlider').modal('hide');
                        $('#editSlider').modal('hide');
                        $('.slider-items').html(res.data);
                    }
                    else{
                        
                    }
                    // check_out_frm.find('.loading').addClass('loader');
                }).catch(e => console.log(e));
            }
        });

        //edit slider
        $(document).on('click', '.edit-slider', function(){
            var id = $(this).attr('data');
            if(id){
                axios({
                    method: 'POST',
                    url: 'admin/slider/edit',
                    data: {id:id},
                }).then(res => {
                    if(res.data!=''){
                        $('.content-html').html(res.data);
                        $('#editSlider').modal('show');
                    }
                    else{
                        
                    }
                    // check_out_frm.find('.loading').addClass('loader');
                }).catch(e => console.log(e));
            }
        });
        //delete slider
        $(document).on('click', '.delete-slider', function(){
            var id = $(this).attr('data'),
                this_ = $(this);
            if(id){
                axios({
                    method: 'POST',
                    url: 'admin/slider/delete',
                    data: {id:id},
                }).then(res => {
                    if(res.data!=''){
                        $('.content-html').html(res.data);
                    }
                    else{
                        this_.closest('.slider-items').remove();
                    }
                    // check_out_frm.find('.loading').addClass('loader');
                }).catch(e => console.log(e));
            }
        });
    }
});
// slider insert

//file manager
jQuery(document).ready(function($) {
    $(document).on('click', '.btn-images', function(){
        var id = $(this).attr('data');
        window.open('/admin/media-manager/fm-button?'+id, 'fm', 'width=1200,height=600');
    });

    $('.remove-icon').click(function(event) {
        var img = $(this).data('img');
        $(this).parent().find('img').attr('src', img);
        $(this).parent().find('input[type="hidden"]').val('');
        $(this).hide();
    });

});
// set file link
function fmSetLink($url, id="preview_image") {
    const myArr = $url.split("storage/");
    document.getElementById(id).value = myArr[1];
    $('.'+id).attr('src', $url);
    document.getElementsByClassName(id).src = 'test.jpg';
    // document.querySelector('.'+id).value = myArr[1];
}
//file manager

//ckeditor
function editor(text){
    CKEDITOR.replace(text,{
        width: '100%',
        resize_maxWidth: '100%',
        resize_minWidth: '100%',
        height:'300',
        filebrowserBrowseUrl: '/ckfinder/browser',
    });
    CKEDITOR.instances[text];
}

//ckeditor
function editorQuote(text){
    CKEDITOR.replace( text, {
        filebrowserBrowseUrl: '/ckfinder/browser',
        toolbar: [
            [ 'Source', 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
            [ 'FontSize', 'TextColor', 'BGColor' ],
            [ 'Image' ],
            [ 'btgrid' ],
            ['txtEmbed', 'chkAutoplay']
        ],
        height: '150px'
    });
}


//ckfinder
jQuery(document).ready(function($) {
    $('.ckfinder-popup').each(function(index, el) {
        var id = $(this).attr('id'),
            input = $(this).attr('data'),
            view_img = $(this).data('show');
        var button1 = document.getElementById( id );
        button1.onclick = function() {
            selectFileWithCKFinder( input, view_img );
        };
    });
});

function selectFileWithCKFinder( elementId, view_img ) {
    CKFinder.modal( {
        chooseFiles: true,
        width: 1000,
        height: 600,
        onInit: function( finder ) {
            finder.on( 'files:choose', function( evt ) {
                var file = evt.data.files.first();
                var output = document.getElementById( elementId );
                    // console.log(output_view);
                output.value = file.getUrl();
                if(view_img!='')
                    $('.'+view_img).attr('src', file.getUrl());
            } );

            finder.on( 'file:choose:resizedImage', function( evt ) {
                var output = document.getElementById( elementId );
                output.value = evt.data.resizedUrl;
                if(view_img!='')
                    $('.'+view_img).attr('src', evt.data.resizedUrl);
            } );
        }
    } );
}