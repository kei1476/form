<?php
$token = null;
$session_token = null;
$error_massage = array();
$option = null;
$pdo = null;
$auto_reply_subject = null;
$auto_reply_text = null;
date_default_timezone_set('Asia/Tokyo');

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

            $header = "MIME-Version: 1.0\n";
	        $header = "From: Kei1476 <kei1476to@outlook.jp>\n";
	        $header = "Reply-To: Kei1476 <kei1476to@outlook.jp>\n";

            $auto_reply_subject = 'お問い合わせありがとうございます。';

            $auto_reply_text = "この度は、お問い合わせ頂き誠にありがとうございます。下記の内容でお問い合わせを受け付けました。\n\n";
            $auto_reply_text = "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
	        $auto_reply_text = "氏名：" . $_POST['name'] . "\n";
	        $auto_reply_text = "メールアドレス：" . $_POST['email'] . "\n\n";

            mb_send_mail($_POST['email'],$auto_reply_subject,$auto_reply_text,$header);

            $admin_reply_subject = "お問い合わせを受け付けました";
	

            $admin_reply_text = "下記の内容でお問い合わせがありました。\n\n";
            $admin_reply_text = "お問い合わせ日時：" . date("Y-m-d H:i") . "\n";
            $admin_reply_text = "氏名：" . $_POST['name'] . "\n";
            $admin_reply_text = "メールアドレス：" . $_POST['email'] . "\n\n";

            mb_send_mail( 'kei1476to@outlook.jp', $admin_reply_subject, $admin_reply_text, $header);

            unset($_SESSION['form_content']);
            
        
        } catch(PDOExeption $e) {
            $pdo->rollBack();
        }
    }

    $pdo = null;
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