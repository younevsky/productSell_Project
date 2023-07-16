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

        $email = $dbh->quote($_POST['email']);
        $password = $dbh->quote($_POST['password']);

        $sql = "SELECT * FROM client WHERE email={$email} AND password={$password}";
        $result = $dbh->query($sql);

        if ($result->rowCount() === 1) {
            $user = $result->fetch(PDO::FETCH_ASSOC);
            $_SESSION['SESSION_EMAIL'] = $user['email'];
            $_SESSION['SESSION_NAME'] = $user['name'];
            $_SESSION['SESSION_CITY'] = $user['city'];
            $_SESSION['SESSION_ADDRESS'] = $user['address'];
            $_SESSION['SESSION_VERIFY'] = $user['isVerified'];

        } else {
            $response = array('status' => 'error', 'message' => 'Email or password is incorrect');
        }
    } catch (PDOException $e) {
        $response = array('status' => 'error', 'message' => $e->getMessage());
    }

    echo json_encode($response);
?>


