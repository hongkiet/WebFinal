<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    require_once('connection.php');


    function is_email_exists($email){
        $sql = 'select username from account where email = ?';
        $conn = connect_to_db();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            die('Query error: '.$stm->error);
        }

        $result = $stm->get_result();
        if ($result->num_rows > 0){
            return true;
        } else{
            return false;
        }
    }

    function createToken($email){
        $token = md5(time().$email.rand(0,999));
        $_SESSION['activation_email'] = $email;
        $_SESSION['activation_token'] = $token;
        return $token;
    }
    
    function register($user, $pass, $name, $email){
        if (is_email_exists($email)){
            return array('code'=>1,'error'=> 'Email exists');
        }
        if ($name == null){
            $name = 'unknown';
        }
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        // $rand = random_int(1000, 2000);
        // $token = md5($email .'+'.$rand);
        $token = createToken($email);
        $sql = 'insert into account(username, name, email, password, activate_token) values (?,?,?,?,?)';

        $conn = connect_to_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssss',$user, $name, $email, $hash, $token);

        if (!$stm->execute()){
            return array('code'=>2,'error'=> 'Cannot execute command!');
        }

        sendActivationEmail($email,$token);

        return array('code'=>0,'error'=> 'Create account successful');
    }

    function sendActivationEmail($email,$token){

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'akkmusic23@gmail.com';                     //SMTP username
            $mail->Password   = 'viyksfznxoewlvze';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('akkmusic23@gmail.com', 'AKK MUSIC');
            $mail->addAddress($email, 'Người nhận');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Activate your account in AKK Music!';
            $mail->Body    = "Click <a href='http://localhost/activate.php?=email=$email&token=$token'>vào đây</a> để xác minh tài khoản của bạn";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function sendResetEmail($email,$token){
        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function

        //print hhello world in php
        //Load Composer's autoloader


        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();    
            $mail->CharSet = 'UTF-8';                                        //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'akkmusic23@gmail.com';                     //SMTP username
            $mail->Password   = 'viyksfznxoewlvze';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('akkmusic23@gmail.com', 'AKK Music');
            $mail->addAddress($email, 'Người nhận');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset your password!';
            $mail->Body    = "Click <a href='http://localhost/reset_password.php?=email=$email&token=$token'>vào đây</a> để khôi phục tài khoản của bạn";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    function activeAccount($email,$token){
        $sql = 'select username from account where email = ? 
        and activate_token = ? and activated = 0';
        $conn = connect_to_db();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$email,$token);

        if (!$stm->execute()){
            return array('code'=>1,'error'=>'Cannot excute command!');
        }
        $rs = $stm->get_result();

        if ($rs->num_rows == 0){
            return array('code'=>2,'error'=>'Email address or token can not found!');
        }

        $sql = "update account set activated = 1, activate_token = ' ' where email = ?";
        $stm = $conn -> prepare($sql);
        $stm->bind_param('s',$email);

        if (!$stm->execute()){
            return array('code'=>1,'error'=>'Cannot excute command!');
        }
        return array('code'=>0,'message'=>'Account activated!');
    }

    // function resetPassword($email){

    //     if (!is_email_exists($email)){
    //         return array('code'=>1,'error'=>'Email does not exist!');
    //     }
    //     $rand_int = random_int(1000,2000);
    //     $token = md5($email.'+'.$rand_int);
    //     $sql = "update reset_token set token = ? where email = ?";

    //     $conn = connect_to_db();
    //     $stm = $conn->prepare($sql);
    //     $stm->bind_param('ss',$token,$email);

    //     if ($stm->execute()){
    //         return array('code'=>2,'error'=>'Can not execute command!');
    //     }
    //     if ($stm->affected_rows == 0){
    //         $exp = time() + 3600 * 24;
    //         $sql = 'insert into reset_token values (?,?,?)';
    //         $stm = $conn->prepare($sql);
    //         $stm->bind_param('ssi',$email,$token,$exp);

    //         if ($stm->execute()){
    //             return array('code'=>2,'error'=>'Can not execute command!');
    //         }
    //     }
    //     $success = sendResetEmail($email, $token);
    //     return array('code'=>0,'success'=>$success);
    // }
    
    function showSuccessMessage() {
        echo "<script>alert('Register successfully! Email for activatation will be send!')</script>";
        header("Location: main.php");
        exit;
    }

    function showSuccessMessageRSPW() {
        echo "<script>alert('Reset password success!')</script>";
        header("Location: main.php");
        exit;
    }
    
      function ForgotPassword($email) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION['email'])) {
            $_SESSION['email'] = $email;
        }
        if(is_email_exists($email)) {  
            $conn = connect_to_db();
            $sql = "Select * from reset_token where email = ?";
            
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $email);

            

            if(!$stm->execute()) {
                die('Query error: ' . $stm->error);
            }

            $result = $stm->get_result();
            
            $rand = random_int(1000, 2000);
            $token = md5($email .'+'.$rand);

            $expire = time() + 3600 * 24;
            if($result->num_rows > 0) {
                $update = "UPDATE reset_token SET token = ? WHERE email = ?";
                $stm = $conn->prepare($update);
                $stm->bind_param('ss', $token, $email);

                if(!$stm->execute()) {
                    return array('code' => 1, 'error' => 'Cannot execute Command');
                }
                sendRecoveryEmail($email, $token);
                return array('code' => 0, 'error' => 'Your requirement is accepted!.');
            } else {
                $sql = "INSERT INTO reset_token (email, token, expire_on) VALUES (?, ?, ?)";
                $stm = $conn->prepare($sql);
                $stm->bind_param('sss', $email, $token, $expire);

                if(!$stm->execute()) {
                    return array('code' => 1, 'error' => 'Cannot execute Command');
                }
                sendRecoveryEmail($email, $token);
                return array('code' => 0, 'error' => 'Your requirement is accepted!.');
            }
            
        } else {
            return array('code' => 1, 'error' => 'An error Occured');
        }
    }

    function sendRecoveryEmail($email, $token) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'akkmusic23@gmail.com';                     //SMTP username
            $mail->Password   = 'viyksfznxoewlvze';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('akkmusic23@gmail.com', 'AKK Music');
            $mail->addAddress($email, 'Reciever');     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recover Account';
            $mail->Body    = "Click <a href='http://localhost/reset_password.php?email=$email&token=$token'> here </a> to change your password.";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function RecoverPassword($email, $pass, $comfirm_pass) {
        if(is_email_exists($email)) {
            $conn = connect_to_db();
            
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $rand = random_int(1000, 2000);
                $token = md5($email .'+'.$rand);
                $sql = "UPDATE account set password = ?, activate_token = ? WHERE email = ?";
                $stm = $conn->prepare($sql);
                $stm->bind_param('sss', $hash, $token, $email);

                if(!$stm->execute()) {
                    return array('code' => 1, 'error' => 'Cannot execute Command');
                }
            if(strlen($pass) < 6) {
                return array('code' => 4, 'error' => 'Password must be at least 6 characters!.');
            }
            if($pass != $comfirm_pass) {
                return array('code' => 3, 'error' => 'Password does not match!.');
            }
            return array('code' => 0, 'error' => 'Your requirement is accepted!.');
        } else {
            return array('code' => 2, 'error' => 'Invalid Email!.');
        }
    }

?>