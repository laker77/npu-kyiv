<?php
// Підключення до бази даних
$conn = new mysqli('localhost', 'j97416qp_evak', 'SiMi2015', 'j97416qp_evak');

if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Функція для отримання статистики евакуації автомобілів
function getEvacuationStatistics($conn) {
    $today_sql = "SELECT COUNT(*) as count_today FROM evakuations WHERE DATE(date_time) = CURDATE()";
    $today_result = $conn->query($today_sql);
    $count_today = $today_result->fetch_assoc()['count_today'];

    $week_sql = "SELECT COUNT(*) as count_week FROM evakuations WHERE YEARWEEK(date_time, 1) = YEARWEEK(CURDATE(), 1)";
    $week_result = $conn->query($week_sql);
    $count_week = $week_result->fetch_assoc()['count_week'];

    $total_sql = "SELECT COUNT(*) as count_total FROM evakuations";
    $total_result = $conn->query($total_sql);
    $count_total = $total_result->fetch_assoc()['count_total'];

    return [
        'count_today' => $count_today,
        'count_week' => $count_week,
        'count_total' => $count_total
    ];
}

// Функція для отримання статистики слідчого управління
function getInvestigationStatistics($conn) {
    $sql = "SELECT COUNT(*) as total_cases, SUM(status='open') as open_cases, SUM(status='closed') as closed_cases FROM cases";
    $result = $conn->query($sql);
    return $result->fetch_assoc();
}

// Отримання статистики
$evacuation_stats = getEvacuationStatistics($conn);
$investigation_stats = getInvestigationStatistics($conn);

// Закриття з'єднання
$conn->close();
?>
