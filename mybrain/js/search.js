
/*
 * Cache store for DOM queries.
 */
function SelectorCache() {
	var selectors = {};
	this.get = function(selector) {
		if(selectors[selector] === undefined) {
			selectors[selector] = $(selector);
		}
		return selectors[selector]; 
	}
}

function bindSearchEvents(){
	/**
	* Bind javascript events to the main view
	*/
	
	var searchEngine = new SearchEngine();
	var waitingTime = 500;
	var queryInput = selectorCache.get('#query');
	
	// Executes the search each time a character is entered in the input field
	// and after waiting for a bit to make sure no other character is entered.
	queryInput.keyup(function(event){
		if ((event.keyCode > 46 && event.keyCode < 91)
				|| event.keyCode == 8
				|| event.keyCode == 13){
			var timeoutID = window.setTimeout(
					searchEngine.search, waitingTime, queryInput.val());
			window.clearTimeout(timeoutID - 1);
		}
	});
	
	/* Bind search on tag click */
	var tagContainer = selectorCache.get(".tag_header");
	tagContainer.live("click", function(){
		var query = "tag:" + $(this).html();
		searchEngine.search(query);
	});
	/* Bind search on special tag click */
	var tagSwitch = selectorCache.get(".switch_header");
	tagSwitch.live("click", function(){
		if ($(this).attr("id") == "switch_all"){
			var query = "";
			searchEngine.search(query);
		}else if ($(this).attr("id") == "switch_none"){
			searchEngine.setResults("");
		}
	});
}
