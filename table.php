<?php

// Подключение к базе данных
$db = new PDO('sqlite:database.sqlite');

// Обработка ошибок подключения
if ($db->errorCode()) {
  $error = $db->errorCode();
  $errorInfo = $db->errorInfo();
  echo "Ошибка подключения к базе данных: $error - " . implode(', ', $errorInfo);
  exit;
}

// Получение записей из базы данных
$stmt = $db->query('SELECT * FROM bookings');

// Обработка ошибок выполнения
if (!$stmt) {
  $error = $stmt->errorCode();
  $errorInfo = $stmt->errorInfo();
  errorLog('errors.log', date('Y-m-d H:i:s') . " - Ошибка выполнения запроса: $error - " . implode(', ', $errorInfo) . "\n");
  echo "Ошибка выполнения запроса";
  exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Забронированные визиты</title>
</head>
<body>
  <h1>Забронированные визиты</h1>
  <table>
    <thead>
      <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Email</th>
        <th>Телефон</th>
        <th>Дата</th>
        <th>Время</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($bookings as $booking) : ?>
      <tr>
        <td><?php echo $booking['name']; ?></td>
        <td><?php echo $booking['surname']; ?></td>
        <td><?php echo $booking['email']; ?></td>
        <td><?php echo $booking['phone']; ?></td>
        <td><?php echo $booking['date']; ?></td>
        <td><?php echo $booking['time']; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>