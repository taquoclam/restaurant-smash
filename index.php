<?php
	ini_set('display_errors', 'off');
	require_once "lib/lib.php";
	require_once "model/Compete.php";
	require_once "model/Database.php";
	require_once "model/User.php";
	require_once "model/Rating.php";
	
	session_save_path("sess");
	session_start(); 

	$_SESSION['database'] = new Database(db_connect());
	$errors=array();
	$view="";

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	switch($_SESSION['state']){
		case "unavailable":
			$view="unavailable.php";
			break;

		case "login":
			// the view we display by default
			$view="login.php";
			if(!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'register'){
				$_SESSION['state'] = 'register';
				$view = 'register.php';
				break;
			}
			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;
			$_SESSION['user'] = new User();
			// perform operation, switching state and view if necessary
			if(!$_SESSION['database']) return;
            $result = $_SESSION['user']->connect_user($_REQUEST["user"], $_REQUEST["password"]);
            if($result){
				$_SESSION['state']='compete';
				$view='compete.php';
				break;
			} else {
				$errors[]="invalid login";
				break;
			}
			break;
      
      	case "register": 
			//the view of register page
			$view="register.php";
			if(!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'login'){
				$_SESSION['state'] = 'login';
				$view = 'login.php';
				break;
			}

			//check database with this instruction 
			if(!$_SESSION['database']) return;
			$_SESSION['user'] = new User();
			if ($_REQUEST["password"] != $_REQUEST["passwordConfirmation"]){
				$errors[]='password does not match';	
				break;			
			}
			if ($_REQUEST["user"] == null || $_REQUEST["password"] == null || $_REQUEST["firstName"] == null || $_REQUEST["lastName"] == null || $_REQUEST["email"]== null  || $_REQUEST["gender"] == null){
				$errors[] = "Input is empty";
				break;
			}
			if ($_REQUEST["gender"] == 'female' || $_REQUEST["gender"] == 'male' || preg_match('^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$', $_REQUEST["email"])){
			} else {
				$errors[]='inputs are invalid'; 
				break;
			}
      		$result = $_SESSION['user']->register($_REQUEST["user"], $_REQUEST["password"], $_REQUEST["firstName"], $_REQUEST["lastName"], $_REQUEST["email"], $_REQUEST["gender"]);
      		if($result){
       	 		$_SESSION['user']->populate_restaurant($_REQUEST["user"]);
				$_SESSION['state']='login';
				$view='login.php';
				break;
			} else {
				$errors[]='invalid register';
				break;
			}
			break;
      
      
		case "compete":
			$view = 'compete.php';
			
			
			if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'logout'){
			$_SESSION['state'] = 'logout';
				$view='logout.php';
				break;
			}
	       if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'results'){
				$_SESSION['state'] = 'results';
				$view='results.php';
				break;
			}
	       if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'profile'){
				$_SESSION['state'] = 'profile';
				$view='profile.php';
				break;

			} 
			if (!empty($_REQUEST["submit"]) && $_REQUEST["submit"] != "choose") {break;}
			if(empty($_REQUEST['choose'])) {
				break;			
			}
			if (isset($_REQUEST['choose'])){
		
				$_SESSION['user']->vote();
				unset($_REQUEST['choose']);
				header("Location:?currentpage=compete");
				break;
			}
			break;
		
   
    case "results":
      $view = 'results.php';
      if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'compete'){
				$_SESSION['state'] = 'compete';
				$view='compete.php';
				break;
			}
      
      if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'profile'){
				$_SESSION['state'] = 'profile';
				$view='profile.php';
				break;
			}
      
      if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'logout'){
				$_SESSION['state'] = 'logout';
				$view='logout.php';
				break;
			}
      break;
      
   case "profile":
       $view = 'profile.php';
		if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'results'){
				$_SESSION['state'] = 'results';
				$view='results.php';
				break;
			}
      if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'compete'){
				$_SESSION['state'] = 'compete';
				$view='compete.php';
				break;
			}
      if (!empty($_REQUEST['currentpage']) && $_REQUEST['currentpage'] == 'logout'){
				$_SESSION['state'] = 'logout';
				$view='logout.php';
				break;
			}
		if(!empty($errors))break;
			//check database with this instruction 
			if(!$_SESSION['database']) return;
			if (!isset($_REQUEST['submit']) || $_REQUEST['submit'] != 'profile'){break;}
       $result = $_SESSION['user']->update_user($_REQUEST['user'], $_REQUEST['password'], $_REQUEST['firstName'], $_REQUEST['lastName'], $_REQUEST['email'], $_REQUEST['gender']);
		if(!$result){
			$errors[] = "Cant not update your profile";
			$errors[] = "tips: please check password or cookie";
			break;
		}
       
      	if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}
      break;
      
      
		
		case "logout":
			$_SESSION['state']='login';
			$view='login.php'; 
			break; 
	}
	require_once "view/$view";
?>
