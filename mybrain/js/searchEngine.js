
/*
 * Handles querying on the client side
 */
function SearchEngine(){
	var that = this;
	this.messageContainer = selectorCache.get("#searchState");
	this.resultsContainer = selectorCache.get("div#resultsDiv");
	
	/*
	 * Call the php script that executes the querying and display results
	 */
	this.search = function(query){
		$.ajax({
			type: "GET",
		    url: "actions/search.php",
			data: {query: query},
		    success: function(data){
				var message;
				if ($.trim(data).length){
					message = "Done";
				}else{
					message = "No results";
				}
		        that.messageContainer.html(message);
		        // .effect("highlight",{color:'#3DFF8C'},2000);
				that.resultsContainer.html(data);
				$(".accordion").accordion({
					collapsible: true,
					autoHeight: false,
					active: 0,
					animated: false
				});
		    },
		    error: function(req,error){
		      if(error === 'error'){error = req.statusText;}
		      var errormsg = 'Saved cancelled: '+error;
		      that.messageContainer.html(errormsg).
		        effect('highlight',{color:'#c00'},2000);
		    },
		    beforeSend: function(){
		    	that.messageContainer.html('Searching...');
		    }
		});
	};
}
