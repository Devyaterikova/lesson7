<?php
$file_list = glob('uploads/*.json');
$num = $_GET['test'];
$num = (int)$num;
$num++;
foreach ($file_list as $key => $file)
{
    if ($key == $_GET['test'])
    {
        $file_test = file_get_contents($file_list[$key]);
        $decode_file = json_decode($file_test, true);
    }
}
if (empty($decode_file))
{
    http_response_code(404);
    exit;
}
$count_answer = 0;
$count_questions = 0;
if(!empty($_POST['name_user']))
{
    $name = $_POST['name_user'];
    $image = imagecreatetruecolor(866, 618);
    $colorBack = imagecolorallocate($image, 0,0,0);
    $textColor = imagecolorallocate($image, 0,0,0);
    $fontFile = __DIR__ . '/font.ttf';
    $image_res = imagecreatefrompng( 'image.png');
    imagefill($image, 0, 0, $colorBack);
    imagecopy($image, $image_res, 0, 0, 0, 0, 866, 618);
    if(!file_exists($fontFile))
    {
        echo "Файл со шрифтом отсутствует.";
        exit;
    }
    imagettftext($image, 40, 0, 370, 300, $textColor, $fontFile, $name);
    imagettftext($image, 20, 0, 280, 340, $textColor, $fontFile, "Успешно прошел тестирование");
    imagettftext($image, 16, 0, 370, 380, $textColor, $fontFile, date("d.m.y"));
    header('Content-Type: image/png');
    imagepng($image);
    imagedestroy($image);
}
?>

<html>
<head>
   <title>Тест <?=$num?></title>
</head>
<body>
    <form method="post" style="margin-top: 20px">
        <?php
        for($i=0; $i<count($decode_file); $i++) {
            $question = $decode_file[$i]['question'];
            $answers = $decode_file[$i]['answers'];
        ?>
            <fieldset style="margin: 20px 0">
                <legend><?=$question?></legend>
                <?php foreach ($answers as $key => $val) : ?>
                    <label><input type="checkbox" name="<?=$question . "/" . $val['answer'];?>" value="<?=$val['result'];?>"> <?=$val['answer'];?></label><br>
                <?php endforeach; ?>
            </fieldset>
        <?php } ?>
        <input type="submit" value="Отправить">
    </form>
    <?php if (!empty($_POST)) {
            foreach ($_POST as $key => $val)
            {
                if ($val == true)
                {
                    $count_answer++;
                    $count_questions++;
                }
                else
                {
                    $count_questions++;
                }
            }

            if((($count_answer / $count_questions) * 100) >= 65)
            {
                echo "<p>Отлично</p>";
            }
            else
            {
                echo "<p>Хорошо</p>";
            } ?>
        <form action="" method="post">
            <input type="text" name="name_user" placeholder="Введите имя">
            <input type="submit" value="Отправить">
        </form>
    <?php }?>
    <br><br>
    <p><a href="list.php">Выбор теста</a></p>
    <p><a href="admin.php">Загрузка теста</a></p>
</body>
</html>