<?php
global $user, $pass;
header('Content-Type: text/html; charset=UTF-8');

$errors = [];

include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка наличия ФИО
    if (empty($_POST['fio'])) {
        $errors[] = 'Поле ФИО обязательно для заполнения.';
    }

    // Проверка телефона
    if (empty($_POST['tel'])) {
        $errors[] = 'Поле Телефон обязательно для заполнения.';
    } elseif (!ctype_digit($_POST['tel'])) {
        $errors[] = 'Поле Телефон должно содержать только цифры.';
    } elseif (strlen($_POST['tel']) !== 11) {
        $errors[] = 'Поле Телефон должно содержать 11 цифр.';
    }

    // Проверка email
    if (empty($_POST['email'])) {
        $errors[] = 'Поле Email обязательно для заполнения.';
    } elseif (!strpos($_POST['email'], '@')) {
        $errors[] = 'Поле Email должно содержать символ "@".';
    }

    // Проверка даты
    if (empty($_POST['date'])) {
        $errors[] = 'Поле Дата обязательно для заполнения.';
    } elseif (!strtotime($_POST['date'])) {
        $errors[] = 'Поле Дата должно быть корректной датой.';
    }

    // Проверка пола
    if (empty($_POST['gender'])) {
        $errors[] = 'Поле Пол обязательно для выбора.';
    } elseif (!in_array($_POST['gender'], ['m', 'w'])) {
        $errors[] = 'Поле Пол должно быть корректным.';
    }

    // Проверка любимого языка программирования
    $valid_languages = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]; // идентификаторы языков из базы данных
    if (empty($_POST['select'])) {
        $errors[] = 'Поле Любимый язык программирования обязательно для выбора.';
    } elseif (!array_intersect($_POST['select'], $valid_languages)) {
        $errors[] = 'Поле Любимый язык программирования содержит некорректное значение.';
    }

    // Проверка биографии
    if (empty($_POST['bio'])) {
        $errors[] = 'Поле Биография обязательно для заполнения.';
    } elseif (!preg_match('/^[\p{L}\p{M}\p{P}\s]+$/u', $_POST['bio'])) {
        $errors[] = 'Поле Биография должно содержать только латинские, русские буквы и знаки препинания.';
    }

    // Проверка чекбокса
    if (empty($_POST['checkbox']) || $_POST['checkbox'] !== 'y') {
        $errors[] = 'Вы должны согласиться с контрактом.';
    }

    if (count($errors) === 0) {
        try {
            $db = new PDO('mysql:host=localhost;dbname=u67449', $user, $pass, [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Добавление записи о пользователе
            $stmt_user = $db->prepare("INSERT INTO users (fio, tel, email, date, gender, bio, checkbox) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt_user->execute([
                $_POST['fio'],
                $_POST['tel'],
                $_POST['email'],
                $_POST['date'],
                $_POST['gender'],
                $_POST['bio'],
                $_POST['checkbox']
            ]);

            // Получение ID только что добавленного пользователя
            $user_id = $db->lastInsertId();

            // Получение списка выбранных языков программирования
            $selected_languages = isset($_POST['select']) ? $_POST['select'] : [];

            // Добавление записей о выбранных языках программирования
            foreach ($selected_languages as $lang_id) {
                $stmt_lang = $db->prepare("INSERT INTO user_programming_languages (user_id, lang_id) VALUES (?, ?)");
                $stmt_lang->execute([$user_id, $lang_id]);
            }

            header('Location: ?save=1');
            exit();
        } catch (PDOException $e) {
            $errors[] = 'Ошибка базы данных: ' . $e->getMessage();
        }
    }
}


include('form.php');
exit();
?>
