$(function() {
	$('.sort tbody').sortable({
		cursor: 'move',
		axis:   'y',
		update: function(e, ui) {
			$(this).sortable("refresh");
			var current_url = window.location.href; 

			var order = $(this).sortable("serialize") + '&eID=sortupdate&target='+target;

			var path_to_script = 'index.php';
			document.body.style.cursor = "progress";
			$.post(path_to_script, order, function(theResponse){
				if (theResponse=='Ok') 
					ui.item.effect("highlight", {color: '#00ff00'}, 2000);
				else 
					ui.item.effect("highlight", {color: '#ff0000'}, 2000);
				document.body.style.cursor = "auto";
			});
		}
	});
})

