
$(document).ready(function() { 
//console.log($('td[name=zoom_entry] img'));
	$.fn.qtip.styles.mystyle = {
		background: '#CFDDE7',
		border: {
			width: 1,
			radius: 4,
			color: '#6699CC'
		}
	};
	 
	var mypos = {
			corner: {
				target: 'topRight',
				tooltip: 'bottomLeft'
			}
		};
	var show = { delay: 800 };
	
	$('a img.eye').qtip({
		content: 'Display/hide tags under each entry',
		show: show,
		style: 'mystyle',
		position: mypos
	});
	
	$('td[name=zoom_entry] img').qtip({
		content: 'View this entry in a popup',
		show: show,
		style: 'mystyle',
		position: mypos
	});
	
	$('td[name=more_entry] img').qtip({
		content: 'Expand or collapse details',
		show: show,
		style: 'mystyle',
		position: mypos
	});	
	
	$('td[name=edit_entry] img').qtip({
		content: 'Edit this entry',
		show: show,
		style: 'mystyle',
		position: mypos
	});	

	$('td[name=delete_entry] img').qtip({
		content: 'Delete this entry',
		show: show,
		style: 'mystyle',
		position: mypos
	});	
});