<?php
use Documents\Wall;
use Documents\WallPost;
class Application_Model_WallModel{
	private $wall;
	private $dm;
	public function __construct(Wall $wall){
		$this->dm = Zend_Registry::get('Wildkat\DoctrineContainer')->getDocumentManager('default');
		$this->wall = $wall;
	}
	//the illegal offset problem is caused by a wrongly declared variable
	public function addPost(Documents\User $user,$message){
		$wallPost = new WallPost($user,$this->wall, $message);
		$this->wall->addWallPost($wallPost);
		$this->dm->persist($wallPost);
		$this->dm->persist($this->wall);
		$this->dm->flush();
	}
	//tomorrow check how to reset the list of wallposts
	public function deletePost($id,$user){
		
		$wallPosts = $this->wall->getWallPosts();
		for($i = 0; $i < count($wallPosts);$i++){
			if($wallPosts[$i]->getPostId() == $id){
				if($wallPosts[$i]->getUser()->getEmail() == $user->getEmail()){
					//echo 'count is before'.count($wallPosts);
					$this->dm->remove($wallPosts[$i]);
					unset($wallPosts[$i]);
					
					//echo 'count is'.count($wallPosts);
					//echo $wallPosts[$i]->getUser()->getEmail();
					//echo $wallPosts;
					if(count($wallPosts) > 0)
						$this->wall->setWallPosts(Application_Model_Utils_CollectionUtil::collection_values($wallPosts));
					else
						$this->wall->setWallPosts();
				}
	
			}
		}
		$this->dm->persist($this->wall);
		//$this->dm->persist($this->wall->getWallPosts());
		$this->dm->flush();
	}
	public function getPosts(){
		return $this->wall->getWallPosts();
	}
}