<div id="tooltip_zoom" class="tooltip"> 
    Zoom
</div> 

<div id="tooltip_more" class="tooltip"> 
    Display more
</div> 

<div id="tooltip_edit" class="tooltip"> 
    Edit
</div> 

<div id="tooltip_delete" class="tooltip"> 
    Delete
</div> 


<div id="tooltip_eye" class="tooltip"> 
	Display/hide tags under each entry 
</div> 

<div class="table_tooltip" id="table_tooltip">
												<a href="zoom_popup.php?id_entry=<?php echo $entry->getId();?>" rel="#overlay"> 
													<img class="entryIcon" src="images/zoom.png" alt="zoom"/> <!--onclick="window.open('zoom_popup.php?id_entry=<?php echo $entry->getId();?>','popup','resizable=no,scrollbars=no,width=600,height=370');" />-->
												</a>

													<img class="entryIcon" src="images/double_down.png" alt="more" onclick="more(this)" />


													<img class="entryIcon" src="images/pencil.png" alt="edit" onclick="editEntry(this)"/>


													<img class="entryIcon" src="images/text_minus.png" alt="delete" onclick="deleteEntry(this)"/>

</div>
