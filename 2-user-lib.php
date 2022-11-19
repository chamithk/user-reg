<?php
class Users {
  // (A) CONSTRUCTOR - CONNECT TO DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = null;
  function __construct () { try {
    $this->pdo = new PDO(
      "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
      DB_USER, DB_PASSWORD, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  } catch (Exception $ex) { exit($ex->getMessage()); }}

  // (B) DESTRUCTOR - CLOSE DATABASE CONNECTION
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  // (C) RUN SQL QUERY
  // $sql : sql to run
  // $data : data to bind
  function query ($sql, $data=null) {
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($data);
  }

  // (D) GET USER BY ID OR EMAIL
  //  $id : email or user id
  function get ($id) {
    $this->query(sprintf("SELECT * FROM `users` WHERE `user_%s`=?",
      is_numeric($id) ? "id" : "email"
    ), [$id]);
    return $this->stmt->fetch();
  }

  // (E) REGISTER USER
  //  $name : user name
  //  $email : user email
  //  $pass : password
  function register ($name, $email, $pass) {
    // (E1) CHECK
    if (is_array($this->get($email))) {
      $this->error = "$email is already registered";
      return false;
    }

    // (E2) ADD NEW USER
    $this->query(
      "INSERT INTO `users` (`user_name`, `user_email`, `user_password`) VALUES (?,?,?)",
      [$name, $email, password_hash($pass, PASSWORD_DEFAULT)]
    );
    return true;
  }
}

// (F) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "localhost");
define("DB_NAME", "test");
define("DB_CHARSET", "utf8");
define("DB_USER", "root");
define("DB_PASSWORD", "");

// (G) CREATE USER OBJECT
$USR = new Users();