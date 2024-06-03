<?php
include('config.php');

// Инициализация переменной для сообщений
$messages = array();

try {
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    print($e->getMessage());
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($_GET['save'])) {
        setcookie('save', '', 100000);
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date_of_birth'] = !empty($_COOKIE['date_of_birth_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['languages'] = !empty($_COOKIE['languages_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);

    if ($errors['fio']) {
        setcookie('fio_error', '', 100000);
        $messages[] = 'Заполните корректно имя. Минимум 5 символов, только русские и английские буквы.<br/>';
    }
    if ($errors['tel']) {
        setcookie('tel_error', '', 100000);
        $messages[] = 'Пожалуйста, введите корректный номер телефона. Номер телефона должен содержать больше 6 символов<br/>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = 'Заполните корректно email.<br/>';
    }
    if ($errors['date_of_birth']) {
        setcookie('date_of_birth_error', '', 100000);
        $messages[] = 'Заполните корректно дату рождения в формате дд/мм/гггг.<br/>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = 'Выберите пол.<br/>';
    }
    if ($errors['languages']) {
        setcookie('languages_error', '', 100000);
        $messages[] = 'Выберите хотя бы один ЯП.<br/>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages[] = 'Заполните корректно биографию.<br/>';
    }
    if ($errors['checkbox']) {
        setcookie('checkbox_error', '', 100000);
        $messages[] = 'Вы не согласились с условиями контракта.<br/>';
    }

    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date_of_birth'] = empty($_COOKIE['date_of_birth_value']) ? '' : $_COOKIE['date_of_birth_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['languages'] = empty($_COOKIE['languages_value']) ? array() : unserialize($_COOKIE['languages_value']);
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];

    include('form.php');
} else {
    $errors = FALSE;

    if (empty($_POST['fio']) || !preg_match('/^([а-яА-ЯЁёa-zA-Z_,.\s-]+)$/u', $_POST['fio']) || strlen($_POST['fio']) < 5 ) {
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('fio_value', $_POST['fio'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['tel']) || strlen($_POST['tel']) <= 6) {
        setcookie('tel_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('tel_value', $_POST['tel'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('email_value', $_POST['email'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['date_of_birth']) || !preg_match('%[1-2][0-9][0-9][0-9]-[0-1][0-9]-[0-3][0-9]%', $_POST['date_of_birth'])) {
        setcookie('date_of_birth_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('date_of_birth_value', $_POST['date_of_birth'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['gender']) || !in_array($_POST['gender'], ['w', 'm'])) {
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['languages'])) {
        setcookie('languages_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        foreach ($_POST['languages'] as $language) {
            if (!in_array($language, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11])) {
                setcookie('languages_error', '1', time() + 24 * 60 * 60);
                $errors = TRUE;
                break;
            }
        }
        $abs = array();
        foreach ($_POST['languages'] as $res) {
            $abs[$res - 1] = $res;
        }
        setcookie('languages_value', serialize($abs), time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['bio']) || !preg_match('/^([а-яА-ЯЁёa-zA-Z0-9_,.\s-]+)$/u', $_POST['bio'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['bio'], time() + 365 * 24 * 60 * 60);
    }

    if (empty($_POST['checkbox']) || $_POST['checkbox'] != 1) {
        setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
        setcookie('checkbox_value', '0', time() + 365 * 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('checkbox_value', '1', time() + 365 * 24 * 60 * 60);
    }

    if ($errors) {
        header('Location: .');
        exit();
    } else {
        foreach (['fio', 'tel', 'email', 'date_of_birth', 'gender', 'languages', 'bio', 'checkbox'] as $field) {
            setcookie($field . '_error', '', 100000);
        }
    }

    try {
        $stmt = $db->prepare("INSERT INTO p_application SET name = ?, tel = ?, email = ?, date_of_birth = ?, gender = ?, biography = ?");
        $stmt->execute([$_POST['fio'], $_POST['tel'], $_POST['email'], $_POST['date_of_birth'], $_POST['gender'], $_POST['bio']]);
        $application_id = $db->lastInsertId();

        $stmt = $db->prepare("INSERT INTO p_application_languages SET application_id = ?, language_id = ?");
        foreach ($_POST['languages'] as $language) {
            $stmt->execute([$application_id, $language]);
        }
    } catch (PDOException $e) {
        print($e->getMessage());
        exit();
    }

    setcookie('save', '1');
    header('Location: ./');
}
