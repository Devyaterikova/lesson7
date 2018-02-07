<?php
$file_list = glob('uploads/*.json');
$file_send = false;
// Проверяем
if (isset($_FILES['test']['name']) && !empty($_FILES['test']['name']))
{
    foreach ($file_list as $key => $file)
    {
        echo '<pre>';
        $file_user = basename($file);
     if ($_FILES['test']['name'] == $file_user){
        header('Refresh: 2;');
        echo "Файл с таким именем существует";
        exit;
    }
}
//  Проверяем расширение
    $i = explode(".", $_FILES['test']['name']);
    if (end($i) == "json")
    {
//    Проверяем структуру
        $fileTmp = $_FILES['test']['tmp_name'];
        $file_get_tmp = file_get_contents($fileTmp);
        $decode_tmp = json_decode($file_get_tmp, true);
        foreach ($decode_tmp as $test_tmp)
        {
            if (isset($test_tmp['question']) && isset($test_tmp['answers']))
            {
                for($i=0; $i<count($test_tmp['answers']); $i++)
                {
                    if((isset($test_tmp['answers'][$i]['answer']) && isset($test_tmp['answers'][$i]['result'])) == false)
                    {
                        header('Refresh: 2;');
                        echo "Ошибка." . "<br>" . "Повторите еще раз.";
                        unlink($fileTmp);
                        echo "<p><a href=\"admin.php\">Загрузить тест</a></p>";
                        echo "<p><a href=\"list.php\">Выбрать тест</a></p>";
                        exit;
                    }
                }
            }
            else
            {
                header('Refresh: 2;');
                echo "Ошибка." . "<br>" . "Повторите еще раз.";
                unlink($fileTmp);
                echo "<p><a href=\"admin.php\">Загрузить тест</a></p>";
                echo "<p><a href=\"list.php\">Выбрать тест</a></p>";
                exit;
            }
        }
        $file_name = $_FILES['test']['name'];
        $tmp_file = $_FILES['test']['tmp_name'];
        $upload_dir =__DIR__ =='uploads/';
        if (($_FILES['test']['error'] == UPLOAD_ERR_OK) &&
            move_uploaded_file($tmp_file, $upload_dir . $file_name))
        {
            $file_list = true;
            echo "Вы находитесь на странице Выбора тестов";
            header("Location: list.php");
        }
        else
        {
            echo "Файл не отправлен";
        }
    }
    else
    {
        echo "Неверное расширение";
    }
}
?>

<html>
<head>
    <title>Форма для загрузки теста</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <?php if($file_send != true) {?>
    <label for="test" style="margin-bottom: 15px; display: block; cursor: pointer;">Загрузите файл</label>
    <?php } else {?>
    <label for="test" style="margin-bottom: 15px; display: block; cursor: pointer;">Еще файл</label>
    <?php } ?>
    <input type="file" name="test" id="test"><br><br>
    <input type="submit" name="test" value="Отправить">
</form>
<p><a href="list.php">Выбрать тест</a></p>
<p><a href="admin.php">Загрузить тест</a></p>
</body>
</html>
