<?php
require_once ("connection.php");
/**
 * @var string $db_hostname
 * @var string $db_name
 * @var string $db_username
 * @var string $db_password
 */
$dsn = "mysql:host=$db_hostname;dbname=$db_name";
$dbh = new PDO($dsn, "$db_username", "$db_password");
$stmt = $dbh->prepare("SELECT * FROM user");
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP PDO+MySQL with connection file()</title>
  <style>
    table, td {
      border: black 1px solid;
    }
  </style>
</head>
<body>
<table>
  <tr>
    <td><?= "Id"; ?></td>
    <td><?= "Username"; ?></td>
    <td><?= "Password"; ?></td>
  </tr>
  <?php while ($row = $stmt->fetchObject()): ?>
    <tr>
      <td><?= $row->user_id; ?></td>
      <td><?= $row->username; ?></td>
      <td><?= $row->password; ?></td>
      <?php $raw = $row; ?>
    </tr>
  <?php
  endwhile;
  $stmt->closeCursor();
  ?>
</table>

<pre><?php var_dump($raw) ?></pre>
</body>
</html>
