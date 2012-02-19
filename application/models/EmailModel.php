<?php
use Documents\User;
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
        if (!empty($areFriends)){
			//use a for loop
		for($i = 0; $i < count($areFriends); $i++) {
		    if($areFriends[$i]->hasEmailPerm()){
				    $this->emailCollect[$i] = $areFriends[$i]->getEmail();
		    }  
            }
		
            return $this->emailCollect;
        }
        
    }
    public function sendEmail($subject, $emails = null, $htmlBody, $identity)
    {        
			$mail = new Zend_Mail();
			$mail->setReplyTo('no-reply@plumetype.com', 'Plumetype');
			$mail->addHeader('MIME-Version', '1.0');
			$mail->addHeader('Content-Transfer-Encoding', '8bit');
			$mail->addHeader('X-Mailer:', 'PHP/'.phpversion());
			$mail->setBodyHtml($htmlBody);
			$mail->setFrom('no-reply@plumetype.com', 'Plumetype Friend Feed');
			$mail->addTo($identity);
			foreach($emails as $email){
			    echo 'EMAIL IS'.$email;
			    $mail->addBcc($email);
			}
			$mail->setSubject($subject);
			$mail->send();  
			
			
    }
	public function sendEmailNotification ($raw, $user, $emailHelper, $identity, $subject, $email) {
		$dateArray = explode('/',$raw['createEvent_date']);
		$private = (($raw['createEvent_private'] == 'y') ? "Yes" : "No");
		$fullName = $user->getFirstName() . " " . $user->getLastName();
		
		$htmlBody = $emailHelper->GenerateEmail('_email_send_notifications.phtml',
											 array('yourName'=>$user->getFirstName(),
																			'name'=>$fullName,
																			'location'=>$raw['createEvent_location'],
																			'date'=>$dateArray,
																			'private'=>$private
																			));
		$this->sendEmail($subject, $email, $htmlBody, $identity);
	
	}
	public function sendPasswordReset($newPassword, $email, $emailHelper, $identity, $subject) {
		$fullName = $identity->getFirstName() . " " . $identity->getLastName();
		
		$htmlBody = $emailHelper->GenerateEmail('_email_password_reset.phtml',
											 array(	'name'=>$fullName,
													'password'=>$newPassword
														));
		$this->sendEmail($subject, null, $htmlBody, $identity);
	}
	public function sendFriendedEmail($subject, $emailHelper, $identity, $requestee) {
		
		$htmlBody = $emailHelper->GenerateEmail('_email_friended.phtml',
											 array(	'name'=>$fullName));
		$this->sendEmail($subject, null, $htmlBody, $identity);
	}
    
}