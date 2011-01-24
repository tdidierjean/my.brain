<?php
//require_once("../lib/Zend/Search/Lucene.php");

class EntryDocument extends Zend_Search_Lucene_Document
{
	/**
	 * Constructor. Creates our indexable document and adds all
	 * necessary fields to it using the passed in document
	 */
	public function __construct($document)
	{
		$this->addField(Zend_Search_Lucene_Field::Keyword('id_entry', $document->getId()));
		$this->addField(Zend_Search_Lucene_Field::Keyword('url',       $document->getUrl()));
		$this->addField(Zend_Search_Lucene_Field::UnIndexed('creation_date', $document->getCreationDate()));
		$this->addField(Zend_Search_Lucene_Field::Text('name',          $document->getName()), 'utf-8');
		$this->addField(Zend_Search_Lucene_Field::Text('content',    $document->getDetails()));
		$this->addField(Zend_Search_Lucene_Field::Text('tag',    $document->getImplodedTags()));
	}
}
?>