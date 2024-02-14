<?php

// Подключение к базе данных
$db = new PDO('sqlite:database.sqlite');

// Функция для логирования ошибок
function errorLog($filename, $message) {
  $file = fopen($filename, 'a');
  if (!$file) {
    echo "Ошибка открытия файла журнала";
    exit;
  }
  fwrite($file, $message);
  fclose($file);
}

// Обработка ошибок подключения
if ($db->errorCode()) {
  $error = $db->errorCode();
  $errorInfo = $db->errorInfo();
  errorLog('errors.log', date('Y-m-d H:i:s') . " - Ошибка подключения к базе данных: $error - " . implode(', ', $errorInfo) . "\n");
  echo "Ошибка подключения к базе данных";
  exit;
}

// Получение данных из формы
$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$date = trim($_POST['date']);
$time = trim($_POST['time']);

// Проверка на пустые поля
if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
  echo "<p>Все поля должны быть заполнены!</p>";
  exit;
}

// Подготовка запроса
$stmt = $db->prepare('INSERT INTO bookings (name, surname, email, phone, date, time) VALUES (?, ?, ?, ?, ?, ?)');

// Обработка ошибок подготовки
if (!$stmt) {
  $error = $db->errorCode();
  $errorInfo = $db->errorInfo();
  errorLog('errors.log', date('Y-m-d H:i:s') . " - Ошибка подготовки запроса: $error - " . implode(', ', $errorInfo) . "\n");
  echo "Ошибка подготовки запроса";
  exit;
}

// Выполнение запроса
$stmt->execute([$name, $surname, $email, $phone, $date, $time]);

// Обработка ошибок выполнения
if ($stmt->errorCode()) {
  $error = $stmt->errorCode();
  $errorInfo = $stmt->errorInfo();
  errorLog('errors.log', date('Y-m-d H:i:s') . " - Ошибка выполнения запроса: $error - " . implode(', ', $errorInfo) . "\n");
  echo "Ошибка выполнения запроса";
  exit;
}

// Перенаправление на страницу с таблицей
header('Location: table.php');

?>