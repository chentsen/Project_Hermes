<?php
class Application_Form_Wall extends Zend_Form{
	public function __construct($options = null){
		parent::__construct($options);
		$this->setName('Wall');
		$this->setAction("/event/add/eid/{$options['eid']}");
		$this->setMethod('post');
		$comment = new Zend_Form_Element_Text('wall_comment');
		$comment->setRequired(true)
			  ->removeDecorator('label')
			  ->removeDecorator('htmlTag');
		$submit = new Zend_Form_Element_Submit('wall_addPost','comment');
		$submit->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
				
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_wall.phtml'))));
		$this->addElements(array($comment,$submit));
		$this->setElementDecorators(array('ViewHelper'),null,false);
	}
}

//EventDisplayWall will call the event's wall
//UserDisplayWall will call the users wall
//event and user wall inherit from a generic wall, the difference being eventWall with an event referenced and user with a user referenced
//@the WallModel level, check which version it is and allow deletes depending on which version.