<?php

class Application_Form_EditAccount extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
   public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('editAccount');
		$this->setAction('/accountedit/index');
		$this->setMethod('post');
                
		
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_accountEdit.phtml'))));
		/*
		$this->addElements(array($submit, $personality, $career, $major, $websites, $brands, $teams, $inorout, $cuisine, $news, $books, $bookswriters,
                                            $musictype, $filmgenre, $films, $hangout, $artists, $friday, $sports, $videogames, $boardgames, $hobbies));*/
		$this->setElementDecorators(array('ViewHelper'),null,false);
                
    }
}