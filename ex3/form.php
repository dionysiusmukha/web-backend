<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body style="background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);">
<h1 class="text-center display-1">Форма</h1>
<div style="height: 800px; width: 800px; margin: auto">
    <div class="container ">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form class="mx-auto" action="" method="POST">
            <div class="my-3">
                <label for="fio" class="form-label text-body-secondary"><strong>ФИО</strong></label>
                <input type="text" class="form-control" name="fio" id="fio" placeholder="Муха Денис"/>
            </div>
            <div class="my-3">
                <label for="telInput" class="form-label text-body-secondary"><strong>Телефон</strong></label>
                <input type="tel" class="form-control" name="tel" id="telInput" placeholder="79002914644"/>
            </div>
            <div class="my-3">
                <label for="emailInput" class="form-label text-body-secondary"><strong>Эл. Почта</strong></label>
                <input type="email" class="form-control" name="email" id="emailInput" placeholder="denismukha@inbox.ru"/>
            </div>
            <div class="my-3">
                <label for="bdInput" class="form-label text-body-secondary"><strong>Дата рождения</strong></label>
                <input type="date" class="form-control" name="date" id="bdInput"/>
            </div>
            <div class="my-3">
                <legend class="col-form-label text-body-secondary"><strong>Пол</strong></legend>
                <div class="row">
                    <div class="col">
                        <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="m" checked>
                        <label for="genderInput" class="form-label">Мужчина</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="w">
                        <label for="genderInput" class="form-label">Женщина</label>
                    </div>
                </div>
            </div>
            <div class="my-3">
                <div class="row">
                    <label for="manyInput" class="form-label text-body-secondary"><strong>Любимый язык программирования</strong></label>
                </div>
                <div class="row">
                    <div class="col-6">
                        <select name="select[]" class="form-select" size="5" multiple id="manyInput">
                            <option selected value="1">Pascal</option>
                            <option value="2">C</option>
                            <option value="3">C++</option>
                            <option value="4">JavaScript</option>
                            <option value="5">PHP</option>
                            <option value="6">Python</option>
                            <option value="7">Java</option>
                            <option value="8">Haskel</option>
                            <option value="9">Clojure</option>
                            <option value="10">Prolog</option>
                            <option value="11">Scala</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="input-group my-3">
                        <span class="input-group-text">Биография</span>
                        <textarea name="bio" class="form-control" aria-label="Биография"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-check my-3">
                        <input class="form-check-input" name="checkbox" type="checkbox" value="y" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            с контрактом ознакомлен(а)
                        </label>
                    </div>
                </div>
                <div class="col-9">
                    <div class="my-3">
                        <button type="submit" class="btn btn-primary mb-3" value="ok">Сохранить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
