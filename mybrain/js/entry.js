function Entry(){
	var that = this;
	
	this.toggleEntry = function(entryDiv){
		entryDiv.find(".entryContent").toggleClass("hidden");
	};
	
	this.newEntry = function(container){
		$.post("actions/getEntryEditView.php", 
			function(data){		
				container.prepend(data);
			}
		);
	};
	
	this.updateEntry = function(container){
		var id_entry = container.attr("id");
		var input_fields = container.find("input, textarea[name='entry_details']");

		$.post("actions/updateEntry.php", 
				{
					id_entry:id_entry,
					name:input_fields[0].value,
					url:input_fields[1].value, 
					details:input_fields[2].value,
					tags:input_fields[3].value
				},
				function(data){
					that.refreshEntryView(data, container);
				},
				"json"
			  );			  
	}
	
	this.refreshEntryView = function(id_entry, container){
		$.post("actions/getEntryView.php", 
				{id_entry:id_entry},
				function(data){		
					container.replaceWith(data);
				}
			);
	}
}