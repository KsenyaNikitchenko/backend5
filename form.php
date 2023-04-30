<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <title>Сверхспособности</title>
    <link rel="stylesheet" href="style_form.css">
</head>

<body>
    <div class="form">
        <h1>Сверхспособности</h1>
        <form action="index.php" method="POST">
            <label for="name" class="error">
                Введите имя:<br>
                <input name="name" placeholder="Введите имя" /><br>
            </label>
            <label for="email">
                Адрес электронной почты:<br>
                <input name="email" type="email" placeholder="Введите email" /><br>
            </label>
            <label for="year">Год рождения</label>
            <select name="year">
                <!--<?php 
    for ($i = 1922; $i <= 2022; $i++) {
      printf('<option value="%d">%d</option>', $i, $i);
    }
    ?>-->
            </select>
            <br>
            <label for="gender">Выберите пол:</label><br>
            <label><input type="radio" checked="checked" name="gender" value="female" />
                Женский</label>
            <label><input type="radio" name="gender" value="male" />
                Мужской</label>
            <br>
            <label for="limbs">Количество конечностей:</label><br>
            <label><input type="radio" checked="checked" name="limbs" value="1" />
                1</label>
            <label><input type="radio" name="limbs" value="2" />
                2</label>
            <label><input type="radio" name="limbs" value="3" />
                3</label>
            <label><input type="radio" name="limbs" value="4" />
                4</label>
            <br>
            <label for="superpowers">Сверхспособности:</label><br>
            <select name="superpowers[]" multiple="multiple">
                <option value="deathless">Бессмертие</option>
                <option value="walls" selected="selected">Прохождение сквозь стены</option>
                <option value="levitation">Левитация</option>
                <option value="elements">Управление стихиями</option>
                <option value="time travel">Путешествие во времени</option>
            </select>
            <br>
            <label for="biography">Биография:</label><br>
            <textarea name="biography">Напишите о себе</textarea><br>
            <label><input type="checkbox" checked="checked" name="check-kontrol" />
                с контрактом ознакомлен(а)</label>
            <br>
            <input type="submit" class="submit" value="Отправить" />

        </form>
    </div>

</body>

</html>