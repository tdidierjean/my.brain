
$(document).ready(function() { 

    /*$('td[name=zoom_entry] img').tooltip({ 
        tip: '#tooltip_zoom', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
        predelay: 600
    });*/

    $('td[name=more_entry] img').tooltip({ 
        tip: '#tooltip_more', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
        predelay: 600
    });
	
	$('td[name=edit_entry] img').tooltip({ 
        tip: '#tooltip_edit', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
        predelay: 600
    });
	
	$('td[name=delete_entry] img').tooltip({ 
        tip: '#tooltip_delete', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
        predelay: 600
    });
	
	$('a img.eye').tooltip({ 
        tip: '#tooltip_eye', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
        predelay: 600
    });
	
	$('td[name=zoom_entry] img').tooltip({ 
        tip: '#table_tooltip', 
        position: 'center right', 
        offset: [0, 15], 
        lazy: true, 
		delay:600
    });
});