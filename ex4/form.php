<?php
include('config.php');

try {
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass, [
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    print($e->getMessage());
    exit();
}

$languages = [];

try {
    $stmt = $db->prepare("SELECT * FROM p_languages;");
    $stmt->execute();
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print($e->getMessage());
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container mt-5">
    <h1 class="text-center">Форма</h1>

    <?php if (!empty($messages)): ?>
        <div class="alert alert-danger" role="alert">
            <?php foreach ($messages as $message): ?>
                <p><?php echo $message; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form id="form1" action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">ФИО</label>
            <input name="fio" id="name" class="form-control <?php if ($errors['fio']) {print 'is-invalid';} ?>" placeholder="Введите ваше имя" value="<?php print $values['fio']; ?>">
        </div>
        <div class="mb-3">
            <label for="tel" class="form-label">Телефон</label>
            <input type="tel" name="tel" id="tel" class="form-control <?php if ($errors['tel']) {print 'is-invalid';} ?>" placeholder="Введите телефон" value="<?php print $values['tel']; ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Эл. Почта</label>
            <input name="email" type="email" class="form-control <?php if ($errors['email']) {print 'is-invalid';} ?>" id="email" placeholder="Введите вашу почту" value="<?php print $values['email']; ?>">
        </div>
        <div class="mb-3">
            <label for="dob" class="form-label">Дата рождения</label>
            <input name="date_of_birth" type="date" class="form-control <?php if ($errors['date_of_birth']) {print 'is-invalid';} ?>" value="<?php print $values['date_of_birth']; ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Пол</label><br>
            <input type="radio" class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g1" value="m" <?php if ($values['gender']=='m') {print 'checked';} ?>> Мужчина
            <input type="radio" class="form-check-input <?php if ($errors['gender']) {print 'is-invalid';} ?>" name="gender" id="g2" value="w" <?php if ($values['gender']=='w') {print 'checked';} ?>> Женщина
        </div>
        <div class="mb-3">
            <label for="mltplslct" class="form-label">Любимый язык программирования</label>
            <select class="form-control <?php if ($errors['languages']) {print 'is-invalid';} ?>" name="languages[]" id="mltplslct" multiple="multiple">
                <?php foreach ($languages as $language): ?>
                    <option value="<?= htmlspecialchars($language['id']); ?>"
                        <?php if (!empty($values['languages']) && in_array($language['id'], $values['languages'])) {echo 'selected';} ?>>
                        <?= htmlspecialchars($language['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="bio" class="form-label">Биография</label>
            <textarea name="bio" id="bio" rows="5" class="form-control <?php if ($errors['bio']) {print 'is-invalid';} ?>"><?php print $values['bio']; ?></textarea>
        </div>
        <div class="mb-3">
            <input type="checkbox" class="form-check-input <?php if ($errors['checkbox']) {print 'is-invalid';} ?>" id="checkbox" value="1" name="checkbox" <?php if ($values['checkbox']=='1') {print 'checked';} ?>>
            <label for="checkbox" class="form-check-label">с контрактом ознакомлен (а)</label>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
</div>
</body>
</html>
