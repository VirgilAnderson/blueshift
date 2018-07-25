<?php
// Individual
function find_all_individual(){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "ORDER BY lead_birthdate DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_new_individual(){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE viewed='0' ";
  $sql .= "ORDER BY lead_birthdate DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_newest_5_individual(){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "ORDER BY lead_birthdate DESC ";
  $sql .= "LIMIT 5";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_individual_by_id($id){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $individual = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $individual; // Returns an associative array
}

function insert_individual($individual){
  global $db;

  //$errors = validate_individual($individual);
  //if(!empty($errors)){
  //  return $errors;
  //}

  // shift_subject_position(0, $subject['position']);

  $sql = "INSERT INTO individual ";
  $sql .= "(first_name, last_name, phone_direct, email, role, lead_source, viewed) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $individual['first_name']) . "', ";
  $sql .= "'" . db_escape($db, $individual['last_name']) . "', ";
  $sql .= "'" . db_escape($db, $individual['phone_direct']) . "', ";
  $sql .= "'" . db_escape($db, $individual['email']) . "', ";
  $sql .= "'" . db_escape($db, $individual['role']) . "', ";
  $sql .= "'" . db_escape($db, $individual['lead_source']) . "', ";
  $sql .="'0'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // For Insert Statements, result is True False
  if($result){
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function individual_visited($individual){
  global $db;

  $sql = "UPDATE individual SET ";
  $sql .= "viewed=1, ";
  $sql .= "lead_birthdate='" . db_escape($db, $individual['lead_birthdate']) . "' ";
  $sql .= "WHERE id ='" . db_escape($db, $individual['id']) . "'; ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
}

function delete_individual($id){
  global $db;

  $sql = "DELETE FROM individual ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);

  // For DELETE statements, $result is true/false
  if($result){
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_individual($individual){
  global $db;

  $sql = "UPDATE individual SET ";
  $sql .= "first_name='" . db_escape($db, $individual['first_name']) . "', ";
  $sql .= "last_name='" . db_escape($db, $individual['last_name']) . "', ";
  $sql .= "phone_direct='" . db_escape($db, $individual['phone_direct']) . "', ";
  $sql .= "email='" . db_escape($db, $individual['email']) . "', ";
  $sql .= "role='" . db_escape($db, $individual['role']) . "', ";
  $sql .= "lead_source='" . db_escape($db, $individual['lead_source']) . "', ";
  $sql .= "lead_birthdate='" . db_escape($db, $individual['lead_birthdate']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $individual['id']) . "' ";
  $sql .= "LIMIT 1;";

  $result = mysqli_query($db, $sql);
  // For UPDATE Statements, result is true/false

  if($result){
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function validate_subject($subject){

  $errors = [];

  // menu_name
  if(is_blank($subject['menu_name'])){
    $errors[] = "Name cannot be blank.";
  } elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])){
    $errors[] = "Name must be within 2 and 255 characters.";
  }

  // Position
  // Make sure we are working with an integer
  $position_int = (int) $subject['position'];
  if($position_int <= 0){
    $errors[] = "Position must be greater than zero.";
  }
  if($position_int > 999){
    $errors[] = "Position must be less than 999.";
  }

  // visible
  // Make sure we are working with a string
  $visible_str=(string) $subject['visible'];
  if(!has_inclusion_of($visible_str, ["0", "1"])){
    $errors[] = "Visible must be true or false.";
  }

  return $errors;
}

function shift_subject_position($start_pos, $end_pos, $current_id=0) {
  global $db;

  if($start_pos == $end_pos) { return; }

  $sql = "UPDATE subjects ";
  if($start_pos == 0) {
    // new item, +1 to items greater than $end_pos
    $sql .= "SET position = position + 1 ";
    $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
  } elseif($end_pos == 0) {
    // delete item, -1 from items greater than $start_pos
    $sql .= "SET position = position - 1 ";
    $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
  } elseif($start_pos < $end_pos) {
    // move later, -1 from items between (including $end_pos)
    $sql .= "SET position = position - 1 ";
    $sql .= "WHERE position > '" . db_escape($db, $start_pos) . "' ";
    $sql .= "AND position <= '" . db_escape($db, $end_pos) . "' ";
  } elseif($start_pos > $end_pos) {
    // move earlier, +1 to items between (including $end_pos)
    $sql .= "SET position = position + 1 ";
    $sql .= "WHERE position >= '" . db_escape($db, $end_pos) . "' ";
    $sql .= "AND position < '" . db_escape($db, $start_pos) . "' ";
  }
  // Exclude the current_id in the SQL WHERE clause
  $sql .= "AND id != '" . db_escape($db, $current_id) . "' ";

  $result = mysqli_query($db, $sql);
  // For UPDATE statements, $result is true/false
  if($result) {
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

// Pages

function find_all_pages(){
  global $db;
  $sql = "SELECT * FROM pages ";
  $sql .= "ORDER BY subject_id ASC, position ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_page_by_id($id, $options=[]){
  global $db;

  $visible = isset($options['visible']) ? $options['visible'] : false;
  $sql = "SELECT * FROM pages ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  if($visible){
    $sql .= "AND visible = true ";
  }
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $page = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $page; // Returns an associative array
}

function insert_page($page){
  global $db;
  $sql = "INSERT INTO pages ";
  $sql .= "(menu_name, subject_id, position, visible) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $page['menu_name']) . "', ";
  $sql .= "'" . db_escape($db, $page['subject_id']) . "', ";
  $sql .= "'" . db_escape($db, $page['position']) . "', ";
  $sql .= "'" . db_escape($db, $page['visible']) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);
  // For Insert Statements, result is True False
  if($result){
    return true;
  } else {
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function delete_page($id){
  global $db;
  $sql = "DELETE FROM pages ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);

  // For DELETE statements, $result is true/false
  if($result){
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_page($page){
  global $db;

  $errors = validate_page($page);
  if(!empty($errors)){
    return $errors;
  }

  $sql = "UPDATE pages SET ";
  $sql .= "menu_name='" . db_escape($db, $page['menu_name']) . "', ";
  $sql .= "subject_id='" . db_escape($db, $page['subject_id']) . "', ";
  $sql .= "position='" . db_escape($db, $page['position']) . "', ";
  $sql .= "visible='" . db_escape($db, $page['visible']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $page['id']) . "' ";
  $sql .= "LIMIT 1";

  $result = mysqli_query($db, $sql);
  // For UPDATE Statements, result is true/false

  if($result){
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function validate_page($page){

  $errors = [];

  // menu_name
  if(is_blank($page['menu_name'])){
    $errors[] = "Name cannot be blank.";
  } elseif(!has_length($page['menu_name'], ['min' => 2, 'max' => 255])){
    $errors[] = "Name must be within 2 and 255 characters.";
  }

  // Position
  // Make sure we are working with an integer
  $position_int = (int) $page['position'];
  if($position_int <= 0){
    $errors[] = "Position must be greater than zero.";
  }
  if($position_int > 999){
    $errors[] = "Position must be less than 999.";
  }

  // visible
  // Make sure we are working with a string
  $visible_str=(string) $page['visible'];
  if(!has_inclusion_of($visible_str, ["0", "1"])){
    $errors[] = "Visible must be true or false.";
  }

  return $errors;
}

function find_pages_by_subject_id($subject_id, $options=['visible']){
  global $db;
  $visible = isset($options['visible']) ? $options['visible'] : false;

  $sql = "SELECT * FROM pages ";
  $sql .= "WHERE subject_id ='" . db_escape($db, $subject_id) . "' ";
  if($visible){
    $sql .= "AND visible = true ";
  }
  $sql .= "ORDER BY position ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // Returns result
}

function count_pages_by_individual_id($subject_id, $options=['visible']){
  global $db;
  $visible = isset($options['visible']) ? $options['visible'] : false;

  $sql = "SELECT COUNT(id) FROM pages ";
  $sql .= "WHERE subject_id ='" . db_escape($db, $subject_id) . "' ";
  if($visible){
    $sql .= "AND visible = true ";
  }
  $sql .= "ORDER BY position ASC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $row = mysqli_fetch_row($result);
  mysqli_free_result($result);
  $count = $row[0];
  return $count; // Returns result
}

// admins

function find_all_admins(){
  global $db;

  $sql = "SELECT * FROM user ";
  $sql .= "ORDER BY last_name ASC, first_name ASC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;

}

function find_admin_by_id($id){
  global $db;

  $sql = "SELECT * FROM user ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "Limit 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $admin = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $admin;
}

function find_admin_by_username($username){
  global $db;

  $sql = "SELECT * FROM user ";
  $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
  $sql .= "Limit 1";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $admin = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $admin;
}

function validate_admin($admin){
  if(is_blank($admin['first_name'])){
    $errors[] = "First name cannot be blank.";
  } elseif(!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
    $errors[] =  "First name must be between 2 and 255 characters.";
  }

  if(is_blank($admin['last_name'])){
    $errors[] = "Last name cannot be blank.";
  } elseif(!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
    $errors[] =  "Last name must be between 2 and 255 characters.";
  }

  if(is_blank($admin['email'])){
    $errors[] = "Email cannot be blank.";
  } elseif(!has_length($admin['email'], array('max' => 255))) {
    $errors[] =  "Email must be less than 255 characters.";
  } elseif(!has_valid_email_format($admin['email'])){
    $errors[] = "Email must be valid format.";
  }

  if(is_blank($admin['username'])){
    $errors[] = "First name cannot be blank.";
  } elseif(!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
    $errors[] =  "Username must be between 8 and 255 characters.";
  } elseif (!has_unique_username($admin['username'], $admin['id'] ? $admin['id'] : 0)){
    $errors[] = "Username not allowed. Try another.";
  }

  if(is_blank($admin['password'])){
    $errors[] = "Password name cannot be blank.";
  } elseif(!has_length($admin['password'], array('min' => 12))) {
    $errors[] =  "Username must contain 12 or more characters.";
  } elseif (!preg_match('/[A-Z]/', $admin['password'])){
    $errors[] = "Password must contain atleast one uppercase letter.";
  } elseif (!preg_match('/[a-z]/', $admin['password'])){
    $errors[] = "Password must contain atleast one lowercase letter.";
  } elseif (!preg_match('/[0-9]/', $admin['password'])){
      $errors[] = "Password must contain atleast 1 number.";
  } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])){
    $errors[] = "Password must contain atleast 1 symbol.";
  }

  if(is_blank($admin['confirm_password'])){
    $error[] = "Confirm password cannot be blank";
  } elseif($admin['password'] !== $admin['confirm_password']){
    $error[]="Password and confirm password must match.";
  }

  return $errors;

}

function insert_admin($admin){
  global $db;

  $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

  $sql = "INSERT INTO user ";
  $sql .= "(first_name, last_name, email, username, hashed_password) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $admin['first_name']) . "', ";
  $sql .= "'" . db_escape($db, $admin['last_name']) . "', ";
  $sql .= "'" . db_escape($db, $admin['email']) . "', ";
  $sql .= "'" . db_escape($db, $admin['username']) . "', ";
  $sql .= "'" . db_escape($db, $hashed_password) . "'";
  $sql .= ")";
  $result = mysqli_query($db, $sql);

  // For INSERT statements, $result is true/False
  if($result){
    return true;
  } else {
    // Insert failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

function update_admin($admin){
  global $db;

  $errors = validate_admin($admin);
  if(!empty($errors)){
    return $errors;
  }

  $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

  $sql = "UPDATE admin SET ";
  $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
  $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
  $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
  $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
  $sql .= "username='" . db_escape($db, $admin['username']) . "', ";
  $sql .= "WHERE id='" . db_escapte($db, $admin['id']) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  // For UPDATE statements, $result is true/false
  if($result){
    return true;
  } else {
    // UPDATE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }

}

function delete_admin($admin){
  global $db;

  $sql = "DELETE FROM admins ";
  $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
  $sql .= "LIMIT 1";
  $result = mysqli_query($db, $sql);

  // For DELETE statements, $results are true/False
  if($result){
    return true;
  } else {
    // DELETE failed
    echo mysqli_error($db);
    db_disconnect($db);
    exit;
  }
}

 ?>
