
/**
* Remove escaping characters from a string
*/
function unescapeText(text){
	// Escaped " or ' => remove all \
	text = text.replace(/(\\)+((&#039;)|(&quot;))/g, "$2");
	// Escaped \ => remove all \ but one
	text = text.replace(/(\\)+/g, "\\");
	return text;
}

/**
* Called by the "edit" link of an entry : retrieve entry from db and draw the edition form
*
* @param obj => a dom element from inside the entry row
*/
function editEntry(obj) {
	var div_entry = $(obj).parents("div.entryBody");
	var id_entry = div_entry.attr("name");
	
	$.post("actions/getEntryEditView.php", 
		{
			id_entry:id_entry
		},
		function(data){
			drawEditEntry(data, div_entry);
			//entryListTitle.find("input[name='entry_name']").focus();
			var accept = div_entry.find("a")[0];
			// Enter key validates the form if focus is on any input field,
			// but not if it's on textarea: it's still newline
			div_entry.find("input").keydown(function(event){
				if (event.keyCode == 13){
					$(accept).click();
				}
			});
		}
	  );	
}

/**
* Display an edit form
*
* @param data => an array containing the content of the entry as retrieved from db
* @param tr => the row where the form will be inserted
*/
function drawEditEntry(data, div_entry){	
	div_entry.html(data);
	/* Make the details textarea autogrow */
	div_entry.find(".editForm textarea").simpleautogrow();
}

/**
* Called by the "cancel" link of an entry edit form : cancel the edit and reset the entry display
*
* @param obj  => a dom element from inside the entry row
*/
function cancelEditEntry(obj){
	var entry_body = $(obj).parents(".entryBody");
	var id_entry = entry_body.attr("name");
	refreshEntry(id_entry, entry_body, "cancel");
}

/**
* Display a new entry form
*
* @param obj  => a dom element from inside the new entry row
*/
function newEntry(obj){
	var title_div = $(obj).parents("div.entryListHeader");
	var id_list = title_div.parent().attr("name");
	var accordion = title_div.next().find("div.accordion");

	/* If a new entry doesn't exists already, create one */
	//if (!accordion.find(".newAccordionEntry").length){
		var default_tags = $(title_div).parents("div.entryList").find("span.primary").text();

		$.post("actions/getNewEntryView.php", 
			{id_list:id_list},
			function(data){
				accordion.append(data);

				/* Reset accordion */
				accordion.accordion('destroy').accordion({
						collapsible: true,
						autoHeight: false,
						active: false});

				/* Set the entry as active */
				accordion.accordion("activate", accordion.find("h3:last"));
				//accordion.accordion("activate", accordion.find(".newAccordionEntry"));

				new_entry_div = accordion.find("div.editForm:last");

				/* Make the details textarea autogrow */
				/*accordion.find(".editForm textarea")*/
				new_entry_div.find("textarea").simpleautogrow();

				var accept = new_entry_div.find("a")[0];
				// Enter key validates the form if focus is on any input field,
				// but not if it's on textarea: it's still newline
				new_entry_div.find("input").keydown(function(event){
					if (event.keyCode == 13){
						$(accept).click();
					}
				});
			}
		);
	//}
}

/**
* Write a new entry to db and call a function to refresh the view
*
* @param obj => a dom element from inside the new entry row
*/
function createNewEntry(obj) {
	var new_entry_form = $(obj).parents("form");
	var id_list = 0;
	var input_fields = new_entry_form.find("input, textarea[name='entry_details']");
	
	$.post("actions/createEntry.php", 
			{
				id_list:id_list, 
				name:input_fields[0].value,
				url:input_fields[1].value, 
				details:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(data){
				refreshEntry(data, new_entry_form, "add");
			},
			"json"
		  );	
	return false;
}


/**
 * Display the new entry in place and an 'add new entry' button afterwards
 * 
 * @param id_entry => the new entry id
 * @param obj => a dom element from inside the new entry row
 */
 /*
function refreshEntryAfterAdd(id_entry, obj) {
	$.post("actions/getEntryFromDb.php", 
			{
				id_entry:id_entry
			},
			function(data){
				drawEntry(data, obj);
			},
			"json"
		  );	
}*/

/**
 * Retrieve an entry data and display it in place
 * 
 * @param id_entry => the entry id
 * @param obj => a dom element from inside the entry row
 */
function refreshEntry(id_entry, obj, context) {

	$.post("actions/getEntryView.php", 
			{
				id_entry:id_entry
			},
			function(data){	
				if (context == "edit"){
					drawEntryAfterEdit(id_entry, data, obj);
				}
				else if (context == "add"){
					drawEntry(data, obj);
				}
				else if (context == "cancel"){
					drawEntryAfterCancel(data, obj);
				}
			}
		  );	
}

/**
* Display an entry in place after an edit
*
* @param data => an array containing the content of the entry as retrieved from db
* @param obj => a dom element from inside the entry row
*/
function drawEntryAfterEdit(id_entry, data, obj) {
	// An entry can be displayed more than once the page,
	// so we make sure we update them all.
	var entries_h3 = $("h3." + id_entry + " a");
	var entries_bodies = $("div." + id_entry);
	
	var elements = $(data);
	entries_h3.html(elements.filter(".customAccordion").html());

	entries_bodies.empty().append(elements.filter(":not(.customAccordion)").html());
}

/**
* Display an entry in place after cancelling an edit
*
* @param data => an array containing the content of the entry as retrieved from db
* @param obj => a dom element from inside the entry row
*/
function drawEntryAfterCancel(data, obj) {
	if (!$(obj).hasClass("entryBody")){
		var entry_body = $(obj).parents("div.entryBody");//$("div." + id_entry);
	}else{
		var entry_body = $(obj);
	}
	var elements = $(data);
	entry_body.empty().append(elements.filter(":not(.customAccordion)"));
}

/**
* Display an entry in place
*
* @param data => an array containing the content of the entry as retrieved from db
* @param obj => a dom element from inside the entry row
*/
function drawEntry(data, obj) {
	var entry_block = getEntryBlock(obj);
	var edit_div = $(obj).parents("div.editForm");
	var edit_h3 = edit_div.prev();
	var accordion = edit_div.parents("div.entryContent").find("div.accordion");
	
	edit_h3.remove();
	edit_div.remove();
	accordion.append(data);
	
	/* Reset accordion */
	accordion.accordion('destroy').accordion({
			collapsible: true,
			autoHeight: false,
			active: false});
}

/**
* Write the memo to db
*/
function writeMemoToDb() {
	var memo = document.getElementById("memo");
	var container = $('#message_memo');
	
	// memo is empty ? Maybe something went wrong, cancel !
	if (!memo.value){
		container.html("Save cancelled: memo is empty !").effect('highlight',{color:'#c00'},2000);
		return;
	}
	
    $.ajax({
		type: "POST",
        url: "actions/updateMemo.php",
		data: {content: memo.value},
        success: function(data){
          container.html(data).
            effect("highlight",{color:'#3DFF8C'},2000);
        },
        error: function(req,error){
          if(error === 'error'){error = req.statusText;}
          var errormsg = 'Saved cancelled: '+error;
          container.html(errormsg).
            effect('highlight',{color:'#c00'},2000);
        },
        beforeSend: function(data){
          container.html('Saving...');
        }
    });

	//$.post("actions/writeMemoToDb.php", {content: memo.value});
}

/**
* Remove an entry from db and from display
*
* @param obj => a dom element from inside the entry row
*/
function deleteEntry(obj) {
	var div_entry = $(obj).parents("div.entryBody");
	var id = div_entry.attr("name");

	$.post("actions/deleteEntry.php", {id: id});
	
	// The entry can be displayed more than once
	// so we make sure all of them are removed from display
	$("." + id).remove();
}

/**
* Called by the entry edit form "accept" link : update an entry in db then refresh the view
*
* @param obj => a dom element from inside the entry row
*/
function updateEntry(obj){
	var div_entry = $(obj).parents("div.entryBody");
	var id_entry = div_entry.attr("name");
	var input_fields = div_entry.find("input, textarea[name='entry_details']");

	$.post("actions/updateEntry.php", 
			{
				id_entry:id_entry,
				name:input_fields[0].value,
				url:input_fields[1].value, 
				details:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(data){
				refreshEntry(id_entry, obj, "edit");	
			},
			"json"
		  );			  
}

/**
* Called by the entry edit form "cancel" link : cancel the creation of an entry -> remove the form
*
* @param obj => a dom element from inside the entry row
*/
function cancelNewEntry(obj){
	var editForm = $(obj).parents(".editForm");
	editForm.prev().remove();
	editForm.remove();
	}

/**
* Bind javascript events to the main view
*/
function bindEvents(){
	/* Setup accordion */
	$(".accordion").accordion({
		collapsible: true,
		autoHeight: false,
		active: false,
		animated: false
	});

	/* Bind tag toggle on click */
	$("div.tags span").live("click", function(){
		toggleTag($(this));
	});
	
	/* Bind create new entry on click */
	$("a.newEntry").live("click", function(){
		newEntry(this);
		return false;
	});
	
	/* Bind edit entry on click */
	//$("a.editEntry").live("click", function(){
	$("div.entryContent").delegate("a.editEntry", "click", function(){
		editEntry(this);
		return false;
	});	
	
	/* Bind delete entry on click */
	$("a.deleteEntry").live("click", function(){
		deleteEntry(this);
		return false;
	});

	/* Bind open zoom window on click*/
	$("a[rel]").live("click", function() {
		$("<div class='apple_overlay blocShadows'></div>")
			.load($(this).attr('href'))
			.dialog({
				autoOpen: false,
				draggable: false,
				title: $(this).attr('title'),
				width: 500,
				height: 300
			}).dialog('open');	
			
		return false;
	});
	
	/* Bind toggle list on click */
	$(".entryListTitle").live("click", function() {
		moreEntryList(this);
		return false;
	});
	
	/* Bind edit list on click */
	$("a.editList").live("click", function(){
		editEntryList(this);
		return false;
	});
	
	/* Bind accept edit list on click
	   Note : the element is not present when the page load but can be added later */
	$("a.acceptEditList").live("click", function(){
		updateEntryList(this);
		return false;
	});

	/* Bind cancel edit list on click
	   Note : the element is not present when the page load but can be added later */
	$("a.cancelEditList").live("click", function(){
		cancelEditEntryList(this);
		return false;
	});
	
	/* Bind new list on click */
	$("a.newList").live("click", function(){
		newEntryList();
		return false;
	});
	
	/* Bind accept edit entry on click
	   Note : the element is not present when the page load but can be added later */
	$("a.acceptEditEntry").live("click", function(){
		updateEntry(this);
		return false;
	});

	/* Bind cancel edit entry on click
	   Note : the element is not present when the page load but can be added later */
	$("a.cancelEditEntry").live("click", function(){
		cancelEditEntry(this);
		return false;
	});
	
	/* Bind accept new entry on click
	   Note : the element is not present when the page load but can be added later */
	$("a.acceptNewEntry").live("click", function(){
		createNewEntry(this);
		return false;
	});

	/* Bind cancel new entry on click
	   Note : the element is not present when the page load but can be added later */
	$("a.cancelNewEntry").live("click", function(){
		cancelNewEntry(this);
		return false;
	});

	/* Bind accept create new list on click
	   Note : the element is not present when the page load but can be added later */
	$("a.acceptCreateList").live("click", function(){
		createNewEntryList(this);
		return false;
	});
}

/**
* For a given tag element, toggle the display of entries linked with this tag
* If the tag value is "all" or "none", call the toggleAll function instead
*
* @param tag => the tag as a string
*/
function toggleTag(tag){
	tag_text = $.trim(tag.html());
	entry_list = tag.parents(".entryList");
	entry_list.find("div.accordion").accordion('activate', false);
	if (tag_text == "all" || tag_text == "none"){
		toggleAllTags(tag_text, entry_list);
		return;
	}
	
	// toggle the tag in the list header
	tag.toggleClass("selected");
	// for each entry with the tag
	entries = entry_list.find("div.entryTags span:contains(" + tag_text + ")");
	entries.each(function(){
		// if the entry has other tags, we have to check if the entry is to be toggled
		siblings = $(this).siblings("span");
		if (siblings.length){
			// if any other tag is selected, then changing this tag doesn't affect the entry visibility
			var state = false;
			siblings.each(function(){
				tag_sibling = $(this).html();
				selected = entry_list.find("div.tags span:contains(" + tag_sibling + ")").hasClass("selected");
				if (selected){
					state = true;
					return false;
				}
			});
			// no other tag is selected : the tag toggle affects the entry visibility
			if (!state){
				$(this).parents("div.entryBody").prev().toggle();
			}
		}
		// no other tag ? toggle !
		else{	
			$(this).parents("div.entryBody").prev().toggle();
		}
	});
}
/**
* Toggle the display of all tags at once :
* hide all tags, or show all tags
*
* @param tag_text the tag switch as a string : "all", or "none"
* @param entry_list the entry list as a dom element
*/
function toggleAllTags(tag_text, entry_list){
	tagged_entries = entry_list.find("div.entryTags span:not(:empty)").parents("div.entryBody").prev();
	tag_headers = entry_list.find("span.tag_header");
	if (tag_text == "none"){
		tagged_entries.hide();
		tag_headers.removeClass("selected");
	}
	else{
		tagged_entries.show();
		tag_headers.addClass("selected");
	}	
}

function toggleEntryTags(entry_list){
	entry_list.find("div.tags span:not(:empty)").toggleClass("hidden");
}

function editEntryList(obj){
	var entryList = $(obj).parents("div.entryList");
	var entryListTitle = entryList.find("div.entryListTitle");
	var id_list = entryList.attr("name");
	
	$.post("actions/getListEditView.php", 
		{
			id_list:id_list
		},
		function(data){
			drawEditEntryList(data, entryListTitle);
			entryListTitle.find("input[name='entry_name']").focus();
			var accept = entryListTitle.find("a")[0];
			// Enter key validates the form if focus is on any input field,
			// but not if it's on textarea: it's still newline
			entryListTitle.find("input").keydown(function(event){
				if (event.keyCode == 13){
					$(accept).click();
				}
			});
		}
	  );	
}

function drawEditEntryList(data, entryListTitle){
	entryListTitle.html(data);
	entryListTitle.next().hide();
}

function updateEntryList(obj){
	var entryList = $(obj).parents("div.entryList");
	var id_list = entryList.attr("name");
	var input_fields = entryList.find(":input");

	$.post("actions/updateList.php", 
			{
				id_list:id_list,
				title:input_fields[0].value,
				col:input_fields[1].value, 
				rank:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(){
				refreshEntryList(id_list, entryList);	
			}
		  );			  
}

function refreshEntryList(id_list, entryList) {
	$.post("actions/getListHeaderView.php", 
			{
				id_list:id_list
			},
			function(data){
				drawEntryList(data, entryList);
			}
		  );	
}

function drawEntryList(data, entryList) {
	$(entryList).find("div.entryListTitle").html(data);
	$(entryList).find("div.entryListTags").show();
}

/**
* Cancel the edit of an entry list and restore the display
*/
function cancelEditEntryList(obj){
	var entryList = $(obj).parents("div.entryList");
	var id_list = entryList.attr("name");
	refreshEntryList(id_list, entryList);
}

/**
* Toggle an entire entry list
*/
function moreEntryList(obj) {
	var collapsed;
	var entryList = $(obj).parents("div.entryList");
	var content = entryList.find("div.entryContent");
	// toggle the tag headers
	entryList.find("div.tags").toggle();

	// toggle the entries
	content.toggle();
	
	// Update collapsed bool in db
	var id = entryList.attr("name");
	if (content.is(":visible")){
		collapsed = 0;
	}else{
		collapsed = 1;
	}
	$.post("actions/updateListCollapse.php", 
			{
				id_list:id,
				collapsed:collapsed
			}
	);		
}

/**
* Delete an entry list
*/
function deleteEntryList(obj){
	var tr = $(obj).parents("tr");
	var id = tr.attr("name");

	var html = "<td>Delete this list ? " +
				"<a href='javascript:confirmDeleteEntryList(this)'>Yes</a>" +
				"<a href='javascript:cancelEditEntryList(this)'>No</a>" +
				"</td>";
	tr.html(html);
}

/*
function getAllTags(obj, id_list){
	$(obj).load("actions/getAllTags.php", {"id_list":1});
}
*/

function getEntryBlock(obj){
	var div_entry = $(obj).parents("div.entryBody");
	// il faut reussir a le faire avec un truc genre previous sibling
	var id_entry = div_entry.attr("name");
	var h3_entry = $("h3." + id_entry);
	return {"h3":h3_entry, "div":div_entry};
}

function newEntryList(){
	$.post("actions/getNewListView.php", 
			function(data){
				$("#col2").append(data);
			}
	);
}

function createNewEntryList(obj){
	var entryList = $(obj).parents("div.entryList");
	var input_fields = entryList.find(":input");

	$.post("actions/createList.php", 
			{
				title:input_fields[0].value,
				col:input_fields[1].value, 
				rank:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(){
				refreshEntryList(data['id_list'], entryList);	
			}
		  );			  
}