<?php
    require '../../vendor/autoload.php';

    session_start();
    $dbname = 'stage';
    $host = 'aws.connect.psdb.cloud';
    $user = '<contact me for this value>';
    $password = '<contact me for this value>';
    $charset = 'utf8mb4';

    $response = array('status' => 'success');

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
            // Now check if we are verifying OTP and changing password
            if (isset($_POST['otp'], $_POST['newPassword'])) {
                $providedOtp = intval($_POST['otp']);
                $newPassword = $_POST['newPassword']; // remember to hash this before storing

                // Assuming that you have a table or a column for storing OTPs
                // And assuming you have stored the OTP against the user's email or id
                // Fetch the actual OTP for the user
                $sql = "SELECT otp FROM otp_table WHERE email={$email}"; // Update this based on your table structure
                $result = $dbh->query($sql);

                if ($result->rowCount() === 1) {
                    $row = $result->fetch();
                    $actualOtp = $row['otp'];

                    if ($providedOtp === $actualOtp) {
                        // OTPs match
                        // Reset the password and send success response
                        // Don't forget to clear the OTP from your OTP table/column


                        // Update the user's password
                        $updatePassword = $dbh->prepare("UPDATE client SET password = :newPassword WHERE email = :email");
                        $updatePassword->execute([
                            'newPassword' => $newPassword,
                            'email' => $_POST['email']
                        ]);

                        // Clear the OTP from the otp_table
                        $clearOtp = $dbh->prepare("DELETE FROM otp_table WHERE email = :email");
                        $clearOtp->execute(['email' => $_POST['email']]);

                        $response = array('status' => 'success', 'message' => 'Password has been reset successfully');
                    } else {
                        // OTPs do not match
                        // Send error response
                        $response = array('status' => 'error', 'message' => 'The OTP you provided does not match our records');
                    }
                } else {
                    // Email doesn't have a corresponding OTP
                    // This should ideally never happen if your previous steps work correctly
                    $response = array('status' => 'error', 'message' => 'An error occurred');
                }
            } else {
                // No OTP provided, generate OTP and send to the user
                $otp = rand(100000, 999999);

                // Insert the OTP into your otp_table
                $clearOtp = $dbh->prepare("DELETE FROM otp_table WHERE email = :email");
                $clearOtp->execute(['email' => $_POST['email']]);
                $insertOtp = $dbh->prepare("INSERT INTO otp_table (email, otp) VALUES (:email, :otp)");
                $insertOtp->execute(['email' => $_POST['email'], 'otp' => $otp ]);

                // Send the OTP to the user's email

                // ...
                $mail = new PHPMailer\PHPMailer\PHPMailer();

                // Set up SMTP settings
                $mail->isSMTP();
                $mail->Host = '<contact me for this value>';
                $mail->SMTPAuth = true;
                $mail->Username = 'otp@younevsky.com';
                $mail->Password = '<contact me for this value>';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
    
                // Set the recipient and sender
                $mail->setFrom('otp@younevsky.com', 'OTP CODE');
                $mail->addAddress(trim($_POST['email']), '');
    
                // Set the email subject and body
                $mail->Subject = 'otp@younevsky.com';
                $mail->Body = 'Your OTP is ' . $otp;
    
                // Send the email
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
