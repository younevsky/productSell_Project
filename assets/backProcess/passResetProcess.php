<?php
    require '../../vendor/autoload.php';

    session_start();


    $response = array('status' => 'success');
    $dbname = 'stage';
    $host = '<contact me for this value>';
    $user = '<contact me for this value>';
    $password = '<contact me for this value>';
    $charset = 'utf8mb4';

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::MYSQL_ATTR_SSL_CA    => 'SSL_cert.pem',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dbh = new PDO($dsn, $user, $password, $options);

        $email = $dbh->quote($_POST['email']);

        $sql = "SELECT * FROM client WHERE email={$email}";
        $result = $dbh->query($sql);
        if ($result->rowCount() === 1) {
            if (isset($_POST['otp'], $_POST['newPassword'])) {
                $providedOtp = intval($_POST['otp']);
                $newPassword = password_hash($_POST['newPassword'], PASSWORD_BCRYPT); 
                $sql = "SELECT otp FROM otp_table WHERE email={$email}"; 
                $result = $dbh->query($sql);

                if ($result->rowCount() === 1) {
                    $row = $result->fetch();
                    $actualOtp = $row['otp'];

                    if ($providedOtp === $actualOtp) {

                        $updatePassword = $dbh->prepare("UPDATE client SET password = :newPassword WHERE email = :email");
                        $updatePassword->execute([
                            'newPassword' => $newPassword,
                            'email' => $_POST['email']
                        ]);


                        $clearOtp = $dbh->prepare("DELETE FROM otp_table WHERE email = :email");
                        $clearOtp->execute(['email' => $_POST['email']]);

                        $response = array('status' => 'success', 'message' => 'Password has been reset successfully');
                    } else {

                        $response = array('status' => 'error', 'message' => 'The OTP you provided does not match our records');
                    }
                } else {

                    $response = array('status' => 'error', 'message' => 'An error occurred');
                }
            } else {

                $otp = rand(100000, 999999);


                $clearOtp = $dbh->prepare("DELETE FROM otp_table WHERE email = :email");
                $clearOtp->execute(['email' => $_POST['email']]);
                $insertOtp = $dbh->prepare("INSERT INTO otp_table (email, otp) VALUES (:email, :otp)");
                $insertOtp->execute(['email' => $_POST['email'], 'otp' => $otp ]);

                $mail = new PHPMailer\PHPMailer\PHPMailer();


                $mail->isSMTP();
                $mail->Host = '<contact me for this value>';
                $mail->SMTPAuth = true;
                $mail->Username = 'otp@younevsky.com';
                $mail->Password = '<contact me for this value>';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
    

                $mail->setFrom('otp@younevsky.com', 'OTP CODE');
                $mail->addAddress(trim($_POST['email']), '');
    

                $mail->Subject = 'otp@younevsky.com';
                $mail->Body = 'Your OTP is ' . $otp;
    

                if (!$mail->send()) {
                    $response = array('status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
                } else {
                    $_SESSION['otp'] = $otp;
                    $response = array('status' => 'success', 'message' => 'OTP has been sent!');
                }
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Email is not registered');
        }
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

    echo json_encode($response);
?>
