function bindEv(){
	/* Init tinyMCE
	tinyMCE.init({
		mode : "textareas"
	});*/
	
	//bkLib.onDomLoaded(function() { nicEditors.allTextAreas(); });

	/* bind save memo */
	selectorCache.get("#save_memo button").bind("click", function(){
		writeMemoToDb();
	});
	
	/* Bind entry toggle on click */
	$(".entryTitle").live("click", function(){
		var entryDiv = $(this).parents(".entry");
		entry.toggleEntry(entryDiv);
		return false;
	});
	/* Bind create entry on click */
	$("#createEntry").live("click", function(){
		var container = selectorCache.get("div#entriesList");
		entry.newEntry(container);
		return false;
	});	
	/* Bind accept edit entry on click */
	$("a.acceptEditEntry").live("click", function(){
		entry.validateEntryForm($(this).parents("form"));
		return false;
	});
	
	/* Bind cancel edit entry on click */
	$("a.cancelEditEntry").live("click", function(){
		var container = $(this).parents(".entry");
		entry.refreshEntryView(container.attr("id"), container);
		return false;
	});
	
	/* Bind edit entry on click */
	$(".editEntry").live("click", function(){
		entry.editEntry(this);
		return false;
	});	
	
	/* Bind delete entry on click */
	$(".deleteEntry").live("click", function(){
		entry.deleteEntry(this);
		return false;
	});
	
	/* Bind rebuild index on click */
	/*$("#buildIndex").live("click", function(){
		buildIndex();
		return false;
	});*/
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
}

function buildIndex(){
	var container = selectorCache.get("#searchState");
    $.ajax({
		type: "POST",
        url: "buildIndex.php",
        success: function(data){
          container.html(data).
            effect("highlight",{color:'#3DFF8C'},2000);
        },
        error: function(req,error){
          if(error === 'error'){error = req.statusText;}
          var errormsg = 'Indexing failed '+error;
          container.html(errormsg).
            effect('highlight',{color:'#c00'},2000);
        },
        beforeSend: function(data){
          container.html('Indexing...');
        }
    });
}

var selectorCache = new SelectorCache();
var entry = new Entry();

