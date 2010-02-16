<?php
if (!isset($_SESSION['logged']) || !$_SESSION['logged']){
    header("Location: login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>my.brain</title>
		<link href="css/main.css" media="all" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="js/jquery.js"></script>  
		<script type="text/javascript" src="js/jqueryUI/jquery-ui.js"></script>  
		<script type="text/javascript" src="js/jqueryUI/jquery.effects.highlight.js"></script>  
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/jquery-qtip/jquery.qtip.min.js"></script>
		<script type="text/javascript" src="js/tooltips.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="header">
				<div id="title">my.brain</div>
			</div>
			<div id="memoDiv">
				<textarea id="memo"><?php echo $content['memo'] ?></textarea>
				<p id="save_memo">
					<button type="button" onclick="writeMemoToDb()">Enregistrer</button>
					<span id="message_memo">
					</span>
				</p>
			</div>
			<div id="entriesDiv">
				<?php for ($i=0; $i<2; $i++):?>
					<div id="col<?php echo $i;?>" class="column_div">
						<?php 
						foreach($content['entry_lists'] as $entry_list): 
							if($entry_list->getCol() == $i):
						?>
								<div class="entryList">	  
									<div class="entryTitle">
										<table>
											<tr name="<?php echo $entry_list->getId();?>">
												<td>
													<?php echo $entry_list->getTitle(); ?> 
												</td>    
												<td class="iconCell">
													<img class="entryIcon" src="images/double_up.png" alt="zoom" onclick="moreEntryList(this);" />
												</td>
												<td class="iconCell">
													<img class="entryIcon" src="images/pencil.png" alt="edit" onclick="editEntryList(this)"/>
												</td>
												<td class="iconCell">
													<img class="entryIcon" src="images/text_minus.png" alt="delete" onclick="deleteEntryList(this)"/>
												</td>							
											</tr>
											<tr>
												<td colspan=4 class="tags">
												<?php
													$tags = $entry_list->getTagsEntries();
													if ($tags):
														sort($tags);
														foreach ($tags as $tag):
															?>
															<span class="selected tag_header">
															<?php
															echo $tag." ";
															?>
															</span>
															<?php
														endforeach;
													endif;
												?>
													<span class="switch_header">
														all
													</span>
													<span class="switch_header">
														none
													</span>
													<span class="switch_header">
														<img class="eye" src="images/eye.png" alt="eye"/>
													</span>													
												</td>
											</tr>
										</table>  
									</div>    
									<div class="entryContent">
										<table class="entriesTable" id=<?php echo $entry_list->getId()?>>
										<?php foreach($entry_list->getEntries() as $entry): ?>
											<tr class="entryRow" name=<?php echo $entry->getId()?>>
												<td class="entryCell">
													<?php if ($entry->getUrl()):?>
														<a href=<?php echo $entry->getUrl() ?>><?php echo $entry->getName() ?></a>
													<?php else: ?>
														<?php echo $entry->getName() ?>
													<?php endif; ?>
													
													<div class="tags">
														<?php 
														$tags = $entry->getTags();
														if ($tags):
															foreach ($tags as $tag):
																?>
																<span class="hidden"><?php echo $tag;?></span>
																<?php
															endforeach;
														endif;
														?>
													</div>
													<textarea class="moreText"><?php echo $entry->getDetails()?></textarea>
														
												</td>
												<td class="iconCell" name="zoom_entry">
													<img class="entryIcon" src="images/zoom.png" alt="zoom" onclick="window.open('zoom_popup.php?id_entry=<?php echo $entry->getId();?>','popup','resizable=no,scrollbars=no,width=600,height=370');" />
												</td>
												<td class="iconCell" name="more_entry">
													<img class="entryIcon" src="images/double_down.png" alt="more" onclick="more(this)" />
												</td>
												<td class="iconCell" name="edit_entry">
													<img class="entryIcon" src="images/pencil.png" alt="edit" onclick="editEntry(this)"/>
												</td>
												<td class="iconCell" name="delete_entry">
													<img class="entryIcon" src="images/text_minus.png" alt="delete" onclick="deleteEntry(this)"/>
												</td>
											</tr>
										<?php endforeach; ?>
											<tr>
												<td class="newEntryCell" name="new_entry" width="100%">
													<img src="images/text_plus.png" alt="new" onclick="newEntry(this)"/>
												</td>
											</tr>
										</table>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</body>
</html>
