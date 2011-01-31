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
		<link href="css/nicedit.css" media="all" rel="stylesheet" type="text/css">
		<link type="text/css" rel="stylesheet" href="css/jquery.markedit.css" />
		<link type="text/css" rel="stylesheet" href="css/jquery-ui.css" />
		<link href="css/prettify.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jqueryUI/jquery-ui.js"></script>
		<!--  <script type="text/javascript" src="js/nicedit/nicEdit.js"></script>-->
		<script type="text/javascript" src="js/searchEngine.js"></script>
		<script type="text/javascript" src="js/entry.js"></script>
		<script type="text/javascript" src="js/search.js"></script>
		<script type="text/javascript" src="js/main.js"></script>
		 <script type="text/javascript" src="js/jquery-validate/jquery.validate.js"></script>
		<!-- <script type="text/javascript" src="js/tooltips.js"></script>-->
		<script type="text/javascript" src="js/jquery.simpleautogrow.js"></script>		
		<script type="text/javascript" src="js/prettify/prettify.js"></script>
	</head>
	<body>
		<div id="page">
			<img src='images/logo-s.png'></img>
			<div id="header" class="corners">
				<a>Settings</a> 
				&nbsp;|&nbsp;
				<a href='logout.php'>Log out</a>
			</div>
			<br />
			<div id="memoDiv">
				<textarea id="memo" class="smallText corners shadows"><?php echo $memo->getContent();?></textarea>
				<p id="save_memo">
					<button type="button">Save</button>
					<span id="message_memo">
						Last saved: <?php echo $memo->getUpdateDate();?>
					</span>
				</p>
			</div>
			<div id="entriesDiv">
				<div id="searchDiv" class="corners shadows">
					<div id="search1" class="search">
						<div id="inputQuery">
							
							    <input type="text" id="query" value="<?php echo $last_search;?>" />
							
						</div>
						<span id="searchState">
						</span>
						<br />
						<div id="globalActions">
							<a id="createEntry" class="iconCell" href="#">
								<img class="entryIcon" src="images/add.png" alt="add"/>
								<span>New note</span>
							</a>
							<br />
							<!--  <a id="buildIndex" class="iconCell" href="#">
								<img class="entryIcon" src="images/edit.png" alt="build"/>
								<span>Build index</span>
							</a>-->
							
						</div>
					</div>
					<div id="search2" class="search">
						<div class="tags">
						<?php	
							$tags = $content['all_tags'];
							$main_tags = array();				
							if ($tags):
								sort($tags);
								foreach ($tags as $tag):
									?>
									<div class="tag_header"><?php echo $tag->getTagText();?></div>
									<?php
								endforeach;
							endif;
						?>
							<div id="switch_all" class="switch_header">
								all
							</div>
							
							<div id="switch_none" class="switch_header">
								none
							</div>
						</div>
					</div>
				</div>
				<div id="resultsDiv" width="300px">
					<div id="entriesList">
						<?php 
						foreach($entries as $entry){ 
							include('lib/view/entryView.php');
						}
						?>						
					</div>
				</div>
			</div>
		</div>
	</body>
</html>		
<script type="text/javascript">
	$(document).ready(bindSearchEvents());
	$(document).ready(bindEv());
</script>
