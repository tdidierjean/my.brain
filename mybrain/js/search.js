/**
* Bind javascript events to the main view
*/
searchEngine = new SearchEngine();

function bindSearchEvents(){
	
	/* Bind tag toggle on click */
	//$("#searchDiv form").live("submit", function(){
	var timer = 5;
	$("#searchDiv form [name=query]").keyup(function(){
		var timeoutID = window.setTimeout("searchEngine.search($('#searchDiv form [name=query]').val())", 500);
		console.log(timeoutID - 1);
		window.clearTimeout(timeoutID - 1);
		return false;
	});
}
