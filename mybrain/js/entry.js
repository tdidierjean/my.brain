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
			}/*,
			complete: function(){
				new nicEditor(
						{//fullPanel : true,
						 buttonList: ['bold']
					}).panelInstance('edit',{hasPanel : true});
				//nicEditors.allTextAreas();
				}*/
			}
		
		);
		
		//that.editor = new nicEditor({fullPanel : true}).panelInstance('edit',{hasPanel : true});
	};
	
	this.updateEntry = function(container){

		var id_entry = container.attr("id");
		var input_fields = container.find("input, textarea[name='entry_details']");
		if (input_fields[0].value == ""){
			alert("This needs a name");
			return;
		}
		
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
	
	this.editEntry = function(obj){
		var container = $(obj).parents(".entry");
		var id_entry = container.attr("id");
		$.ajax({
			type: "GET",
			data: {"id_entry":id_entry},
			url: "actions/getEntryEditView.php", 
			success: function(data){		
				container.html(data);
			}
		});
	};
	
	this.deleteEntry = function(obj){
		var div_entry = $(obj).parents(".entry");
		var id = div_entry.attr("id");
		$.post("actions/deleteEntry.php", {id: id});
		div_entry.remove();		
	};
}