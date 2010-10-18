<?php
session_start();
if (!$_SESSION['logged']){
	echo "<script type='text/javascript'>window.location.replace('login.php');</script>";
	exit();
}

require_once('../init.php');
require_once('../lib/search/searchEngine.php');
require_once('Zend/Search/Lucene.php');
require_once('../lib/model/entry.php');


$query = $_REQUEST['query'];

$searchEngine = new SearchEngine($db);

Zend_Search_Lucene_Analysis_Analyzer::setDefault(
		new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());


$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = trim($query);
$query .= "*";

$index = Zend_Search_Lucene::open($CONFIG['indexPath']);

try {
	$hits = $index->find($query);
}
catch (Zend_Search_Lucene_Exception $ex) {
	$hits = array();
}

$entries = array();
foreach ($hits as $hit){
	$entries[] = new Entry($hit->id, 
						 $hit->name, 
						 $hit->url, 
						 $hit->details); 
}

?>
<div class="accordion">
	<?php foreach($entries as $entry): ?>
		<h3 class="customAccordion <?php echo $entry->getId()?>"><a href="#"><?php echo utf8_decode($entry->getName()); ?></a></h3>
		<div class="entryBody smallText <?php echo $entry->getId()?>" name="<?php echo $entry->getId()?>">								
			<div style='float:right'>
				<a class="iconCell" href="zoom_popup.php?id_entry=<?php echo $entry->getId();?>" title="<?php echo $entry->getName();?>" rel="#overlay"> 
					<img class="entryIcon" src="images/zoom.png" alt="zoom"/>
				</a>
				<a class="iconCell editEntry" href="#">
					<img class="entryIcon" src="images/edit.png" alt="edit"/>
				</a>
				<a class="iconCell deleteEntry" href="#">
					<img class="entryIcon" src="images/delete.png" alt="delete"/>
				</a>
			</div>

			<div class="entryTags">
				<?php 
				$tags = $entry->getTags();
				if ($tags):
					foreach ($tags as $tag):
						?>
						<span><?php echo $tag->getTagText();?></span>
						<?php
					endforeach;
				endif;
				?>
			</div>
			<?php if($entry->getUrl()):?>
				<a class="url" href="<?php echo $entry->getUrl();?>">
					<?php echo $entry->getShortenedUrl(35);?>
				</a>
			<?php endif;?>
			<div class="entryDetails">
				<?php echo utf8_decode($entry->getDetailsHtmlDisplay());?>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?php
/*
if (strlen($query) > 0) { ?>
    <p>
        Found <?php echo count($hits) ?> result(s) for query <?php echo $query ?>.
    </p>
 
    <?php foreach ($hits as $hit) { ?>
        <h3><?php echo utf8_decode($hit->name) ?> (score: <?php echo $hit->score ?>)</h3>
        <p>
            <?php echo $hit->details ?><br />
            <a href="<?php echo $hit->url ?>">Read more...</a>
        </p>
    <?php } ?>
<?php } ?>
*/