<?php
class Compete {

	public function __construct() {

    	}
	public function selectrestaurants($u){
		$curr = pg_fetch_array($_SESSION['database']->execute_query("SELECT resid1, resid2 FROM appVotePool WHERE currentvote = 1 and userID = $1","getcurr",array($u)));
		if(isset($curr['resid1'])){
			$answer = pg_fetch_array($_SESSION['database']->execute_query("SELECT a.resname res1,b.resname res2,resid1 res1id,resid2 res2id, a.point point1, b.point point2 FROM appVotePool as vp JOIN appres as a ON a.resID = vp.resid1 JOIN appres as b on b.resID = vp.resid2 where userid=$1 and a.resID = $2 AND b.resID = $3 ","res1",array($u,$curr['resid1'], $curr['resid2'])));
			$_SESSION["restaurant1"] = $answer['res1'];
			$_SESSION["restaurant2"] = $answer['res2'];
			$_SESSION["res1id"] = $answer['res1id'];
			$_SESSION["res2id"] = $answer['res2id'];
			$_SESSION["res1point"] = $answer['point1'];
			$_SESSION["res2point"] = $answer['point2'];
		} 
		else{
			$answer = pg_fetch_array($_SESSION['database']->execute_query("SELECT a.resname res1,b.resname res2,resid1 res1id,resid2 res2id, a.point point1, b.point point2 FROM appVotePool as vp JOIN appres as a ON a.resID = vp.resid1 JOIN appres as b on b.resID = vp.resid2 where userid=$1 ORDER BY RANDOM() LIMIT 1","res1",array($u)));
			$_SESSION["restaurant1"] = $answer['res1'];
			$_SESSION["restaurant2"] = $answer['res2'];
			$_SESSION["res1id"] = $answer['res1id'];
			$_SESSION["res2id"] = $answer['res2id'];
			$_SESSION["res1point"] = $answer['point1'];
			$_SESSION["res2point"] = $answer['point2'];
			$_SESSION['database']->execute_query("UPDATE appVotePool as a SET currentvote = 1 where a.resid1 = $1 and a.resid2 = $2 and userID = $3","setcurr",array($answer['res1id'],$answer['res2id'],$u));
			
		}
		// $ret = $_SESSION['database']->execute_query("DELETE FROM appVotePool WHERE userid=$1 AND resid1=$2 AND resid2 =$3","delpair",array($u,$_SESSION["restaurant1"], $_SESSION["restaurant2"]));
	}

}
?>

