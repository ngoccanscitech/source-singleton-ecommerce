jQuery(document).ready(function($) {
	$(document).on('click', '.product-delete', function(){
		$.confirm({
            'title'     : 'Xác nhận xóa',
            'content'   : 'Bạn chắc chắn muốn xóa?<br>Bài viết của bạn sẽ bị xóa vĩnh viễn!',
            'buttons'   : {
                'Yes'   : {
                	text: 'Xác nhận',
                    'class' : 'blue',
                    'action': function(){
                        // delete_post(url);
                    }
                },
                'No'    : {
                	text: 'Hủy',
                    'class' : 'gray',
                    'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
                }
            }
        });
        return false;
	});
});