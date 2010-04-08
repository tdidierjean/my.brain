<?php
$list = array("title" => "New List",
			  "col" => "2",
			  "rank" => "2");
?>

<div class="entryList newListDiv">
	<div class="entryListHeader">
		<form>
			<table class="edit_table">
				<tr>
					<td>
						<label for="list_title" class="label_edit">Title </label>
					</td>
					<td>
						<input name="list_title" value="<?php echo $list["title"];?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="list_col" class="label_edit">Column </label>
					</td>
					<td>
						<input name="col" value="<?php echo $list["col"];?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="list_rank" class="label_edit">Rank </label>
					</td>
					<td>
						<input name="list_rank" value="<?php echo $list["rank"];?>" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="list_rank" class="label_edit">Tags </label>
					</td>
					<td>
						<input name="list_tags" value="" />
					</td>
				</tr> 
			</table>
			<a href="#" class="iconCell imgAccept acceptEditList">
				<img src="images/accept.png" alt="Create"/>
			</a>
			<a href="#" class="iconCell imgAccept cancelEditList">
				<img src="images/cross.png" alt="Cancel"/>
			</a>
		</form>
	</div>
</div>
		