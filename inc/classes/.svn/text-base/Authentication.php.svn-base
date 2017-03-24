<?php

class Authentication {
    const LOGOUT_URL = "/logout.php";
    static function sec_session_start() {
        $session_name = 'TPA_Session'; // Set a custom session name
        $secure = false; // Set to true if using https.
        $httponly = true; // This stops javascript being able to access the session id. 
 
        ini_set('session.use_only_cookies', 1); // Forces sessions to only use cookies. 
        $cookieParams = session_get_cookie_params(); // Gets current cookies params.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
        session_name($session_name); // Sets the session name to the one set above.
        session_start(); // Start the php session
        session_regenerate_id(); // regenerated the session, delete the old one.  
    }
    
    static function login($email, $password, $DBH) {
        // Using prepared Statements means that SQL injection is not possible. 
        if ($STH = $DBH -> prepare("CALL authentication_select_email(:email)")) { 
            $STH -> bindParam(':email', strtolower($email)); // Bind "$email" to parameter.
            $STH -> execute(); // Execute the prepared query.
            
            if($result = $STH -> fetch(PDO::FETCH_ASSOC)) { // If the user exists
                $password = hash('sha512', $password); // hash the password with the unique salt.
                
                if($result['password'] == $password) { // Check if the password in the database matches the password the user submitted. 
                // Password is correct!
                   
                  // $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                   $user_id = $result['user_id'];
                   $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                   $_SESSION['user_id'] = $user_id; 
                   $_SESSION['email'] = $email;
                   $_SESSION['login_string'] = hash('sha512', $password);
                   // Login successful.
                   
                   return true;
             } 
          } else {
             // No user exists. 
             return false;
          }
       } 
       return false;
    }
    
    static function login_check($DBH) {
        // Check if all session variables are set
        if(isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['email'];

            if($STH = $DBH -> prepare("CALL authentication_select_password(:userID)")) { 
                $STH -> bindParam(":userID", $user_id); // Bind "$user_id" to parameter.
                $STH -> execute(); // Execute the prepared query.
                
                if($result = $STH -> fetch(PDO::FETCH_ASSOC)) { // If the user exists                   
                    $login_check = hash('sha512', $result['password']);
            
                    if($login_check == $login_string) {
                        // Logged In!!!!
                        return true;
                    } else {
                        // Not logged in
                        return false;
                    }
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }

    static function getUserID() {
        return $_SESSION['user_id'];
    }
}

?>
