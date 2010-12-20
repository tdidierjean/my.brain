<?php
require_once("init.php");
require_once("lib/Zend/Search/Lucene.php");
require_once("dao/entryDAO.php");

Zend_Search_Lucene_Analysis_Analyzer::setDefault(
	new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive());
$indexPath = $CONFIG['indexPath'];
$index = Zend_Search_Lucene::create($indexPath);

class EntryDocument extends Zend_Search_Lucene_Document
{
	/**
	 * Constructor. Creates our indexable document and adds all
	 * necessary fields to it using the passed in document
	 */
	public function __construct($document)
	{
		$this->addField(Zend_Search_Lucene_Field::UnIndexed('id_entry', $document->getId()));
		$this->addField(Zend_Search_Lucene_Field::Keyword('url',       $document->getUrl()));
		$this->addField(Zend_Search_Lucene_Field::UnIndexed('creation_date', $document->getCreationDate()));
		$this->addField(Zend_Search_Lucene_Field::Text('name',          $document->getName()), 'utf-8');
		$this->addField(Zend_Search_Lucene_Field::Text('content',    $document->getDetails()));
		$this->addField(Zend_Search_Lucene_Field::Text('tag',    $document->getImplodedTags()));
	}
}

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