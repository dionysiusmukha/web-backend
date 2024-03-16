<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="device-width, initial-scale=1.0">
        <title>Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
<body>
<form action="" method="POST">
    <input name="fio" />
    <select name="year">
        <?php
        for ($i = 1921; $i <= 2022; $i++) {
            printf('<option value="%d">%d год</option>', $i, $i);
        }
        ?>
    </select>
    <input type="submit" value="ok" />
</form>
<div class="p-3 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3">
    Пример элемента с утилитами
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>