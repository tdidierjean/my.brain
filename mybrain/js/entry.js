//  HACK:
//    jquery-1.5 sets up jsonp for all json ajax requests
//    undo the jsonp setting here so the json requests work again
jQuery.ajaxSetup({
  jsonp: null,
  jsonpCallback: null
});


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
				$(".edit_textarea").simpleautogrow();
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
	};
	
	this.validateEntryForm = function(form){
		//var form = container.find("form");
		form.validate({
			submitHandler:function(form){
				that.updateEntry(form);
				}
		});
		form.submit();		
	};
	
	this.updateEntry = function(form){
		var container = $(form).parents(".entry");
		var id_entry = container.attr("id");
		var input_fields = container.find("input, textarea[name='entry_details']");
		var tags = container.find(".tagEle");
		// Make a string out of the tags element -> necessary for sending with ajax
		var tagsConcat = "";
		tags.each(function(index){tagsConcat = tagsConcat + $(this).text() + " ";});

		/*if (input_fields[0].value == ""){
			alert("This needs a name");
			return;
		}*/
		/*var form = container.find("form");
		form.validate();
		form.valid();*/
		
		$.ajax({
				type: "POST",
				url: "actions/updateEntry.php", 
				dataType: "json",
				data:{
					id_entry:id_entry,
					name:input_fields[0].value,					
					details:input_fields[1].value,
					tags:tagsConcat
					},
				success:function(data){
					that.refreshEntryView(data, container);
					}
		});	
	};
	
	this.refreshEntryView = function(id_entry, container){
		$.get("actions/getEntryView.php", {id_entry:id_entry})
				.success(function(data){		
					container.replaceWith(data);
				});
	};

	this.editEntry = function(obj){
		var container = $(obj).parents(".entry");
		var id_entry = container.attr("id");
		$.ajax({
			type: "GET",
			data: {"id_entry":id_entry},
			url: "actions/getEntryEditView.php", 
			success: function(data){		
				container.replaceWith(data);
				$(".edit_textarea").simpleautogrow();
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