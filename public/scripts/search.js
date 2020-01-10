$(document).ready(function() {
	$(document).on('click','.toSearch',function(e){	
		e.preventDefault(); //stop page request
		var text = $('.search').val();

		window.location.href = "/search/"+text;
	});
	
	function isEmpty(str) {
		if (str.trim() == '') 
			return true;
    
		return false;
	}
	
	$(document).keypress(function(e) {
		if(e.which == 13) {
			var text = $('.search').val(); 
			if(!isEmpty(text))
				window.location.href = "/search/"+text;
		}
	});
});