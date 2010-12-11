function Entry(){
	var that = this;
	this.editor;
	this.toggleEntry = function(entryDiv){
		entryDiv.find(".entryContent").toggleClass("hidden");
	};
	
	this.newEntry = function(container){
		$.ajax({
			type: "GET",
			url: "actions/getEntryEditView.php", 
			success: function(data){		
				container.prepend(data);
			},
			complete: function(){
				new nicEditor(
						{//fullPanel : true,
						 buttonList: ['bold']/*, 
						 onSave : function(content, id, instance) {
						    alert('save button clicked for element '+id+' = '+content);
						  }*/
					}).panelInstance('edit',{hasPanel : true});
				//nicEditors.allTextAreas();
				}}
		
		);
		
		//that.editor = new nicEditor({fullPanel : true}).panelInstance('edit',{hasPanel : true});
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
	
	this.editEntry = function(){};
	this.deleteEntry = function(){};
}