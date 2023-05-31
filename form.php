<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array();
  $errors['name'] = !empty($_COOKIE['name_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['gender'] = !empty($_COOKIE['gender_error']);
  $errors['limbs'] = !empty($_COOKIE['limbs_error']);
  $errors['super'] = !empty($_COOKIE['super_error']);
  $errors['biography'] = !empty($_COOKIE['biography_error']);
  if ($errors['name']) {
    setcookie('name_error', '', 100);
    $messages[] = '<div class="error_m">Заполните имя. Данное поле может содержать
     символы русского и английского алфавитов.</div>';
  }
  if ($errors['email']) {
    setcookie('email_error', '', 100);
    $messages[] = '<div class="error_m">Заполните email. Поле должно содержать только символы 
    английского алфавита и знак @ (почта должна иметь домен .ru)</div>';
  }
  if ($errors['year']) {
    setcookie('year_error', '', 100);
    $messages[] = '<div class="error_m">Заполните год рождения.</div>';
  }
  if ($errors['gender']) {
    setcookie('gender_error', '', 100);
    $messages[] = '<div class="error_m">Выберите пол.</div>';
  }
  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100);
    $messages[] = '<div class="error_m">Укажите количество конечностей.</div>';
  }
  if($errors['super']){
    setcookie('super_error','',100);
    $messages[]='<div class="error_m">Выберите минимум одну сверхспособность.</div>';
  }
  if ($errors['biography']) {
    setcookie('biography_error', '', 100);
    $messages[] = '<div class="error_m">Расскажите что-нибудь о себе.</div>';
  }

  // Складываем предыдущие значения полей в массив, если есть.
  $values = array();
  $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
  $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? '' : $_COOKIE['year_value'];
  $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
  $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
  $values['super'] = [];
  $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];
  $super=array(
    'deathless'=>'Бессмертие',
    'walls'=>'Прохождение сквозь стены',
    'levitation'=>'Левитация',
    'elements'=>'Управление стихиями',
    'time travel'=>'Путешествие во времени',
  );
if(!empty($_COOKIE['super_value'])){
  $super_value=unserialize($_COOKIE['super_value']);
  foreach($super_value as $el){
    if(!empty($super[$el])){
      $values['super'][$el]=$el;
    }
  }
}
  include('index.php');
}
else {
  // Проверяем ошибки.
  $errors = FALSE;
  if (empty($_POST['name'])) {
    setcookie('name_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match("/[a-zA-Zа-яёА-ЯЁ]/", $_POST['name'])){
    setcookie('name_error', $_POST['name'], time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('name_value', $_POST['name'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['email'])) {
    setcookie('email_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match("/.*@.*\.ru$/", $_POST['email'])){
    setcookie('email_error', $_POST['email'], time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['year'])) {
    setcookie('year_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('year_value', $_POST['year'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['gender'])) {
    setcookie('gender_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['limbs'])) {
    setcookie('limbs_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
  }
  if (empty($_POST['biography'])) {
    setcookie('biography_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else {
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
  }
  if(empty($_POST['super'])){
    setcookie('super_error','1',time()+24*60*60);
    $errors=TRUE;
  }
  else{
    foreach($_POST['super'] as $key=>$value){
      $super[$key]=$value;
    }
    setcookie('super_value',serialize($super),time()+30*24*60*60);
  }

  if ($errors) {
    // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
    header('Location: form.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('name_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('year_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('superpower_error', '', 100000);
    setcookie('fio_error', '', 100000);
  }
  // Сохранение в базу данных.
$user = 'u52984';
$pass = '8295850';
$db = new PDO('mysql:host=localhost;dbname=u52984', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
// Подготовленный запрос. Не именованные метки.
try {
    $stmt = $db->prepare("INSERT INTO person5 (name, email, year, gender, limbs, biography) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt -> execute([$_POST['name'], $_POST['email'], $_POST['year'], $_POST['gender'], $_POST['limbs'], $_POST['biography']]);
    $last_index=$db->lastInsertId();
    $stmt = $db->prepare("SELECT id_power FROM superpower WHERE superpower = ?");
    foreach ($_POST['superpowers'] as $value) {
        $stmt->execute([$value]);
        $id_power=$stmt->fetchColumn();
        $stmt1 = $db->prepare("INSERT INTO ability5 (id_user, id_superpower) VALUES (?, ?)");
        $stmt1 -> execute([$last_index, $id_power]);
    }
    unset($value);
}
catch(PDOException $e){
print('Error: ' . $e->getMessage());
exit();
}
setcookie('save','1');
header('Location: ?save=1');
}