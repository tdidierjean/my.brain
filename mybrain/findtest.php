<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
	</head>
	<body>
<?php
    require_once('Zend/Search/Lucene.php');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(
	new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
    $indexPath = 'docindex';

    $query = isset($_GET['query']) ? $_GET['query'] : '';
    $query = trim($query);
 
    $index = Zend_Search_Lucene::open($indexPath);
 
    try {
        $hits = $index->find($query);
    }
    catch (Zend_Search_Lucene_Exception $ex) {
        $hits = array();
    }
    $numHits = count($hits);
    
?>
 
<form method="get" action="findtest.php">
    <input type="text" name="query" value="<?php htmlSpecialChars($query) ?>" />
    <input type="submit" value="Search" />
</form>
 
<?php if (strlen($query) > 0) { ?>
    <p>
        Found <?php echo $hits ?> result(s) for query <?php echo $query ?>.
    </p>
 
    <?php foreach ($hits as $hit) { ?>
        <h3><?php echo utf8_decode($hit->name) ?> (score: <?php echo $hit->score ?>)</h3>
        <p>
            <?php echo $hit->details ?><br />
            <a href="<?php echo $hit->url ?>">Read more...</a>
        </p>
    <?php } ?>
<?php } ?>
</body>
</html>