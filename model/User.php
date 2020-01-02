<?php

include "model/Rating.php";
class User {
	private $userID;
	private $username;
	private $firstName;
	private $lastName;
	private $email;
	private $gender;

	public function __construct() {
   }


	public function register($username, $password, $firstname, $lastname, $email, $gender){
	$test = $_SESSION['database']->execute_query("SELECT * FROM appuser where username=$1","1",array($username));
	if($test != null && $row = pg_fetch_array($test)){
		$errors[]= "Username is invalid";
		return false;
	}

    $result = $_SESSION['database']->execute_query("INSERT into appuser(username,password,firstname,lastname,email, gender) values ($1,$2,$3,$4,$5,$6)", "2",
    array($username,$password,$firstname,$lastname,$email, $gender));
    if ($result != null){
		return true;
	}else{
		return false;
	}
	}
	
	public function update_user($username, $password, $firstname, $lastname, $email, $gender){
	$result = $_SESSION['database']->execute_query("SELECT * FROM appuser where userid=$1 and password=$2","3", array($this->userID, $password));
	if ($result){ 
		$row = pg_fetch_array($result);
		if ($row == null)
			return false;
	}
	$result = $_SESSION['database']->execute_query("update appuser set firstname=$1,lastname=$2,email=$3, gender=$4 where userid=$5","4", array($firstname, $lastname, $email,$gender,$this->userID));
     if ($result != null){
       $this->firstName = $firstname;
       $this->lastName = $lastname;
       $this->email = $email;
		$this->gender = $gender;
       return true;
     }
	return false;
	}

	public function connect_user($username, $password){
     $result = $_SESSION['database']->execute_query("SELECT * FROM appuser where username=$1 and password=$2","5", array($username, $password));
     if ($result != null && $row = pg_fetch_array($result)){
		$this->userID = $row['userid'];
       $this->username = $row['username'];
       $this->firstName = $row['firstname'];
       $this->lastName = $row['lastname'];
		$this->gender = $row['gender'];
       $this->email = $row['email'];
       return true;
     }
    return false;
	}
	public function getUsername(){
		return $this->username;
	}
	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;	
	}
	public function getEmail(){
		return $this->email;	
	}
	public function getUserID(){
		return $this->userID;	
	}
	public function getGender(){
		return $this->gender;	
	}
  public function populate_restaurant ($username){
    $_SESSION["database"]->execute_query("insert into appvotepool select distinct * from (select userID from appuser where username=$1) a, appResPairPool;", "populate", array($username));
  }


	public function vote(){
		if ($_REQUEST["choose"] == 1){
			$a = 1;
			$b = 0;
			$_SESSION["database"]->execute_query("UPDATE appres SET wins = wins + 1  WHERE resID = $1","win1", array($_SESSION["res1id"]));
			$_SESSION["database"]->execute_query("UPDATE appres SET losses = losses + 1  WHERE resID = $1","lose2", array($_SESSION["res2id"]));
		}else if ($_REQUEST["choose"] == 0.5){
			$a = 0.5;
			$b = 0.5;		
			$_SESSION["database"]->execute_query("UPDATE appres SET draws = draws + 1  WHERE resID = $1 OR resID = $2","draw", array($_SESSION["res1id"],$_SESSION["res2id"]));
		}else{
			$b = 1;
			$a = 0;
			$_SESSION["database"]->execute_query("UPDATE appres SET wins = wins + 1  WHERE resID = $1","win1", array($_SESSION["res2id"]));
			$_SESSION["database"]->execute_query("UPDATE appres SET losses = losses + 1  WHERE resID = $1","lose2", array($_SESSION["res1id"]));
		}
		$r = new Rating($_SESSION["res1point"],$_SESSION["res2point"],$a,$b);
		$new = array();
		$new = $r->getNewRatings();
		if ($new['a'] < 0)
			$new['a'] = 0;
		if ($new['b'] < 0)
			$new['b'] = 0;
		$_SESSION["database"]->execute_query("UPDATE appres SET oldpoint2 = oldpoint1,oldpoint1 = $2  WHERE resID = $1","old1", array($_SESSION["res1id"],$_SESSION['res1point']));
 		$_SESSION["database"]->execute_query("UPDATE appres SET oldpoint2 = oldpoint1,oldpoint1 = $2  WHERE resID = $1","old2", array($_SESSION["res2id"],$_SESSION['res2point']));
		$_SESSION["database"]->execute_query("UPDATE appres SET point = $2 WHERE resID = $1","new1", array($_SESSION["res1id"],$new['a']));
		$_SESSION["database"]->execute_query("UPDATE appres SET point = $2 WHERE resID = $1","new2", array($_SESSION["res2id"],$new['b']));
		$_SESSION['database']->execute_query("DELETE FROM appVotePool WHERE userid=$1 AND resid1=$2 AND resid2 =$3","delpair",array($this->userID,$_SESSION["res1id"], $_SESSION["res2id"]));
		
	}
     
}
?>
