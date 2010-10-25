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
		<link href="css/custom-theme/jquery-ui-1.7.2.custom.css" media="all" rel="stylesheet" type="text/css">
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jqueryTools/jquery.tools.min.js"></script>
		<script type="text/javascript" src="js/jqueryUI/jquery-ui-1.7.2.custom.min.js"></script>  
		<script type="text/javascript" src="js/main.js"></script>
		<script type="text/javascript" src="js/searchEngine.js"></script>
		<script type="text/javascript" src="js/search.js"></script>
		<script type="text/javascript" src="js/tooltips.js"></script>
		<script type="text/javascript" src="js/jquery.simpleautogrow.js"></script>
	</head>
	<body>
		<div id="page">
			<div id="header" class="corners">
				<div id="title">my.brain</div>
				<div id="menu" class="corners shadows">
					<a class="iconCell newList" href="#">
						<img class="entryIcon" src="images/add.png" alt="add"/>
					</a>
					<a class="iconCell editMenu" href="#">
						<img class="entryIcon" src="images/edit.png" alt="edit"/>
					</a>
				</div>
			</div>
			<div id="memoDiv">
				<textarea id="memo" class="smallText corners shadows"><?php echo $memo->getContent();?></textarea>
				<p id="save_memo">
					<button type="button" onclick="writeMemoToDb()">Enregistrer</button>
					<span id="message_memo">
						Last saved: <?php echo $memo->getUpdateDate();?>
					</span>
				</p>
			</div>
			<div id="entriesDiv">
				<div id="searchDiv" class="corners shadows">
					<div id="search1" class="search">
						<div id="inputQuery">
							<form method="get" action="findtest.php">
							    <input type="text" name="query" />
							</form>
						</div>
						<span id="searchState">
							
						</span>
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
									<span class="selected tag_header<?php if (in_array($tag, $main_tags)) echo " primary";?>"><?php echo $tag->getTagText();?></span>
									<span> </span>
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
						</div>
					</div>
				</div>
				<div id="resultsDiv" width="300px">
					<div class="accordion">
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
	$(document).ready(bindEvents());
	$(document).ready(bindSearchEvents());
</script>