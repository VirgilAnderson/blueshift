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

function find_all_user_individual($admin){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE user_id=" . $admin . " ";
  $sql .= "ORDER BY id DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_five_user_individual($admin){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE user_id=" . $admin . " ";
  $sql .= "ORDER BY lead_birthdate DESC ";
  $sql .= "LIMIT 5";
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

function find_individual_by_company_id($id){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE company_id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $individual = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $individual; // Returns an associative array
}

function find_all_company_individual($id){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE company_id ='" . db_escape($db, $id) . "' ";
  $sql .= "ORDER BY id DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // Returns an associative array
}

function find_all_project_individual($id){
  global $db;

  $sql = "SELECT * FROM individual ";
  $sql .= "WHERE project_id ='" . db_escape($db, $id) . "' ";
  $sql .= "ORDER BY id DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result; // Returns an associative array
}

function insert_individual($individual, $next_id){
  global $db;

  $sql = "INSERT INTO individual ";
  $sql .= "(first_name, last_name, phone_direct, email, role, lead_source, viewed, user_id, company_id, project_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $individual['first_name']) . "', ";
  $sql .= "'" . db_escape($db, $individual['last_name']) . "', ";
  $sql .= "'" . db_escape($db, $individual['phone_direct']) . "', ";
  $sql .= "'" . db_escape($db, $individual['email']) . "', ";
  $sql .= "'" . db_escape($db, $individual['role']) . "', ";
  $sql .= "'" . db_escape($db, $individual['lead_source']) . "', ";
  $sql .="'0', ";
  $sql .= "'" . db_escape($db, $individual['user_id']) . "', ";
  if($individual['company_id']=='none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $individual['company_id']) . "', ";
  }
  if($individual['project_id']=='none'){
    $sql .= 'NULL ';
  } else {
    $sql .= "'" . db_escape($db, $individual['project_id']) . "'";
  }
  $sql .= "); ";

  $sql .= "INSERT INTO history ";
  $sql .= "(action, individual_id) ";
  $sql .= "VALUES ('Lead Created', ";
  $sql .= "'" . $next_id . "');";

  $result = mysqli_multi_query($db, $sql);
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

function last_id(){
  $lead_set = find_all_individual();
  $largest = 0;
  while($lead = mysqli_fetch_assoc($lead_set)){
    if($lead['id'] > $largest){
        $largest = $lead['id'];
    }
  }

  return $largest + 1;

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

  $sql .= "DELETE FROM individual ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1;";

  $result = mysqli_multi_query($db, $sql);

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
  $sql .= "lead_birthdate='" . db_escape($db, $individual['lead_birthdate']) . "', ";
  $sql .= "company_id='" . db_escape($db, $individual['company_id']) . "', ";
  $sql .= "user_id='" . db_escape($db, $individual['user_id']) . "' ";
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

function insert_company_into_individual($individual, $id){
  global $db;

  $sql = "UPDATE individual SET ";
  $sql .= "company_id='" . db_escape($db, $individual['company_id']) .  "' ";
  $sql .= "WHERE id='" . $id . "';";

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

function insert_project_into_individual($individual, $id){
  global $db;

  $sql = "UPDATE individual SET ";
  $sql .= "project_id='" . db_escape($db, $individual['project_id']) .  "' ";
  $sql .= "WHERE id='" . $id . "';";

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

// companies

function insert_company($company, $next_id){
  global $db;


  $sql = "INSERT INTO company ";
  $sql .= "(company_name, company_address, company_city, company_state, company_zip, company_url, company_phone, user_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $company['company_name']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_address']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_city']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_state']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_zip']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_url']) . "', ";
  $sql .= "'" . db_escape($db, $company['company_phone']) . "', ";
  $sql .= "'" . db_escape($db, $company['user_id']) . "'";
  $sql .= "); ";

  $sql .= "INSERT INTO history ";
  $sql .= "(action, company_id) ";
  $sql .= "VALUES ('Company Created', ";
  $sql .= "'" . $next_id . "');";


  $result = mysqli_multi_query($db, $sql);
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

function find_company_by_id($id){
  global $db;

  $sql = "SELECT * FROM company ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $company = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $company; // Returns an associative array
}

function find_all_user_company($admin){
  global $db;

  $sql = "SELECT * FROM company ";
  $sql .= "WHERE user_id=" . $admin . " ";
  $sql .= "ORDER BY company_name DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_company(){
  global $db;

  $sql = "SELECT * FROM company ";
  $sql .= "ORDER BY company_name DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function update_company($company){
  global $db;

  $sql = "UPDATE company SET ";
  $sql .= "company_name='" . db_escape($db, $company['company_name']) . "', ";
  $sql .= "company_address='" . db_escape($db, $company['company_address']) . "', ";
  $sql .= "company_city='" . db_escape($db, $company['company_city']) . "', ";
  $sql .= "company_state='" . db_escape($db, $company['company_state']) . "', ";
  $sql .= "company_zip='" . db_escape($db, $company['company_zip']) . "', ";
  $sql .= "company_url='" . db_escape($db, $company['company_url']) . "', ";
  $sql .= "company_phone='" . db_escape($db, $company['company_phone']) . "', ";
  $sql .= "user_id='" . db_escape($db, $company['user_id']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $company['id']) . "' ";
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

function delete_company($id){
  global $db;

  $sql .= "DELETE FROM company ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1; ";


  $result = mysqli_multi_query($db, $sql);

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

function last_company_id(){
  $company_set = find_all_company();
  $largest = 0;
  while($company = mysqli_fetch_assoc($company_set)){
    if($company['id'] > $largest){
        $largest = $company['id'];
    }
  }

  return $largest + 1;

  }

// tasks

function insert_task($task, $next_id){
  global $db;

  $sql = "INSERT INTO tasks ";
  $sql .= "(task_name, task_type, task_state, task_description, due_date, individual_id, company_id, project_id, user_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $task['task_name']) . "', ";
  $sql .= "'" . db_escape($db, $task['task_type']) . "', ";
  $sql .= "'" . db_escape($db, $task['task_state']) . "', ";
  $sql .= "'" . db_escape($db, $task['task_description']) . "', ";
  $sql .= "'" . db_escape($db, $task['due_date']) . "', ";
  if($task['individual_id'] == 'none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $task['individual_id']) . "', ";
  }
  if($task['company_id'] == 'none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $task['company_id']) . "', ";
  }
  if($task['project_id'] == 'none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $task['project_id']) . "', ";
  }
  $sql .= "'" . db_escape($db, $task['user_id']) . "'";
  $sql .= ");";

  $sql .= "INSERT INTO history ";
  $sql .= "(action, task_id) ";
  $sql .= "VALUES ('Task Created', ";
  $sql .= "'" . $next_id . "');";

  $result = mysqli_multi_query($db, $sql);
  // For Insert Statements, result is True False
  if($result){
    return true;
  }
}

function find_all_task(){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "ORDER BY due_date DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_task_by_id($id){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $task = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $task; // Returns an associative array
}

function find_all_user_tasks($admin){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE user_id=" . $admin . " ";
  $sql .= "ORDER BY due_date DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_five_task_user($admin){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE user_id=" . $admin . " AND ";
  $sql .= "task_state='Open' ";
  $sql .= "ORDER BY due_date DESC ";
  $sql .= "LIMIT 5";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_task_individual($individual){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE individual_id='" . db_escape($db, $individual) . "' ";
  $sql .= "ORDER BY due_date DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_task_company($company){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE company_id=" . db_escape($db, $company['id']) . " ";
  $sql .= "ORDER BY due_date DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_task_project($project){
  global $db;

  $sql = "SELECT * FROM tasks ";
  $sql .= "WHERE project_id=" . db_escape($db, $project['id']) . " ";
  $sql .= "ORDER BY id DESC";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function update_task($task){
  global $db;

  $sql = "UPDATE tasks SET ";
  $sql .= "task_name='" . db_escape($db, $task['task_name']) . "', ";
  $sql .= "task_type='" . db_escape($db, $task['task_type']) . "', ";
  $sql .= "task_state='" . db_escape($db, $task['task_state']) . "', ";
  $sql .= "task_description='" . db_escape($db, $task['task_description']) . "', ";
  $sql .= "due_date='" . db_escape($db, $task['due_date']) . "', ";
  if($task['individual_id'] == 'none'){
    $sql .= 'individual_id= NULL, ';
  } else {
    $sql .= "individual_id='" . db_escape($db, $task['individual_id']) . "', ";
  }
  if($task['company_id'] == 'none'){
    $sql .= 'company_id= NULL, ';
  } else {
    $sql .= "company_id='" . db_escape($db, $task['company_id']) . "', ";
  }
  if($task['user_id'] == 'none'){
    $sql .= 'user_id= NULL ';
  } else {
    $sql .= "user_id='" . db_escape($db, $task['user_id']) . "' ";
  }
  $sql .= "WHERE id='" . db_escape($db, $task['id']) . "' ";
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

function delete_task($id){
  global $db;

  $sql = "DELETE FROM tasks ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1; ";

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

function insert_company_into_task($company, $id){
  global $db;

  $sql = "UPDATE tasks SET ";
  $sql .= "company_id='" . db_escape($db, $company['company_id']) .  "' ";
  $sql .= "WHERE id='" . $id . "';";

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

function insert_individual_into_task($individual, $id){
  global $db;

  $sql = "UPDATE tasks SET ";
  $sql .= "individual_id='" . db_escape($db, $individual['individual_id']) .  "' ";
  $sql .= "WHERE id='" . $id . "';";

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

function last_task_id(){
  $task_set = find_all_task();
  $largest = 0;
  while($task = mysqli_fetch_assoc($task_set)){
    if($task['id'] > $largest){
        $largest = $task['id'];
    }
  }

  return $largest + 1;

  }

// notes

function insert_note($note, $next_id){
  global $db;


  $sql = "INSERT INTO notes ";
  $sql .= "(note, individual_id, user_id, company_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $note['note']) . "', ";
  if($note['individual_id'] == 'none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $note['individual_id']) . "', ";
  }
  $sql .= "'" . db_escape($db, $note['user_id']) . "', ";
  if($note['company_id'] == 'none'){
    $sql .= 'NULL';
  } else {
    $sql .= "'" . db_escape($db, $note['company_id']) . "' ";
  }
  $sql .= "); ";

  $sql .= "INSERT INTO history ";
  $sql .= "(action, note_id) ";
  $sql .= "VALUES ('Note created', ";
  $sql .= "'" . $next_id . "');";

  $result = mysqli_multi_query($db, $sql);
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

function find_all_note(){
  global $db;

  $sql = "SELECT * FROM notes ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_user_notes($individual){
  global $db;

  $sql = "SELECT * FROM notes ";
  $sql .= "WHERE individual_id='" . db_escape($db, $individual['id']) . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_company_notes($company){
  global $db;

  $sql = "SELECT * FROM notes ";
  $sql .= "WHERE company_id='" . db_escape($db, $company['id']) . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_project_notes($project){
  global $db;

  $sql = "SELECT * FROM notes ";
  $sql .= "WHERE project_id='" . db_escape($db, $project['id']) . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_note_by_id($id){
  global $db;

  $sql = "SELECT * FROM notes ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $note = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $note; // Returns an associative array
}

function update_note($note){
  global $db;

  $sql = "UPDATE notes SET ";
  $sql .= "note='" . db_escape($db, $note['note']) . "', ";
  $sql .= "individual_id='" . db_escape($db, $note['individual_id']) . "', ";
  $sql .= "user_id='" . db_escape($db, $note['user_id']) . "', ";
  $sql .= "company_id='" . db_escape($db, $note['company_id']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $note['id']) . "'; ";

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

function delete_note($id){
  global $db;

  $sql = "DELETE FROM notes ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1; ";

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

function insert_company_into_note($company, $id){
  global $db;

  $sql = "UPDATE notes SET ";
  $sql .= "company_id='" . db_escape($db, $company['company_id']) .  "' ";
  $sql .= "WHERE id='" . $id . "';";

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

function last_note_id(){
  $note_set = find_all_note();
  $largest = 0;
  while($note = mysqli_fetch_assoc($note_set)){
    if($note['id'] > $largest){
        $largest = $note['id'];
    }
  }

  return $largest + 1;

  }

// history

function find_history_by_individual_id($id){
  global $db;

  $sql = "SELECT * FROM history ";
  $sql .= "WHERE individual_id='" . $id . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_history_by_company_id($id){
  global $db;

  $sql = "SELECT * FROM history ";
  $sql .= "WHERE company_id='" . $id . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_history_by_task_id($id){
  global $db;

  $sql = "SELECT * FROM history ";
  $sql .= "WHERE task_id='" . $id . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_history_by_note_id($id){
  global $db;

  $sql = "SELECT * FROM history ";
  $sql .= "WHERE note_id='" . $id . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_history_by_project_id($id){
  global $db;

  $sql = "SELECT * FROM history ";
  $sql .= "WHERE project_id='" . $id . "' ";
  $sql .= "ORDER BY time DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

// projects

function last_project_id(){
  $project_set = find_all_project();
  $largest = 0;
  while($project = mysqli_fetch_assoc($project_set)){
    if($project['id'] > $largest){
        $largest = $project['id'];
    }
  }

  return $largest + 1;

  }

function find_all_project(){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "ORDER BY id DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_five_user_project($admin){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE user_id='" . $admin . "' ";
  $sql .= "AND project_state<>'Complete' ";
  $sql .= "AND project_state<>'Cancelled' ";
  $sql .= "ORDER BY id DESC ";
  $sql .= "LIMIT 5";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_all_user_project($admin){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE user_id='" . $admin . "' ";
  $sql .= "AND project_state<>'Complete' ";
  $sql .= "AND project_state<>'Cancelled' ";
  $sql .= "ORDER BY id DESC ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function insert_project($project, $next_id){
  global $db;

  $sql = "INSERT INTO project ";
  $sql .= "(project_title, project_state, project_description, company_id, user_id) ";
  $sql .= "VALUES (";
  $sql .= "'" . db_escape($db, $project['project_title']) . "', ";
  $sql .= "'" . db_escape($db, $project['project_state']) . "', ";
  $sql .= "'" . db_escape($db, $project['project_description']) . "', ";
  if($project['company_id']=='none'){
    $sql .= 'NULL, ';
  } else {
    $sql .= "'" . db_escape($db, $project['company_id']) . "', ";
  }
  $sql .= "'" . db_escape($db, $project['user_id']) . "' ";
  $sql .= "); ";

  $sql .= "INSERT INTO history ";
  $sql .= "(action, project_id) ";
  $sql .= "VALUES ('Project Created', ";
  $sql .= "'" . $next_id . "');";

  $result = mysqli_multi_query($db, $sql);
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

function find_project_by_id($id){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $project = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $project; // Returns an associative array
}

function find_project_by_company_id($id){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE company_id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $project = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $project; // Returns an associative array
}

function find_project_by_individual_id($id){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE individual_id ='" . db_escape($db, $id) . "' ";
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $project = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $project; // Returns an associative array
}

function find_project_by_task_id($id){
  global $db;

  $sql = "SELECT * FROM project ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  $project = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  return $project; // Returns an associative array
}

function update_project($project){
  global $db;

  $sql = "UPDATE project SET ";
  $sql .= "project_title='" . db_escape($db, $project['project_title']) . "', ";
  $sql .= "project_state='" . db_escape($db, $project['project_state']) . "', ";
  $sql .="project_description='" . db_escape($db, $project['project_description']) . "', ";
  if($project['company_id'] == 'none'){
    $sql .= 'company_id=NULL, ';
  } else {
    $sql .="company_id='" . db_escape($db, $project['company_id']) . "', ";
  }
  if($project['user_id'] == 'none'){
    $sql .= 'user_id=NULL ';
  } else {
    $sql .="user_id='" . db_escape($db, $project['user_id']) . "' ";
  }
  $sql .= "WHERE id='" . db_escape($db, $project['id']) . "'; ";

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

function delete_project($id){
  global $db;

  $sql .= "DELETE FROM project ";
  $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
  $sql .= "LIMIT 1;";

  $result = mysqli_multi_query($db, $sql);

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


  $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

  $sql = "UPDATE user SET ";
  $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
  $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
  $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
  $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
  $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
  $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
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

  $sql = "DELETE FROM user ";
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
