<?php
$token = null;
$session_token = null;
$error_massage = array();
$option = null;

session_start();

if(isset($_POST["token"])) {
    $token = $_POST["token"];
}

if(isset($_SESSION['token'])) {
    $session_token = $_SESSION["token"];
}

unset($_SESSION["token"]);


if( !empty($token) && $token == $session_token) {
    if(!empty($_POST['btn_submit'])) {
        try {
            $option = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
            );
            $pdo = new PDO('mysql:host=localhost;dbname=form;charaset=UTF8','root','',$option);
        } catch(PDOExeption $e) {
            $error_massage[] = $e->getMessage();
        }
        
        $pdo->beginTransaction();
        
        try {
            $stmt = $pdo->prepare("INSERT INTO form (your_name,genre,message,email)
            VALUES(:your_name,:genre,:message,:email)");
        
            $stmt->bindParam(':your_name',$_POST['name']);
            $stmt->bindParam(':genre',$_POST['genre']);
            $stmt->bindParam(':message',$_POST['message']);
            $stmt->bindParam(':email',$_POST['email']);
        
            $stmt->execute();
        
            $pdo->commit();
        
        } catch(PDOExeption $e) {
            $pdo->rollBack();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        <p>送信しました</p>
</body>
</html>