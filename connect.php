
<?php

function dbConnect() {
  $dbname = 'stage';
  $host = 'aws.connect.psdb.cloud';
  $user = '<contact me for this value>';
  $password = '<contact me for this value>';
  $charset = 'utf8mb4';

  $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
  $options = [
      PDO::MYSQL_ATTR_SSL_CA    => 'assets/backProcess/SSL_cert.pem',
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
  ];


  try {
      $dbh = new PDO($dsn, $user, $password, $options);
        return $dbh;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        die();
    }
}

?>
