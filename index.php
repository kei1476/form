<?php
session_start();


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
    <?php if(!empty($_SESSION['error'])):?>
    <ul>
        <?php foreach($_SESSION['error'] as $value):?>
            <li class="error-message"><?php echo $value;?></li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>
    <form action="confirm.php" method="post">
        <dl class="form_area">

            <dt><span class="required">お名前</span></dt>
            <dd><input type="text" class="input-text" name="name" value="<?php echo $_SESSION['form_content']['name'];?>"></dd>

            <dt><span class="required">メールアドレス</span></dt>
            <dd><input type="email" class="input-text" name="email" value="<?php echo $_SESSION['form_content']['email'];?>"></dd>

            <dt>お問い合わせ種別</dt>
            <dd>
                <select name="genre" class="select-box" >
                    <option value="1"<?php if($_SESSION['form_content']['genre'] === 1){echo 'selected';}?>>ご予約について</option>
                    <option value="2" <?php if($_SESSION['form_content']['genre'] === 2){echo 'selected';}?>>メニューについて</option>
                    <option value="3" <?php if($_SESSION['form_content']['genre'] === 3){echo 'selected';}?>>営業時間について</option>
                </select>
            </dd>
            
            <dt><span class="required">お問い合わせ内容</span></dt>
            <dd><textarea name="message" class="message" ><?php echo $_SESSION['form_content']['message'];?></textarea></dd>
        </dl>
        <div class="btn-area">
            <input type="submit" value="確認ページへ" name="btn_confirm" class="submit-btn">
        </div>
    </form>   
</body>
</html>