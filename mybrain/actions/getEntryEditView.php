<?php
session_start();
if (!$_SESSION["logged"]){
    header("Location: ../login.php");
}

require_once("../init.php");
require_once("../fonctions.php");

$id_entry = $_REQUEST["id_entry"];
if (!$id_entry){
	throw Exception("No id_entry specified !");
}

$entry = $db->getEntry($id_entry);
$tags = $db->getEntryTags($id_entry);
$tags = implode (" ", $tags);
?>
<div class='editForm'><form><table class='edit_table'>"
					 + "<tr><td><label for='entry_name'>Name </label></td><td><input name='entry_name' value='" + data['name'] + "' /></td></tr>"
					 + "<tr><td><label for='entry_url'>Url </label></td><td><input name='entry_url' value ='" + data['url'] + "' /></td></tr>"
					 + "<tr><td><label for='entry_details'>Details </label></td><td><textarea name='entry_details'>" + data['details'] + "</textarea></td></tr>"
					 + "<tr><td><label for='entry_tags'>Tags</label></td><td><input name='entry_tags' value='" + data['tags'] + "'/></td></tr></table>"
					 + "<a> class="iconCell editList" href="#"><img src='images/accept.png' alt='Create' onclick='updateEntryInDb(this)' class='imgAccept'/>"
					 + "<img src='images/cross.png' alt='Cancel' onclick='cancelEdit(this)' class='imgAccept'/></form></div>";
<form>
	<table class="edit_table">
		<tr>
			<td>
				<label for="entry_title" class="label_edit">Title </label>
			</td>
			<td>
				<input name="entry_title" value="<?php echo $entry["title"];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="entry_col" class="label_edit">Column </label>
			</td>
			<td>
				<input name="col" value="<?php echo $entry["col"];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="entry_rank" class="label_edit">Rank </label>
			</td>
			<td>
				<input name="entry_rank" value="<?php echo $entry["rank"];?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="entry_rank" class="label_edit">Tags </label>
			</td>
			<td>
				<input name="entry_tags" value="<?php echo $tags;?>" />
			</td>
		</tr> 
	</table>
	<a href="#" class="iconCell imgAccept acceptEditentry">
		<img src="images/accept.png" alt="Create"/>
	</a>
	<a href="#" class="iconCell imgAccept cancelEditentry">
		<img src="images/cross.png" alt="Cancel"/>
	</a>
</form>
