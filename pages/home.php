<?php
// $connection = [
//     'host' => 'MySQL-8.2',
//     'username' => 'root',
//     'pass' => '',
//     'charset' => 'utf8',
//     'dbname' => 'PV315',
//     'options' => [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
// ];

// try {
//     $dsn = "mysql:host={$connection['host']};dbname={$connection['dbname']};charset={$connection['charset']}";
//     $conn = new PDO($dsn, $connection['username'], $connection['pass'], $connection['options']);
//     // echo "Connected successfuly";

//     $sql = "SELECT * FROM `users`";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute();
//     $result = $stmt->fetchAll();
//     $table = "<table class='table table-bordered'>";
//     foreach ($result as $user) {
//         $table .= "<tr>";
//         $table .= "<td>{$user['users_id']}</td>";
//         $table .= "<td><a href='index.php?user={$user['users_id']}'>{$user['name']}</a></td>";
//         $table .= "<td>{$user['password']}</td>";
//         $table .= "<td>{$user['email']}</td>";
//         $table .= "</tr>";
//     }
//     $table .= "</table>";
//     echo $table;

// $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (:name,:email,:password)";
// $stmt = $conn->prepare($sql);
// $stmt->bindValue(":name", "user6");
// $stmt->bindValue(":email", "user6@email.com");
// $stmt->bindValue(":password", "12349");
// $stmt->execute();
// echo "Изменено строк: " . $stmt->rowCount();

// $stmt = $conn->prepare($sql);
// $stmt->execute([':name' => 'user10', ':email' => 'user10@email.com', ':password' => '1234500']);
// echo "Изменено строк: " . $stmt->rowCount();

// $sql = "INSERT INTO `users`(`name`, `email`, `password`) VALUES (?,?,?)";
// $stmt = $conn->prepare($sql);
// $stmt->execute(['user11', 'user11@email.com', '1234599']);
// echo "Изменено строк: " . $stmt->rowCount();
// } catch (PDOException $e) {
//     echo "DB ERROR: {$e->getMessage()}";
// }

?>

<h1 style="text-align:center">Добро пожаловать!</h1>