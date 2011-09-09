<?php

class Application_Form_Questions extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    }
   public function __construct($options = null){
    	parent::__construct($options);
    	
    	$this->setName('questions');
		$this->setAction('/questions/index');
		$this->setMethod('post');
                
		
                //ten main questions to answer
                $musictype = new Zend_Form_Element_MultiCheckbox('musictype');
                $musictype->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array('r'=>'Rock',
                                              'p'=>'Pop',
                                              'e'=>'Electronic',
                                              'rnb' => 'R&B',
                                              'p' => 'Punk',
                                              'm' => 'Metal',
                                              'j' => 'Jazz',
                                              'f' => 'Funk',
                                              'fo' => 'Folk',
                                              'h' => 'Hip Hop',
                                              'c' => 'Classical',
                                              'b' => 'Blues',
                                              'i' => 'Indie'
                                              ));
                $artists = new Zend_Form_Element_Text('artists');
                $artists->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                     

                $filmgenre = new Zend_Form_Element_MultiCheckbox('filmgenre');
                $filmgenre->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(  'a'=>'Action',
                                                'ad'=>'Adventure',
                                                'c'=>'Cartoon/Animation',
                                                'co'=>'Comedy',
                                                'cr'=>'Crime',
                                                'd'=>'Documentary',
                                                'dr'=>'Drama',
                                                'e'=>'Experimental',
                                                'f'=>'Fantasy',
                                                'fn'=>'Film noir',
                                                'h'=>'Historical',
                                                'ho'=>'Horror',
                                                'm'=>'Musical',
                                                'my'=>'Mystery',
                                                'r'=>'Romance',
                                                'sf'=>'Science fiction',
                                                'su'=>'Supernatural',
                                                't'=>'Thriller',
                                                'w'=>'Western'
                                                     ));
                $films = new Zend_Form_Element_Text('films');
                $films->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                
                $hangout = new Zend_Form_Element_MultiCheckbox('hangout');
                $hangout->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array('c'=>'Cafe',
                                              'r'=>'Restaurant',
                                              'l'=>'Library/Study Hall',
                                              'o'=>'Outdoors',
                                              'h'=>'Home',
                                              'sm'=>'Shopping Mall'
                                                 ));
                
                $hobbies = new Zend_Form_Element_Text('hobbies');
                $hobbies->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                $friday = new Zend_Form_Element_MultiCheckbox('friday');
                $friday->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                              'm'=>'Movies',
                                              'hp'=>'House Party',
                                              'c'=>'Club',
                                              'b'=>'Bar/Lounge',
                                              'r'=>'Restaurant',
                                              'c'=>'Concert'
                                              ));
                
                $sports = new Zend_Form_Element_MultiCheckbox('sports');
                $sports->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                                'b'=>'Baseball',
                                                'ba'=>'Basketball',
                                                'f'=>'Football',
                                                's'=>'Soccer',
                                                'g'=>'Gym',
                                                'sw'=>'Swimming',
                                                't'=>'Track/running',
                                                'h'=>'Hiking',
                                                'bad'=>'Badminton',
                                                't'=>'Table tennis',
                                                'te'=>'Tennis',
                                                'sq'=>'Squash',
                                                'fr'=>'Frisbee',
                                                'n'=>'Nerf ball',
                                                'h'=>'Hockey',
                                                'l'=>'Lacrosse',
                                                'gy'=>'Gymnastics',
                                                'm'=>'Martial arts',
                                                'v'=>'Volleyball',
                                                'no'=>'Not really an outdoors person'
                                                        ));
                $teams = new Zend_Form_Element_Text('teams');
                $teams->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                $brands = new Zend_Form_Element_Text('brands');
                $brands->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));

                $videogames = new Zend_Form_Element_MultiCheckbox('videogames');
                $videogames->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(  'a'=>'Action/adventure',
                                                'f'=>'FPS',
                                                'r'=>'RPG',
                                                'm'=>'MMORPG',
                                                's'=>'Simulation',
                                                'st'=>'Strategy',
                                                'c'=>'Casual games',
                                                'p'=>'Puzzle',
                                                'sh'=>'Shoot em up',
                                                'r'=>'Racing',
                                                'sp'=>'Sports',
                                                'mu'=>'Music games',
                                                'fi'=>'Fighting',
                                                'v'=>'Virtual novels'
                                                  ));
           
               
                
                $submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_questions.phtml'))));
		
		$this->addElements(array($musictype, $musictype2, $filmgenre, $hangout, $friday, $sports, $videogames));
		$this->setElementDecorators(array('ViewHelper'),null,false);
                	/**test**/  
		/*$firstName = new Zend_Form_Element_Text('firstName');
		$firstName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				  		'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          					'regexNotMatch' => 'Please enter a valid firstname.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A firstname is required.'
    					 )
  				  ));
		
		$lastName = new Zend_Form_Element_Text('lastName');
		$lastName->setRequired(true)
				  ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				 		 'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          				'regexNotMatch' => 'Please enter a valid lastname'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A lastname is required.'
    					 )
  				  ));
		
		$gender = new Zend_Form_Element_Select('gender');
		$gender->addMultiOptions(array('n'=>'Rather Not Say','m'=>'Male','f'=>'Female'));
		
		$city = new Zend_Form_Element_Text('city');
		$city->setRequired(true)
				  ->addValidator('StringLength',array('max'=>40,'allowWhiteSpace'=>true))
				  ->addValidator('Regex',true, array(
				 	    'pattern' => '/^[a-zA-Z\-\' ]+$/',
     					'messages' => array(
          				'regexNotMatch' => 'Please enter a valid city name.'
    					 )
  				  ))
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A city is required.'
    					 )
  				  ));
				  
		$password = new Zend_Form_Element_Password('password','password1');
		$password->addValidator('Regex',false,array('pattern' => '/^.*(?=.{6,20})(?=.*[\d])(?=.*[a-zA-Z])/',
													'messages'=>array('regexNotMatch' => "Passwords must contain 6 to 20 characters and have at least one number")))
				 ->addValidator('StringLength',false,array('max'=>20))
				 ->setRequired(true)
				 ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'A password is required.'
    					 )
  				  ));
		
		$password2 = new Zend_Form_Element_Password('password2');
		$password2->setRequired(true)
				  ->addValidator('NotEmpty', true, array(
     					'messages' => array(
          				'isEmpty' => 'Please re-enter the same password.'
    					 )
  				  ));
				  
		
			
		$register = new Zend_Form_Element_Submit('register');
		$register->removeDecorator('DtDdWrapper');
		
		$this->addElements(array($firstName,$lastName,$email,$city,$password,$password2,$register,$gender));
		
		$this->setDecorators(array(
									array('ViewScript', 
										   array('viewScript' => '_form_registration.phtml'))  
								  )	 	
							);
		$this->setElementDecorators(array('ViewHelper','Errors'),null,false);
		
	}
	public function addIdentical($postData){
		$this->password2->addValidator('Identical',false,array('token'=>$postData
		,'messages'=> array('notSame' => 'The two passwords you entered don\'t match')));
		
	}*/ /****test***/
    }
}