function bindEv(){
	/* Bind entry toggle on click */
	$(".entryName").live("click", function(){
		var entryDiv = $(this).parents(".entry");
		entry.toggleEntry(entryDiv);
	});
	/* Bind create entry on click */
	$("#createEntry").live("click", function(){
		var container = selectorCache.get("div#entriesList");
		entry.newEntry(container);
	});	
	/* Bind accept edit entry on click */
	$("a.acceptEditEntry").live("click", function(){
		entry.updateEntry($(this).parents(".entry"));
	});
}

var selectorCache = new SelectorCache();
var entry = new Entry();

