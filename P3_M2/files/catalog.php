<?php
	//initialize all the databases: modified from my project 2
	//database:Users
	class Users { 
		public $uID;
		public $uName; 
		public $uPassword;

		function __construct($uID = 0, $uName = "", $uPassword = "") { 
			$this->uID = $uID;
			$this->uName = $uName;
			$this->uPassword = $uPassword; 
		}

		function get_id(){
    		return $this->uID;
    	}

    	function get_name(){
    		return $this->uName;
    	}

    	function get_pwd(){
    		return $this->uPassword;
    	}
	}

	//database:Albums
	class Albums { 
		public $aID;
		public $aName; 
		public $aDateCreate;
		public $aDateModified;
		public $aIntro;

		function __construct($aID = 0, $aName = "", $aDateCreate = "", $aDateModified = "", $aIntro = "") { 
			$this->aID = $aID;
			$this->aName = $aName;
			$this->aDateCreate = $aDateCreate; 
			$this->aDateModified = $aDateModified;
			$this->aIntro = $aIntro;
		}

		function get_id(){
    		return $this->aID;
    	}

    	function get_name(){
    		return $this->aName;
    	}

    	function get_date(){
    		return $this->aDateCreate;
    	}

    	function get_dateModified(){
    		return $this->aDateModified;
    	}

    	function get_intro(){
    		return $this->aIntro;
    	}
	}

	//database: photos
	class Photos { 
		public $pID;
		public $pName; 
		public $pDateCreate;
		public $pURL;
		public $pIntro;
		public $uID;

		function __construct($pID = 0, $pName = "", $pDateCreate = "", $pURL = "", $pIntro = "", $uID = 0) { 
			$this->pID = $pID;
			$this->pName = $pName;
			$this->pDateCreate = $pDateCreate; 
			$this->pURL = $pURL;
			$this->pIntro = $pIntro;
			$this->uID = $uID;
		}

		function get_id(){
    		return $this->pID;
    	}

    	function get_name(){
    		return $this->pName;
    	}

    	function get_date(){
    		return $this->photoDateCreate;
    	}

    	function get_url(){
    		return $this->pURL;
    	}

    	function get_intro(){
    		return $this->pIntro;
    	}
                
        //function of user id will be implemented in milestone 3
    	function get_userid(){
    		return $this->uID;
    	}
	}

	//database: album and photo relationship
	class AP { 
		public $aID;
		public $pID;

		function __construct($aID = 0, $pID = 0) {
			$this->aID = $aID; 
			$this->pID = $pID;
		}

		function get_aid(){
    		return $this->aID;
    	}

    	function get_pid(){
    		return $this->pID;
    	}
	}

?>