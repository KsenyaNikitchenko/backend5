<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();

$db_user = 'u52984';
$db_pass = '8295850';

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['do'])&&$_GET['do'] == 'logout'){
    session_start();    
    session_unset();
    session_destroy();
    setcookie ("PHPSESSID", "", time() - 3600, '/');
    header("Location: index.php");
    exit;}
?>

<form action="" method="post">
  <p><label for="login">Логин </label><input name="login"></p>
  <p><label for="password">Пароль </label><input name="password"></p>
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {

  $login = $_POST['login'];
  $password =  $_POST['password'];

  $db = new PDO('mysql:host=localhost;dbname=u52984', $db_user, $db_pass, array(
    PDO::ATTR_PERSISTENT => true
  ));

  try {
    $stmt = $db->prepare("SELECT * FROM user WHERE login = ?");
    $stmt->execute(array($login));
    // Получаем данные в виде массива из БД.
    $user = $stmt->fetch();
    // Сравнием текущий хэш пароля с тем, что достали из базы.
    if (password_verify($password, $user['password'])) {
      $_SESSION['login'] = $login;
    }
    else {
      echo "Неправильный логин или пароль";
      exit();
    }

  }
  catch(PDOException $e) {
    echo 'Ошибка: ' . $e->getMessage();
    exit();
  }
  header('Location: ./form.php');
}
