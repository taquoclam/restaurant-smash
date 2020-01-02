<?php 
class Database{

  private $db;
  public function __construct($connection){
      $this->db = $connection;

  }
  
  public function insert_row($table, $columns, $values){
    $query = "INSERT INTO ". $table . "(";
    $pre = ""; 
    foreach ($columns as $key => $value){
      if ($key == 1){
        $query = $query . $value;
        $pre = $pre . "$" . $key;
      }else {
		echo($key);
        $query = $query . "," . $value;
        $pre = $pre . ",$" . $key;
      }
    }
    $query = $query .") VALUES (" .$pre . ")";
	echo($query);
    if (!$result = pg_prepare($this->db, "myQuery", $query)){
      $error[] = "Invalid Request";
      return false;
    }
    if (!$result = pg_execute($this->dbconn, "myQuery", $values)){
			$error[] = "Invalid Info";
      return false;
		}
   return true;
  }
  

  public function delete_row ($table, $condition){
    // place holder for unneed function
    $error[] = "This command is unavailable";
    return false;
  }
  
  public function update_row ($table, $columns, $value, $condition){
    $query = "UPDATE ". $table . " SET ";
    $pre = ""; 
    foreach ($columns as $key => $value){
      if ($key == 1){
        $query = $query . $value . " = " . $key. " ";
      }else {
        $query = $query ."," . $value . " = " . $key. " ";
      }
    }
    $query = $query ." WHERE ". $condition;
    if (!$result = pg_prepare($this->db, "myQuery", $query)){
      $error[] = "Invalid Request";
      return false;
    }
    if (!$result = pg_execute($this->dbconn, "myQuery", $values)){
			$error[] = "Invalid Info";
      return false;
		}
   return true;
  }
  
  public function find_row  ($table, $columns, $value, $condition){
    $query = "SELECT ";
    $pre = ""; 
    foreach ($columns as $key => $value){
      if ($key == 1){
        $query = $query . $value;
      }else {
        $query = $query ."," .$value;
      }
    }
    $query = $query ." FROM ". $table . " WHERE " . $condition ;
    if (!$result = pg_prepare($this->db, "myQuery", $query)){
      $error[] = "Invalid Request";
      return null;
    }
    if (!$result = pg_execute($this->db, "myQuery", array())){
			$error[] = "Invalid Info";
      return null;
		}
   return $result;
  }
  
  public function execute_query($query, $temp ,$conditions){
  	if (!$result = pg_prepare($this->db, $temp , $query)){
      $errors[] = "Invalid Request";
      return null;
    }
    if (!$result = pg_execute($this->db,  $temp , $conditions)){
		$errors[] = "Invalid Info";
      	return null;
	}
   return $result;
  }
}
?>
