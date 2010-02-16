
/**
* Called by the "edit" link of an entry : retrieve entry from db and draw the edition form
*
* @param obj => a dom element from inside the entry row
*/
function editEntry(obj) {
	var tr = $(obj).parents("tr");
	var id_entry = tr.attr("name");
	
	$.post("actions/getEntryFromDb.php", 
		{
			id_entry:id_entry
		},
		function(data){
			drawEditEntry(data, tr);
			tr.find("input[name='entry_name']").focus();
			var accept = tr.find("img")[0];
			// Enter key validates the form if focus is on any input field,
			// but not if it's on textarea: it's still newline
			tr.find("input").keydown(function(event){
				if (event.keyCode == 13){
					$(accept).click();
				}
			});
		},
		"json"
	  );	
}

/**
* Display an edit form
*
* @param data => an array containing the content of the entry as retrieved from db
* @param tr => the row where the form will be inserted
*/
function drawEditEntry(data, tr){
	html = "<td colspan=5><form><table class='edit_table'><tr><td><label for='entry_name'>Name </label></td><td><input name='entry_name' value='" + data['name'] + "' /></td></tr>"
			 + "<tr><td><label for='entry_url'>Url </label></td><td><input name='entry_url' value ='" + data['url'] + "' /></td></tr>"
			 + "<tr><td><label for='entry_details'>Details </label></td><td><textarea name='entry_details'>" + data['details'] + "</textarea></td></tr>"
			 + "<tr><td><label for='entry_tags'>Tags</label></td><td><input name='entry_tags' value ='" + data['tags'] + "' /></td></tr></table>"
			 + "<img src='images/accept.gif' alt='Create' onclick='updateEntryInDb(this)' class='imgAccept'/>"
			 + "<img src='images/cross.png' onclick='cancelEdit(this)' alt='Cancel' class='imgAccept'/></form></td>";
	tr.html(html);
}

/**
* Called by the "cancel" link of an entry edit form : cancel the edit and reset the entry display
*
* @param obj  => a dom element from inside the entry row
*/
function cancelEdit(obj){
	var tr = $(obj).parents("tr");
	var id_entry = tr.attr("name");
	refreshEntry(id_entry, obj);
}

/**
* Display a new entry form
*
* @param obj  => a dom element from inside the new entry row
*/
function newEntry(obj){
	source_tr = $(obj).parents("tr");
	
	new_tr = "<tr class='entryRow'><td colspan=5><form><table class='edit_table'><tr><td><label for='entry_name'>Name </label></td><td><input name='entry_name' /></td></tr>"
			 + "<tr><td><label for='entry_url'>Url </label></td><td><input name='entry_url' /></td></tr>"
			 + "<tr><td><label for='entry_details'>Details </label></td><td><textarea name='entry_details'></textarea></td></tr>"
			 + "<tr><td><label for='entry_tags'>Tags</label></td><td><input name='entry_tags'/></td></tr></table>"
			 + "<img src='images/accept.gif' alt='Create' onclick='writeEntryToDb(this)' class='imgAccept'/>"
			 + "<img src='images/cross.png' alt='Cancel' onclick='cancelNew(this)' class='imgAccept'/></form></td></tr>";

	source_tr.replaceWith(new_tr);
}

/**
* Toggle the display of the "details" field for an entry
*
* @param obj => a dom element from inside the entry row
*/
function more(obj) {
	var tr = $(obj).parents("tr");
	var text = tr.find(".moreText");
	var arrow = tr.find(".entryIcon:eq(1)");

	if (text.css("display") == "inline"){	
		arrow.attr("src", "images/double_down.png")
	}else{
		arrow.attr("src", "images/double_up.png")
	}
	text.toggle();
}
/**
* TODO : toggle the display of an entry list
*/
function moreList(obj){
	var root = $(obj).parents(".entryList");//.filter(".entryList");
	alert($(root[0]).html());
}

/**
* Write a new entry to db and call a function to refresh the view
*
* @param obj => a dom element from inside the new entry row
*/
function writeEntryToDb(obj) {
	var table = $(obj).parents("table.entriesTable");
	var id_list = table.attr("id");
	var tr = $(obj).parents("tr");
	var input_fields = tr.find(":input");

	$.post("actions/writeEntryToDb.php", 
			{
				id_list:id_list, 
				name:input_fields[0].value,
				url:input_fields[1].value, 
				details:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(data){
				refreshEntryAfterAdd(data['id_entry'], obj);
			},
			"json"
		  );	
}

/**
 * Display the new entry in place and an 'add new entry' button afterwards
 * 
 * @param id_entry => the new entry id
 * @param obj => a dom element from inside the new entry row
 */
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
	html_add_entry = "<tr>" +
					 "<td class='newEntryCell' width='100%'>" +
					 "<img src='images/text_plus.png' alt='new' onclick='newEntry(this)'/>" +
					 "</td>" +
					 "</tr>";

	if (!$(obj).is("tr")){
		obj = $(obj).parents("tr");
	}

	obj.after(html_add_entry);
}

/**
 * Retrieve an entry data and display it in place
 * 
 * @param id_entry => the entry id
 * @param obj => a dom element from inside the entry row
 */
function refreshEntry(id_entry, obj) {
	$.post("actions/getEntryFromDb.php", 
			{
				id_entry:id_entry
			},
			function(data){
				drawEntry(data, obj);
			},
			"json"
		  );	
}

/**
* Display an entry in place
*
* @param data => an array containing the content of the entry as retrieved from db
* @param obj => a dom element from inside the entry row
*/
function drawEntry(data, obj) {
	if (!$(obj).is("tr")){
		obj = $(obj).parents("tr");
	}
	
	html_entry ="<tr class='entryRow' name='" + data['id_entry'] + "'>" +
				"<td class='entryCell'>" +
					"<a href='" + data['url'] + "'>" + data['name'] + "</a>" +													
					"<textarea class='moreText' style='display: none;'>" + data['details'] + "</textarea>" +
					"<div class='tags'>" + data['tags'] + "</div>" +
				"</td>" + 
				"<td class='iconCell'>" +
					"<img onclick=\"window.open('zoom_popup.php?id_entry=" + data['id_entry'] + "','popup','resizable=no,scrollbars=no,width=600,height=370');\" alt='zoom' src='images/zoom.png' class='entryIcon'/>" +
				"</td>" + 
				"<td class='iconCell'>" +
					"<img onclick='more(this)' alt='more' src='images/double_down.png' class='entryIcon'/>" +
				"</td>" +
				"<td class='iconCell'>" +
					"<img onclick='editEntry(this)' alt='edit' src='images/pencil.png' class='entryIcon'/>" +
				"</td>" +
				"<td class='iconCell'>" +
					"<img onclick='deleteEntry(this)' alt='delete' src='images/text_minus.png' class='entryIcon' name='" + data['id_entry'] + "'/>" +
				"</td>";
	obj.replaceWith(html_entry);
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
        url: "actions/writeMemoToDb.php",
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
	var tr = $(obj).parents("tr");
	var id = tr.attr("name");
	$.post("actions/deleteEntryFromDb.php", {id: id});
	tr.remove();
}

/**
* Called by the entry edit form "accept" link : update an entry in db then refresh the view
*
* @param obj => a dom element from inside the entry row
*/
function updateEntryInDb(obj){
	var tr = $(obj).parents("tr");
	var id = tr.attr("name");
	var input_fields = tr.find(":input");

	$.post("actions/updateEntryInDb.php", 
			{
				id_entry:id,
				name:input_fields[0].value,
				url:input_fields[1].value, 
				details:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(data){
				refreshEntry(id, obj);	
			},
			"json"
		  );			  
}

/**
* Called by the entry edit form "cancel" link : cancel the creation of an entry -> remove the form
*
* @param obj => a dom element from inside the entry row
*/
function cancelNew(obj){
	html_add_entry = "<tr>" +
					 "<td class='newEntryCell' width='100%'>" +
					 "<img src='images/text_plus.png' alt='new' onclick='newEntry(this)'/>" +
					 "</td>" +
					 "</tr>";
	$(obj).parents("tr").replaceWith(html_add_entry);
}

/**
* Bind javascript events to the main view
*/
function bindEvents(){
	$("td.tags span").click(function(){
		toggleTag($(this));
	});
}

/**
* For a given tag element, toggle the display of entries linked with this tag
* If the tag value is "all" or "none", call the toggleAll function instead
*
* @param tag => the tag as a string
*/
function toggleTag(tag){
	tag_text = jQuery.trim(tag.html());
	entry_list = tag.parents(".entryList");
	if (tag_text == "all" || tag_text == "none"){
		toggleAllTags(tag_text, entry_list);
		return;
	}
	if (tag_text.match(new RegExp('<img'))){
		toggleEntryTags(entry_list);
		return;
	}

	// toggle the tag in the list header
	tag.toggleClass("selected");
	
	// for each entry with the tag
	entries = entry_list.find("div.tags span:contains(" + tag_text + ")");
	entries.each(function(){
		// if the entry has other tag, we have to check if the entry is to be toggled
		siblings = $(this).siblings("span");
		if (siblings.length){
			// if any other tag is selected, then changing this tag doesn't affect the entry visibility
			var state = false;
			siblings.each(function(){
				tag_sibling = $(this).html();
				selected = entry_list.find("td.tags span:contains(" + tag_sibling + ")").hasClass("selected");
				if (selected){
					state = true;
					return false;
				}
			});
			// no other tag is selected : the tag toggle affects the entry visibility
			if (!state){
				$(this).parents("tr").toggle();
			}
		}
		// no other tag ? toggle !
		else{	
			$(this).parents("tr").toggle();
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
	tagged_tr = entry_list.find("div.tags span:not(:empty)").parents("tr");
	tag_headers = entry_list.find("span.tag_header");
	if (tag_text == "none"){
		tagged_tr.hide();
		tag_headers.removeClass("selected");
	}
	else{
		tagged_tr.show();
		tag_headers.addClass("selected");
	}	
}

function toggleEntryTags(entry_list){
	entry_list.find("div.tags span:not(:empty)").toggleClass("hidden");
}

function editEntryList(obj){
	var tr = $(obj).parents("tr");
	var id_list = tr.attr("name");
	
	$.post("actions/getEntryListFromDb.php", 
		{
			id_list:id_list
		},
		function(data){
			drawEditEntryList(data, tr);
			tr.find("input[name='entry_name']").focus();
			var accept = tr.find("img")[0];
			// Enter key validates the form if focus is on any input field,
			// but not if it's on textarea: it's still newline
			tr.find("input").keydown(function(event){
				if (event.keyCode == 13){
					$(accept).click();
				}
			});
		},
		"json"
	  );	
}

function drawEditEntryList(data, tr){
	html = "<td colspan=4><form><table class='edit_table'>"
			 + "<tr><td><label for='list_title' class='label_edit'>Title </label></td><td><input name='list_title' value='" + data['title'] + "' /></td></tr>"
			 + "<tr><td><label for='list_col' class='label_edit'>Column </label></td><td><input name='col' value ='" 
			 + data['col'] + "' /></td></tr>"
			 + "<tr><td><label for='list_rank' class='label_edit'>Rank </label></td><td><input name='list_rank' value='" 
			 + data['rank'] + "' /></td></tr>" 
			 + "<tr><td><label for='list_rank' class='label_edit'>Tags </label></td>"
			 + "<td><input name='list_tags' value='" 
			 + data['tags'] + "' /></td></tr>" 
			// + "<td class='tags' colspan=2></td></tr>"
			 + "</table>"
			 + "<img src='images/accept.gif' alt='Create' onclick='updateEntryList(this)' class='imgAccept'/>"
			 + "<img src='images/cross.png' onclick='cancelEditEntryList(this)' alt='Cancel' class='imgAccept'/></form></td>";
	tr.html(html);
	
	getAllTags(tr.find("td.tags"), tr.attr("name"));
}

function updateEntryList(obj){
	var tr = $(obj).parents("tr");
	var id = tr.attr("name");
	var input_fields = tr.find(":input");

	$.post("actions/updateEntryListInDb.php", 
			{
				id_list:id,
				title:input_fields[0].value,
				col:input_fields[1].value, 
				rank:input_fields[2].value,
				tags:input_fields[3].value
			},
			function(){
				refreshEntryList(id, obj);	
			}
		  );			  
}

function refreshEntryList(id_list, obj) {
	$.post("actions/getEntryListFromDb.php", 
			{
				id_list:id_list
			},
			function(data){
				drawEntryList(data, obj);
			},
			"json"
		  );	
}

function drawEntryList(data, obj) {
	if (!$(obj).is("tr")){
		obj = $(obj).parents("tr");
	}

	html_list ="<tr name='" + data['id_list'] + "'>" +
				"<td >" +
					data['title'] +													
				"</td>" + 
				"<td class='iconCell'>" +
					"<img onclick='moreEntryList(this)' alt='more' src='images/double_down.png' class='entryIcon'/>" +
				"</td>" +
				"<td class='iconCell'>" +
					"<img onclick='editEntryList(this)' alt='edit' src='images/pencil.png' class='entryIcon'/>" +
				"</td>" +
				"<td class='iconCell'>" +
					"<img onclick='deleteEntryList(this)' alt='delete' src='images/text_minus.png' class='entryIcon' name='" + data['id_list'] + "'/>" +
				"</td>";
	obj.replaceWith(html_list);
}

function cancelEditEntryList(obj){
	var tr = $(obj).parents("tr");
	var id_list = tr.attr("name");
	refreshEntryList(id_list, obj);
}

function moreEntryList(obj) {
	var content = $(obj).parents("div.entryList").find("div.entryContent");
	// toggle the tag headers
	$(obj).parents("tr").siblings(":first").toggle();

	// toggle the arrow image
	if (content.css("display") == "block"){	
		$(obj).attr("src", "images/double_down.png")
	}else{
		$(obj).attr("src", "images/double_up.png")
	}
	// toggle the entries
	content.toggle();
}

function deleteEntryList(obj){
	var tr = $(obj).parents("tr");
	var id = tr.attr("name");

	var html = "<td>Delete this list ? " +
				"<a href='javascript:confirmDeleteEntryList(this)'>Yes</a>" +
				"<a href='javascript:cancelEditEntryList(this)'>No</a>" +
				"</td>";
	tr.html(html);
	//$.post("actions/deleteEntryFromDb.php", {id: id});
	//tr.remove();
}

function getAllTags(obj, id_list){
console.log($(obj).parents("td"));
	$(obj).load("actions/getAllTagsFromDb.php", {"id_list":1});
	/*var a = $.ajax({url:"actions/getAllTagsFromDb.php",
					type:		'POST',
	cache:		false,
	asynch:		false,
}).responseText;
	console.log(a);*/
}

