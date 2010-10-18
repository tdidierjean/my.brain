function SearchEngine(){
	var that = this;
	this.search = function(query){
		$.get("actions/search.php", 
				{
					query:query
				},
				function(data){
					$("div#resultsDiv").html(data);
					$(".accordion").accordion({
						collapsible: true,
						autoHeight: false,
						active: 0,
						animated: false
					});
				}
			  );	
		//dans une methode, on utilise that au lieu de this
		//c'est parce que si la méthode est appelée de l'extérieur, par ex par un bind
		//le this sera une référence à window et pas à l'objet
	};
}