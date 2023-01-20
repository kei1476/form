<?php

$token = null;
$clean = null;
$error_message = array();

session_start();

$_SESSION['form_content'] = [
    'name' => $_POST['name'],
    'email' => $_POST['email'],
    'genre' => $_POST['genre'],
    'message' => $_POST['message']
];

// 二重送信防止用トークンの発行
$token = uniqid('', true);

//トークンをセッション変数にセット
$_SESSION['token'] = $token;

    if(empty($_POST['name'])) {
        $error_message[] = '名前を入力してください。'; 
    }elseif(20 < mb_strlen($_POST['name'])){
        $error_message[] = '名前は20文字以内で入力してください。';
    }else {
        $clean['name'] = htmlspecialchars($_POST['name'],ENT_QUOTES,'UTF-8');
        $clean['name'] = preg_replace('/\\r\\n|\\n|\\r/','',$clean['name']);
    }

    if(empty($_POST['email'])) {
        $error_message[] = 'メールアドレスを入力してください';
    }else {
        $clean['email'] = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');

        $clean['email'] = preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $clean['email']);

    }

    if(empty($_POST['genre'])) {
        $error_message[] = 'お問い合わせ種別を選択してください';
    }


    if( empty($_POST['message']) ) {
		$error_message[] = 'お問い合わせ内容を入力してください。';
	} else {
		$clean['message'] = htmlspecialchars( $_POST['message'], ENT_QUOTES, 'UTF-8');
		$clean['message'] = preg_replace( '/\\r\\n|\\n|\\r/', '<br>', $clean['message']);
	}


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php if(!empty($error_message)):?>
        <ul>
            <?php foreach($error_message as $value):?>
                <li class="error-message"><?php echo $value;?></li>
            <?php endforeach;?>
        </ul>
        <a href="index.php" class="back">戻る</a>
        <?php else:?>
            <h1 class="confirm-title">確認画面</h1>
        <form action="submit.php" method="post">
            <dl class="form_area">
                <dt><span class="required">お名前</span></dt>
                <dd><p><?php echo $clean['name'];?></p></dd>
                
                <dt><span class="required">メールアドレス</span></dt>
                <dd><p><?php echo $clean['email'];?></p></dd>

                <dt>お問い合わせ種別</dt>
                <dd><p><?php if($_POST['genre'] === '1'){echo 'ご予約について';}elseif($_POST['genre'] === '2'){echo 'メニューについて';}elseif($_POST['genre'] === '3'){echo '営業時間について';}?></p></dd>

                <dt><span class="required">お問い合わせ内容</span></dt>
                <dd><p><?php echo $clean['message'];?></p></textarea></dd>
            </dl>
            <div class="btn-area">
                <input type="submit" value="送信" class="submit-btn" name="btn_submit">
            </div>
            <input type="hidden" name="name" value="<?php echo $clean['name']; ?>">
	        <input type="hidden" name="email" value="<?php echo $clean['email']; ?>">
	        <input type="hidden" name="genre" value="<?php echo $_POST['genre']; ?>">
	        <input type="hidden" name="message" value="<?php echo $_POST['message']; ?>">
            <input type="hidden" name="token" value="<?php echo $token;?>">
        </form> 
    <?php endif;?>
</body>
</html>