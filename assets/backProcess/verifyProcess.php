<?php
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

        $email = $_POST['email'];
        $code = intval($_POST['code']);
        
        $sql = "SELECT * FROM client WHERE email=:email AND otp=:code";
        $stmt = $dbh->prepare($sql);
        $stmt->execute(['email' => $email, 'code' => $code]);
        
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['SESSION_EMAIL'] = $user['email'];
            $_SESSION['SESSION_NAME'] = $user['name'];
            $_SESSION['SESSION_CITY'] = $user['city'];
            $_SESSION['SESSION_ADDRESS'] = $user['address'];
            $response = array('status' => 'success', 'message' => 'Your account is verified');
        
            $sql = "UPDATE client SET isVerified=1 WHERE email=:email";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(['email' => $email]);
        
        } else {
            $response = array('status' => 'error', 'message' => 'Email or verification code is incorrect');
        }
        
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

    echo json_encode($response);
?>
