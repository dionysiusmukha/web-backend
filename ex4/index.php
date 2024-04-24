<?php
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */
global $user, $pass;
include('../ex4/config.php');

// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_COOKIE['select_value'])) {
        // Преобразуем строку из куки в массив
        $selectValues = explode(',', $_COOKIE['select_value']);
    } else {
        // Если куки нет, присваиваем пустой массив
        $selectValues = [];
    }
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
    // Выдаем сообщение об успешном сохранении.
    if (!empty($_COOKIE['save'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('save', '', 100000);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['select'] = !empty($_COOKIE['select_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['checkbox'] = !empty($_COOKIE['checkbox_error']);

    // Выдаем сообщения об ошибках.
    if ($errors['fio']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('fio_error', '', 100000);
        setcookie('fio_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    if ($errors['tel']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('tel_error', '', 100000);
        setcookie('tel_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните телефон</div>';
    }
    if ($errors['email']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните почту.</div>';
    }
    if ($errors['date']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('date_error', '', 100000);
        setcookie('date_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните дату</div>';
    }
    if ($errors['gender']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Выберете пол</div>';
    }

    if ($errors['select']) {
            // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('select_error', '', 100000);
        setcookie('select_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните языки.</div>';
    }

    if ($errors['bio']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните биографию</div>';
    }
    if ($errors['checkbox']) {
        // Удаляем куки, указывая время устаревания в прошлом.
        setcookie('checkbox_error', '', 100000);
        setcookie('checkbox_value', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Укажите, что вы согласились с правилами</div>';
    }

    $select_cookie = isset($_COOKIE['select_value']) ? $_COOKIE['select_value'] : '';
    $select_values = explode(',', $select_cookie);
    // Проверяем, что все выбранные значения есть в списке допустимых значений
    $allowed_values = ['1', '2', '3','4','5','6','7','8','9','10','11'];
    foreach ($select_values as $value) {
        if (!in_array($value, $allowed_values)) {
            setcookie('select_error', '1', time() + 24 * 60 * 60);
            $errors['select'] = TRUE;
            $messages[] = '<div class="error">Обязательно выбрать язык из существующего</div>';
            break;
        }
    }


    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['select'] = empty($_COOKIE['select_value']) ? '' : $_COOKIE['select_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['checkbox'] = empty($_COOKIE['checkbox_value']) ? '' : $_COOKIE['checkbox_value'];


    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    include('form.php');
}
// Иначе, если запрос был методом POST, т.е. нужно проверить данные и сохранить их в XML-файл.
else {
    try {
        $db = new PDO("mysql:host=localhost;dbname=u67449", $user, $pass, [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } catch(PDOException $e) {
        // Выводим сообщение об ошибке подключения к базе данных
        echo "Ошибка подключения: " . $e->getMessage();
        exit;
    }
    // Проверяем ошибки.
    $errors = FALSE;
    $select_values = implode(',', $_POST['select']);
    setcookie('select_value', $select_values, time() + 30 * 24 * 60 * 60);
    if (empty($_POST['fio']) || !preg_match("/^[a-zA-Z-' ]*$/", $_COOKIE['fio_error'])) {
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
    // Сохраняем ранее введенное в форму значение на месяц.
    setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);


    if (empty($_POST['tel']) || !preg_match('/^\d+$/', $_POST['tel'])) {
        // Выдаем куку на день с флажком об ошибке в поле tel.
        setcookie('tel_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('tel_value', $_POST['tel'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        // Выдаем куку на день с флажком об ошибке в поле email.
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['date']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $_POST['date'])) {
        // Выдаем куку на день с флажком об ошибке в поле date.
        setcookie('date_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('date_value', $_POST['date'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['gender'])) {
        // Выдаем куку на день с флажком об ошибке в поле gender.
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['bio']) || !preg_match('/^[a-zA-Zа-яА-Я\s,.]+$/', $_POST['bio'])) {
        // Выдаем куку на день с флажком об ошибке в поле bio.
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);

    if (empty($_POST['checkbox'])) {
        // Выдаем куку на день с флажком об ошибке в поле checkbox.
        setcookie('checkbox_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    }
// Сохраняем ранее введенное в форму значение на месяц.
    setcookie('checkbox_value', $_POST['checkbox'], time() + 30 * 24 * 60 * 60);


    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    }
    else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('fio_error', '', 100000);
        setcookie('tel_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('date_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('select_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('checkbox_error', '', 100000);
    }

    // Сохранение в БД.
    $stmt = $db->prepare("INSERT INTO your_table (fio, tel, email, date, gender, select, bio, checkbox) VALUES (:fio, :tel, :email, :date, :gender, :languages, :bio, :agreement)");
    // Привязка значений к параметрам SQL-запроса
    $stmt->bindParam(':fio', $_POST['fio']);
    $stmt->bindParam(':tel', $_POST['tel']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':date', $_POST['date']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':select', $select_values);
    $stmt->bindParam(':bio', $_POST['bio']);
    $stmt->bindParam(':checkbox', $_POST['checkbox']);
    try {
        $stmt->execute();
        // Успешно сохранено, вы можете вывести сообщение об этом
        echo "Данные успешно сохранены в базе данных.";
    } catch(PDOException $e) {
        // Обработка ошибок при выполнении запроса
        echo "Ошибка при сохранении данных: " . $e->getMessage();
    }

    // Сохраняем куку с признаком успешного сохранения.
    setcookie('save', '1');

    // Делаем перенаправление.
    header('Location: index.php');
}
