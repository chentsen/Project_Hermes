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
                //Andy:Uses keys as tags! to extend this we want to pass multioptions in from $options 
                $musictype = new Zend_Form_Element_MultiCheckbox('musictype');
                $musictype->class="musicMulti";
                $musictype->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array('Rock'=>'Rock',
                                              'Pop'=>'Pop',
                                              'Electronic'=>'Electronic',
                                              'R&B' => 'R&B',
                                              'Punk' => 'Punk',
                                              'Metal' => 'Metal',
                                              'Jazz' => 'Jazz',
                                              'Funk' => 'Funk',
                                              'Folk' => 'Folk',
                                              'Hip Hop' => 'Hip Hop',
                                              'Classical' => 'Classical',
                                              'Blues' => 'Blues',
                                              'Indie' => 'Indie'
                                              ));
                $artists = new Zend_Form_Element_Text('artists');
                $artists->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                     

                $filmgenre = new Zend_Form_Element_MultiCheckbox('filmgenre');
                $filmgenre->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(  'Action'=>'Action',
                                                'Adventure'=>'Adventure',
                                                'Cartoon/Animation'=>'Cartoon/Animation',
                                                'Comedy'=>'Comedy',
                                                'Crime'=>'Crime',
                                                'Documentary'=>'Documentary',
                                                'Drama'=>'Drama',
                                                'Experimental'=>'Experimental',
                                                'Fantasy'=>'Fantasy',
                                                'Film Noir'=>'Film noir',
                                                'Historical'=>'Historical',
                                                'Horror'=>'Horror',
                                                'Musical'=>'Musical',
                                                'Mystery'=>'Mystery',
                                                'Romance'=>'Romance',
                                                'Science fiction'=>'Science fiction',
                                                'Supernatural'=>'Supernatural',
                                                'Thriller'=>'Thriller',
                                                'Western'=>'Western'
                                                     ));
                $films = new Zend_Form_Element_Text('films');
                $films->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                
                $hangout = new Zend_Form_Element_MultiCheckbox('hangout');
                $hangout->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array('Cafe'=>'Cafe',
                                              'Restaurant'=>'Restaurant',
                                              'Library'=>'Library/Study Hall',
                                              'Outdoors'=>'Outdoors',
                                              'Home'=>'Home',
                                              'Museum'=>'Museum'
                                                 ));
                
                
                $hobbies = new Zend_Form_Element_Text('hobbies');
                $hobbies->setRequired(false);
                
                $friday = new Zend_Form_Element_MultiCheckbox('friday');
                $friday->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                              'Movies'=>'Movies',
                                              'House Party'=>'House Party',
                                              'Club'=>'Club',
                                              'Bar/Lounge'=>'Bar/Lounge',
                                              'Restaurant'=>'Restaurant',
                                              'Concert'=>'Concert'
                                              ));
                $boardgames = new Zend_Form_Element_MultiCheckbox('boardgames');
                $boardgames->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                              'Board Games'=>'Board Games',
                                              'Chess'=>'Chess',
                                              'Cards'=>'Cards (Deuces, Go Fish)',
                                              'Poker'=>'Poker',
                                              'Tabletop RPGs'=>'Tabletop RPGs',
                                              'Word Games'=>'Word Games (Charades, Taboo)'
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
                                                'World News'=>'World News',
                                                'US'=>'US',
                                                'Politics'=>'Politics',
                                                'Business'=>'Business',
                                                'Finance'=>'Finance',
                                                'Tech'=>'Tech',
                                                'Sports'=>'Sports',
                                                'Science'=>'Science',
                                                'Health'=>'Health',
                                                'Arts'=>'Arts',
                                                'Style/fashion'=>'Style/fashion',
                                                'Travel'=>'Travel'
                                            ));
                
                $cuisine = new Zend_Form_Element_MultiCheckbox('cuisine');
                $cuisine->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                                'American'=>'American',
                                                'European'=>'European',
                                                'Vietnamese'=>'Vietnamese',
                                                'Japanese'=>'Japanese',
                                                'Korean'=>'Korean',
                                                'Thai'=>'Thai',
                                                'Chinese'=>'Chinese',
                                                'Indian'=>'Indian',
                                                'Middle Eastern'=>'Middle Eastern',
                                                'African'=>'African',
                                                'Mediterranean'=>'Mediterranean'
                                             ));
                
                $inorout = new Zend_Form_Element_MultiCheckbox('inorout');
                $inorout->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(
                                            'Indoors'=>'Indoors',
                                            'Outdoors'=>'Outdoors'
                                            ));
                
                $sports = new Zend_Form_Element_MultiCheckbox('sports');
                $sports->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array( 
                                                'Baseball'=>'Baseball',
                                                'Basketball'=>'Basketball',
                                                'Cricket'=>'Cricket',
                                                'Cycline'=>'Cycling',
                                                'Field Hockey'=>'Field hockey',
                                                'Ice Hockey'=>'Ice hockey',
                                                'Football'=>'Football',
                                                'Golf'=>'Golf',
                                                'Lacross'=>'Lacrosse',
                                                'Martial arts'=>'Martial arts',
                                                'Rugby'=>'Rugby',
                                                'Softball'=>'Softball',
                                                'Soccer'=>'Soccer',
                                                'Squash'=>'Squash',
                                                'Tennis'=>'Tennis',
                                                'Table Tennis'=>'Table tennis',
                                                'Volleyball'=>'Volleyball'
                                                  ));
                
                $teams = new Zend_Form_Element_Text('teams');
                $teams->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
                
                             
                $videogames = new Zend_Form_Element_MultiCheckbox('videogames');
                $videogames->setRequired(false)
                      ->removeDecorator('label')
                      ->removeDecorator('htmlTag')
                      ->addMultiOptions(array(  'Actions/adventure'=>'Action/adventure',
                                                'FPS'=>'FPS',
                                                'RPG'=>'RPG',
                                                'MMORPG'=>'MMORPG',
                                                'Simulation'=>'Simulation',
                                                'Strategy'=>'Strategy',
                                                'Casual Games'=>'Casual games',
                                                'Puzzle'=>'Puzzle',
                                                'Shoot em up'=>'Shoot em up',
                                                'Racing'=>'Racing',
                                                'Sports'=>'Sports',
                                                'Music'=>'Music games',
                                                'Fighting'=>'Fighting',
                                                'Virtual novels'=>'Virtual novels'
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
                /*
                $personality = new Zend_Form_Element_Text('personality');
                $personality->setRequired(false) 
                             ->addValidator('StringLength',array('max'=>30,'allowWhiteSpace'=>true));
				*/
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