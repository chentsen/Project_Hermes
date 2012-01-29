<?php
use Documents\Feed\FeedObject\FeedObject;
use Documents\Feed\FeedObject\EventFeedObject;
use Documents\Feed\FeedObject\FriendAcceptFeedObject;

class Application_Model_EmailModel extends Application_View_Helper_DisplayFeed{
    private $eid;
    private $curUser;
    public $emails = array();
    public $email;
    
	public function __construct($eid = null, $curUser = null){
          $this->mongoContainer = Zend_Registry::get('Wildkat\DoctrineContainer');
		$this->dm = $this->mongoContainer->getDocumentManager('default');
		$this->eid = $eid;
        $this->curUser = $curUser;
        
	}
	public function genFriendEmails()
    {
        $feed = $this->curUser->getEventFeed();
		$eventFeedModel = new Application_Model_Feed_EventFeedModel($feed);
        $event = $this->dm->getRepository('Documents\Event')->findOneBy(array('eid'=>$eid));
        $eventModel = new Application_Model_EventModel($event);
        
        $areFriends = $this->curUser->getFriends();
        $i = 0;
        if (!empty($areFriends))
        { 
            foreach($areFriends as $friend){
                    if($friend->hasEmailPerm())
                    {
                        $this->emails[$i] =  $friend->getEmail();
                        
                        $i++;
                    }  
            }
            
        }
        
    }
    public function sendEmail($subject, $email, $htmlBody, $identity)
    {
                    
                    
				$mail = new Zend_Mail();
					$mail->setReplyTo('no-reply@plumetype.com', 'Plumetype');
					$mail->addHeader('MIME-Version', '1.0');
					$mail->addHeader('Content-Transfer-Encoding', '8bit');
					$mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
					$mail->setBodyHtml($htmlBody);
					$mail->setFrom('no-reply@plumetype.com', 'Plumetype Friend Feed');
					$mail->addTo($identity);
					$mail->addBcc($email);
					$mail->setSubject($subject);
					$mail->send();
        
    }
    
}