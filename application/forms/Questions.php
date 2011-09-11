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
                                              'm'=>'Museum'
                                                 ));
                
                
                $hobbies = new Zend_Form_Element_Text('hobbies');
                $hobbies->setRequired(false);
                
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
                $boardgames = new Zend_Form_Element_MultiCheckbox('boardgames');
                $boardgames->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                              'b'=>'Board Games',
                                              'c'=>'Chess',
                                              'ca'=>'Cards (Deuces, Go Fish)',
                                              'p'=>'Poker',
                                              't'=>'Tabletop RPGs',
                                              'w'=>'Word Games (Charades, Taboo)'
                                              ));
                
                $books = new Zend_Form_Element_Text('books');
                $books->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true)); 
                
                $bookswriters = new Zend_Form_Element_Text('bookswriters');
                $bookswriters->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
               
                
                $news = new Zend_Form_Element_MultiCheckbox('news');
                $news->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                                'w'=>'World News',
                                                'u'=>'US',
                                                'p'=>'Politics',
                                                'b'=>'Business',
                                                'f'=>'Finance',
                                                't'=>'Tech',
                                                's'=>'Sports',
                                                'sc'=>'Science',
                                                'h'=>'Health',
                                                'a'=>'Arts',
                                                's'=>'Style/fashion',
                                                't'=>'Travel'
                                            ));
                
                $cuisine = new Zend_Form_Element_MultiCheckbox('cuisine');
                $cuisine->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                                'a'=>'American',
                                                'e'=>'European',
                                                'v'=>'Vietnamese',
                                                'j'=>'Japanese',
                                                'k'=>'Korean',
                                                't'=>'Thai',
                                                'c'=>'Chinese',
                                                'i'=>'Indian',
                                                'm'=>'Middle Eastern',
                                                'af'=>'African',
                                                'm'=>'Mediterranean'
                                             ));
                
                $inorout = new Zend_Form_Element_MultiCheckbox('inorout');
                $inorout->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                            'i'=>'Indoors',
                                            'o'=>'Outdoors'
                                            ));
                
                $sports = new Zend_Form_Element_MultiCheckbox('sports');
                $sports->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array( 
                                                'b'=>'Baseball',
                                                'ba'=>'Basketball',
                                                'c'=>'Cricket',
                                                'cy'=>'Cycling',
                                                'f'=>'Field hockey',
                                                'i'=>'Ice hockey',
                                                'f'=>'Football',
                                                'g'=>'Golf',
                                                'l'=>'Lacrosse',
                                                'm'=>'Martial arts',
                                                'r'=>'Rugby',
                                                's'=>'Softball',
                                                'so'=>'Soccer',
                                                'sq'=>'Squash',
                                                't'=>'Tennis',
                                                'ta'=>'Table tennis',
                                                'v'=>'Volleyball'
                                                  ));
                
                $teams = new Zend_Form_Element_Text('teams');
                $teams->setRequired(false) 
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
           
               
                $brands = new Zend_Form_Element_Text('brands');
                $brands->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));

                $websites = new Zend_Form_Element_Text('websites');
                $websites->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                $major = new Zend_Form_Element_Text('major');
                $major->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));

                $career = new Zend_Form_Element_Text('career');
                $career->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                $personality = new Zend_Form_Element_Text('personality');
                $personality->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));

                $submit = new Zend_Form_Element_Submit('submit');
		$submit->removeDecorator('label')
				->removeDecorator('htmlTag')
				->removeDecorator('DtDdWrapper');
		
		$this->setDecorators(array(array('ViewScript',array('viewScript'=>'_form_questions.phtml'))));
		
		$this->addElements(array($submit, $personality, $career, $major, $websites, $brands, $teams, $inorout, $cuisine, $news, $books, $bookswriters,
                                            $musictype, $filmgenre, $films, $hangout, $artists, $friday, $sports, $videogames, $boardgames, $hobbies));
		$this->setElementDecorators(array('ViewHelper'),null,false);
                
    }
}