<?php
session_start();
class Database
{
  private $db_host;
  private $db_port;
  private $db_user;
  private $db_pass;
  private $db_name;

  public function __construct()
  {
    $this->db_host = getenv('MYSQL_DBHOST') ? getenv('MYSQL_DBHOST') :  "localhost";
    $this->db_port = getenv('MYSQL_DBPORT') ? getenv('MYSQL_DBPORT') : "3306";
    $this->db_user = getenv('MYSQL_DBUSER') ? getenv('MYSQL_DBUSER') : "root";
    $this->db_pass = getenv('MYSQL_DBPASS') ? getenv('MYSQL_DBPASS') : "secret";
    $this->db_name = getenv('MYSQL_DBNAME') ? getenv('MYSQL_DBNAME') : "bookings";
  }

  protected function connect()
  {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli("$this->db_host:$this->db_port", $this->db_user, $this->db_pass);
    if (!mysqli_select_db($conn, $this->db_name)) {
      $create_db_query = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
      if ($this->connect()->query($create_db_query)) {
        $conn = new mysqli("$this->db_host:$this->db_port", $this->db_user, $this->db_pass, $this->db_name);
      } else {
        $errors[] = "DB : Creation failed";
      }
    }
    return $conn;
  }

  // create all the tables first
  public function migration_up()
  {
    $errors = [];

    $table_events = "CREATE TABLE IF NOT EXISTS events (
        event_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        event_name VARCHAR(30) NOT NULL,
        event_date DATE NOT NULL,
        participation_fee DECIMAL(11,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    $create_index_events = "CREATE INDEX event_name ON events(event_name);";
    $create_index_events_date = "CREATE INDEX event_date ON events(event_date);";

    $table_bookings = "CREATE TABLE IF NOT EXISTS bookings (
      participation_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      event_id VARCHAR(30) NOT NULL,
      employee_name VARCHAR(30) NOT NULL,
      employee_mail VARCHAR(50),
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    $create_index_bookings_event_id = "CREATE INDEX event_id ON bookings(event_id);";
    $create_index_bookings_employee_name = "CREATE INDEX employee_name ON bookings(employee_name);";



    $tables = [$table_events, $table_bookings, $create_index_events, $create_index_bookings_event_id, $create_index_bookings_employee_name, $create_index_events_date];


    foreach ($tables as $k => $sql) {
      $query = $this->connect()->query($sql);
      if (!$query)
        $errors[] = "Table $k : Creation failed (" . $this->connect()->error . ")";
      else
        $errors[] = "Table $k : Creation done";
    }


    // foreach ($errors as $msg) {
    //   echo "$msg <br>";
    // }

    $this->connect()->close();
  }

  // create all the tables first
  public function migration_down()
  {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $errors = [];

    $table_events = "DROP TABLE IF EXISTS events";

    $table_bookings = "DROP TABLE IF  EXISTS bookings";

    $tables = [$table_events, $table_bookings];


    foreach ($tables as $k => $sql) {
      $query = $this->connect()->query($sql);
      if (!$query)
        $errors[] = "Table $k : Deletion failed (" . $this->connect()->error . ")";
      else
        $errors[] = "Table $k : Deletion done";
    }


    // foreach ($errors as $msg) {
    //   echo "$msg <br>";
    // }

    $this->connect()->close();
  }
}
