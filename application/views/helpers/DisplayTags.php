<?php
/**
 * 
 * Takes a specific event and displays everyone on the waiting list
 * @author chentsen
 *
 */
class Zend_View_Helper_DisplayTags extends Zend_View_Helper_Abstract{
	
	public function DisplayTags($interests){
		$interestModel = new Application_Model_InterestModel($interests);
		$tagArray = $interestModel->getTags();
		echo '<div class = "Tags">';
		foreach($tagArray as $tag){
			echo "<div class = 'tag'>";
			echo "Tag:";
			echo $tag->getTagName().'<br />';
			echo "</div>";
		}
		echo '</div>';
		//test stuff
		$count = 2;
		echo "TEST: Tags with count above {$count}:";
		$tagModel = new Application_Model_TagModel();
		$tagModel->setRankedTags($count);
		$rankedTags = $tagModel->getRankedTags();
		foreach($rankedTags as $rankedTag){
			echo $rankedTag->getTagName().'<br />';
		}
	}
	
}