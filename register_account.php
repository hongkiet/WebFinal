<?php
        session_start();
        if (isset($_SESSION['user'])) {
            exit();
        }
    
        require_once('database_account.php');
    
        
        $error = '';
        $name = '';
        $email = '';
        $user = '';
        $pass = '';
        $pass_confirm = '';
    
        if (isset($_POST['name']) && isset($_POST['email'])
        && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['pass-confirm']))
        {
            $name = $_POST['name'];

            $email = $_POST['email'];
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $pass_confirm = $_POST['pass-confirm'];
    
            if (empty($name)) {
                $error = 'Please enter your  name';
            }
            else if (empty($email)) {
                $error = 'Please enter your email';
            }
            else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                $error = 'This is not a valid email address';
            }
            else if (empty($user)) {
                $error = 'Please enter your username';
            }
            else if (empty($pass)) {
                $error = 'Please enter your password';
            }
            else if (strlen($pass) < 6) {
                $error = 'Password must have at least 6 characters';
            }
            else if ($pass != $pass_confirm) {
                $error = 'Password does not match';
            }
            else {
                // register a new account
                $rs = register($user,$pass,$name,$email);
                if ($rs['code'] == 0){
                    showSuccessMessage();
                }
                else if ($rs['code'] == 1){
                    $error = 'This email is already exists!';
                } else{
                    $error = 'An error occured. Please try again later!';
                }
            }
        }

        
        
?>
