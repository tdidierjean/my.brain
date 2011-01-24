<?php
require_once("init.php");
require_once("lib/Zend/Search/Lucene.php");
require_once("lib/search/entryDocument.php");
require_once("dao/entryDAO.php");

Zend_Search_Lucene_Analysis_Analyzer::setDefault(
	new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
$indexPath = $CONFIG['indexPath'];

$entryDAO = new EntryDAO($db);
$documents = $entryDAO->getAll();

// create our index
$index = Zend_Search_Lucene::create($indexPath);

foreach ($documents as $document) {
	$index->addDocument(new EntryDocument($document));
}

// write the index to disk
$index->commit();
echo "Indexing done";
?>