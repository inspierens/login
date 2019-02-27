<?php
require "db.php";

$data = $_POST;
if (isset($data['do_signup'])) {
    //registration
    $errors = array();
    if (trim($data['login']) == '') {
        $errors[] = 'Введите логин!';
    }
    if (trim($data['email']) == '') {
        $errors[] = 'Введите e-mail!';
    }
    if ($data['password'] == '') {
        $errors[] = 'Введите пароль!';
    }
    if ($data['password_2'] != $data['password']) {
        $errors[] = 'Повторный пароль введен не верно!';
    }
    if (R::count('users', "login = ?" , array($data['login'])) >0) {
        $errors[] = 'Пользователь с таким логином уже существует!';
    }
    if (R::count('users', "email = ?" , array($data['email'])) >0) {
        $errors[] = 'Пользователь с таким e-mail уже существует!';
    }

    if (empty($errors)) {
        $user = R::dispense('users');
        $user->login = $data['login'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'],PASSWORD_DEFAULT);
        R::store($user);
        echo '<div style="color: green;">Вы успешно зарегистрировались!</div><hr>';

    } else {
        echo '<div style="color: red;">' . array_shift($errors) . '</div><hr>';
    }
}
?>

<form action="/signup.php" method="POST">

    <p><strong>Ваш логин</strong>:</p>
    <input type="text" name="login" value="<?php echo @$data['login'];?>">

    <p><strong>Ваш e-mail</strong>:</p>
    <input type="email" name="email" value="<?php echo @$data['email'];?>">

    <p><strong>Ваш пароль</strong>:</p>
    <input type="password" name="password" value="<?php echo @$data['password'];?>">

    <p><strong>Повторите Ваш пароль</strong>:</p>
    <input type="password" name="password_2" value="<?php echo @$data['password_2'];?>">

    <p>
        <button type="submit" name="do_signup">Зарегистрироваться</button>
    </p>

</form>
