<?php
    require '../../vendor/autoload.php';
    session_start();

    $dbname = 'stage';
    $host = '<contact me for this value>';
    $user = '<contact me for this value>';
    $password = '<contact me for this value>';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $options = [
        PDO::MYSQL_ATTR_SSL_CA    => 'SSL_cert.pem',
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $response = array('status' => 'success');

    try {
        $dbh = new PDO($dsn, $user, $password, $options);
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $name = $_POST['name'];
        $address = $_POST['address'];
        $country = $_POST['country'];
        $city = $_POST['city'];

        $sql = "SELECT * FROM client WHERE email=:email";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() === 1) {
            $response = array('status' => 'error', 'message' => 'Email is Taken');
        } else {
            $otp = rand(100000, 999999);

            $sql = "INSERT INTO client (name, password, email, address, country, city, otp, isVerified) VALUES (:name, :password, :email, :address, :country, :city, :otp, 0)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute([':name' => $name, ':password' => $password, ':email' => $email, ':address' => $address, ':country' => $country, ':city' => $city, ':otp' => $otp]);
            $_SESSION['SESSION_EMAIL'] = $email;
            $_SESSION['SESSION_NAME'] = $name;
            $_SESSION['SESSION_CITY'] = $city;
            $_SESSION['SESSION_ADDRESS'] = $address;
            $_SESSION['SESSION_COUNTRY'] = $country;
            $mail = new PHPMailer\PHPMailer\PHPMailer();

                $mail->isSMTP();
                $mail->Host = '<contact me for this value>';
                $mail->SMTPAuth = true;
                $mail->Username = 'otp@younevsky.com';
                $mail->Password = '<contact me for this value>';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
    
                $mail->setFrom('otp@younevsky.com', 'Verification Code');
                $mail->addAddress(trim($email), '');
    
                $mail->Subject = 'otp@younevsky.com';
                $mail->Body = 'Your Verification code is ' . $otp;
                if (!$mail->send()) {
                    $response = array('status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
                } else {
                    $response = array('status' => 'success', 'message' => 'Verification code sent to your E-mail' );
                }
        }
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

    echo json_encode($response);
?>
