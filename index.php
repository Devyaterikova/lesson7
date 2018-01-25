<?php
$name= "Лена";
$age = 33;
$email = 'A1978D@yandex.ru';
$address = 'Североморск';
$about = 'Инженер';
?>
<html>
<head>
    <title>Страница пользователя</title>
</head>
<body>
  <div>
    <h2> Страница пользователя Лена </h2>
    <p> Имя <strong><?= $name ?> </p>
    <p> Возраст <strong><?= $age ?> </p>
    <p> Адрес электронной почты <strong><?= $email ?> </p>
    <p> Город <strong><?= $address ?> </p>
    <p> О себе <strong><?= $about ?> </p>
  </div>
</body>
</html>
