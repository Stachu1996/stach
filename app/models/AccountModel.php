<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 2/16/2019
 * Time: 10:41 PM
 */

class AccountModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
        // LoginController User
    public function login($email, $password)
    {
        $this->db->query('SELECT * FROM users WHERE user_email=:user_email LIMIT 1');
        $this->db->bind(':user_email', $email);
    
        $row = $this->db->single();
    
        $hashed_password = $row->user_pass;
        if(password_verify($password, $hashed_password)){
            return $row;
        } else {
            return false;
        }
    }
    
        // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        // Bind value
        $this->db->bind(':email', $email);
    
        $row = $this->db->single();
    
        // Check row
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

/*    public function register($data){
        $this->db->query('INSERT INTO users (user_email, user_pass, user_registered, user_name, user_surname) 
                            VALUES (:user_email, :user_password, :user_registered, :user_name, :user_surname)');
        // Bind values
        $this->db->bind(':user_email', $data['user_email']);
        $this->db->bind(':user_password', $data['user_password']);
        $this->db->bind(':user_registered', $data['user_registered']);
        $this->db->bind(':user_name', $data['user_name']);
        $this->db->bind(':user_surname', $data['user_surname']);

        // Execute
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
*/
/*
    public function register($user_email, $user_password, $user_name, $user_surname){
        try{
            $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users(user_email, user_pass, user_registered, user_name, user_surname) VALUES(:user_email, :user_password, :user_registered, :user_name, :user_surname)";

            $user_registered = date("Y-m-d H:i:s");

            $query = $this->db->prepare($sql);

            $query->bindParam(":user_email", $user_email);
            $query->bindParam(":user_password", $user_hashed_password);
            $query->bindParam(":user_registered", $user_registered);
            $query->bindParam(":user_name", $user_name);
            $query->bindParam(":user_surname", $user_surname);

            $query->execute();
            $this->redirect("login.php?registered");
        } catch (PDOException $e) {
            array_push($errors, $e->getMessage());
        }
    }
*/


/*
    // Log in registered users with either their username or email and their password
    public function login($user_email, $user_password)
    {
        try {
            // Define query to insert values into the users table
            $sql = "SELECT * FROM users WHERE user_email=:user_email LIMIT 1";

            // Prepare the statement
            $query = $this->db->prepare($sql);

            // Bind parameters
            $query->bindParam(":user_email", $user_email);

            // Execute the query
            $query->execute();

            // Return row as an array indexed by both column name
            $returned_row = $query->fetch(PDO::FETCH_ASSOC);
            // Check if row is actually returned
            if ($query->rowCount() > 0) {
                // Verify hashed password against entered password
                if (password_verify($user_password, $returned_row['user_pass'])) {
                    // Define session on successful login
                    $_SESSION['user_session'] = true;
                    $_SESSION['user_id'] = $returned_row['user_id'];
                    $_SESSION['user_email'] = $returned_row['user_email'];
                    $_SESSION['user_name'] = $returned_row['user_name'];
                    $_SESSION['user_surname'] = $returned_row['user_surname'];
                    $_SESSION['user_level'] = $returned_row['user_level'];
                    return true;
                } else {
                    // Define failure
                    return false;
                }
            }
        } catch (PDOException $e) {
            array_push($errors, $e->getMessage());
        }
    }

    // Check if the user is already logged in
    public function is_logged_in() {
        // Check if user session has been set
        if (isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function get_user_level(){
        if (isset($_SESSION['user_session'])) {
            return $_SESSION['user_level'];
        }
    }

    // Redirect user
    public function redirect($url) {
        header("Location: $url");
    }

    // Log out user
    public function log_out() {
        // Destroy and unset active session
        session_destroy();
        unset($_SESSION['user_session']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_surname']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_level']);
        return true;
    }
*/
}