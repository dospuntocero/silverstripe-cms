<?php

class FeedbackAdmin extends LeftAndMain {
	
	public function init() {
		parent::init();
		
		Requirements::javascript("cms/javascript/FeedbackAdmin_right.js");
	}
	
	public function Link($action = null) {
		return "admin/feedback/$action";
	}
	
	public function showtable($params) {
	    return $this->getLastFormIn($this->renderWith('FeedbackAdmin_right'));
	}
	
	public function EditForm() {
		$url = rtrim($_SERVER['REQUEST_URI'], '/');
		$section = substr($url, strrpos($url, '/') + 1);
		
		if($section != 'accepted' && $section != 'unmoderated' && $section != 'spam') {
			$section = 'accepted';
		}
		
		if($section == 'accepted') {
			$filter = 'IsSpam=0 AND NeedsModeration=0';
		} else if($section == 'unmoderated') {
			$filter = 'NeedsModeration=1';
		} else {
			$filter = 'IsSpam=1';
		}
		
		$tableFields = array(
			"Name" => "Author",
			"Comment" => "Comment",
			"PageTitle" => "Page"
		);
		
		$popupFields = new FieldSet(
			new TextField("Name"),
			new TextareaField("Comment", "Comment")
		);
		
		$idField = new HiddenField('ID');
		$table = new CommentTableField($this, "Comments", "PageComment", $section, $tableFields, $popupFields, $filter);
		$table->setParentClass(false);
		
		$fields = new FieldSet($idField, $table);
		$actions = new FieldSet();
		$form = new Form($this, "EditForm", $fields, $actions);
		
		return $form;
	}
}

?>