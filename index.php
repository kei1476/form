<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="confirm.php" method="post">
        <dl class="form_area">

            <dt><span class="required">お名前</span></dt>
            <dd><input type="text" class="input-text" name="name"></dd>

            <dt><span class="required">メールアドレス</span></dt>
            <dd><input type="email" class="input-text" name="email"></dd>

            <dt>お問い合わせ種別</dt>
            <dd>
                <select name="genre" class="select-box" >
                    <option value="1">ご予約について</option>
                    <option value="2">メニューについて</option>
                    <option value="3">営業時間について</option>
                </select>
            </dd>
            
            <dt><span class="required">お問い合わせ内容</span></dt>
            <dd><textarea name="message" class="message"></textarea></dd>
        </dl>
        <div class="btn-area">
            <input type="submit" value="確認ページへ" name="btn_confirm" class="submit-btn">
        </div>
    </form>   
</body>
</html>