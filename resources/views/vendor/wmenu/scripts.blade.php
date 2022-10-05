<script>
	var menus = {
		"oneThemeLocationNoMenus" : "",
		"moveUp" : "Move up",
		"moveDown" : "Mover down",
		"moveToTop" : "Move top",
		"moveUnder" : "Move under of %s",
		"moveOutFrom" : "Out from under  %s",
		"under" : "Under %s",
		"outFrom" : "Out from %s",
		"menuFocus" : "%1$s. Element menu %2$d of %3$d.",
		"subMenuFocus" : "%1$s. Menu of subelement %2$d of %3$s."
	};
	var arraydata = [];     
	var addcustommenur= '{{ route("haddcustommenu") }}';
	var updateitemr= '{{ route("hupdateitem")}}';
	var generatemenucontrolr= '{{ route("hgeneratemenucontrol") }}';
	var deleteitemmenur= '{{ route("hdeleteitemmenu") }}';
	var deletemenugr= '{{ route("hdeletemenug") }}';
	var createnewmenur= '{{ route("hcreatenewmenu") }}';
	var csrftoken="{{ csrf_token() }}";
	var menuwr = "{{ url()->current() }}";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrftoken
		}
	});
</script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/scripts2.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/menu.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/harimayco-menu/plugins/js/fontawesome-iconpicker.js')}}"></script>
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
<script type="text/javascript">
	$(function() {
		$('.icp-dd').iconpicker();
	    $('.icp').on('iconpickerSelected', function(e) {
	    	$(this).parent().find('input').val(e.iconpickerValue);
	    	$(this).parent().find('.dropdown-menu').removeClass('show');
        });
    });

	jQuery(document).ready(function($) {
		$(document).on('click', '.btn-images', function(){
			var id = $(this).attr('data');
			window.open('/file-manager/fm-button?'+id, 'fm', 'width=1200,height=600');
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
        document.getElementById(id).src = $url;
        document.querySelector('.'+id).value = myArr[1];
    }
    

</script>