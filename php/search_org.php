<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Организация</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require('partials/globals.php');
    require('partials/header.php');

    $searched_user_id = $_GET['userID'] ?? 0;
    $user_query = "SELECT userfullname, userstatus FROM users WHERE userID = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("i", $searched_user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user = $user_result->fetch_assoc();
    $user_fullname = $user['userfullname'] ?? 'Неизвестный пользователь';
    $user_status = $user['userstatus'] ?? 'unknown';

    echo "<h2>Расписание для: " . htmlspecialchars($user_fullname) . "</h2>";

    $meetings_query = "SELECT day, time_slot, topic, userID, creatorID FROM meeting_requests WHERE (userID = ? OR creatorID = ?) AND status = 'confirmed'";
    $meetings_stmt = $conn->prepare($meetings_query);
    $meetings_stmt->bind_param("ii", $searched_user_id, $searched_user_id);
    $meetings_stmt->execute();
    $meetings_result = $meetings_stmt->get_result();
    $meetings = [];
    while ($meeting = $meetings_result->fetch_assoc()) {
        $other_user_id = ($meeting['userID'] == $searched_user_id) ? $meeting['creatorID'] : $meeting['userID'];
        $user_query = "SELECT userfullname FROM users WHERE userID = ?";
        $user_stmt = $conn->prepare($user_query);
        $user_stmt->bind_param("i", $other_user_id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $other_user_name = $user_result->fetch_assoc()['userfullname'];
        $meetings[$meeting['day']][$meeting['time_slot']] = $meeting['topic'] . " с " . $other_user_name;
    }

    $days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт'];
    $times = ['8:30 - 9:10', '9:25 - 10:05', '10:20 - 11:00', '11:05 - 11:45', '12:05 - 12:45', '13:05 - 13:45', '13:50 - 14:30', '14:45 - 15:25', '15:40 - 16:20', '16:25 - 17:05'];
    ?>
    <table>
        <tr>
            <th>День / Время</th>
            <?php foreach ($times as $time): ?>
                <th><?php echo $time; ?></th>
            <?php endforeach; ?>
        </tr>
        <?php foreach ($days as $day): ?>
        <tr>
            <td><?php echo $day; ?></td>
            <?php foreach ($times as $time): ?>
            <td>
                <?php
                if (isset($meetings[$day][$time])) {
                    echo $meetings[$day][$time];  // Вывод информации о подтвержденной встрече
                } else {
                    $displayed = false; // Флаг для проверки, было ли что-то отображено в текущем слоте
                    $sql = $user_status == 'student' ?
                        "SELECT subject FROM student_schedule WHERE userID = ? AND day = ? AND time_slot = ?" :
                        "SELECT class_id, subgroup FROM teacher_schedule WHERE userID = ? AND day = ? AND time_slot = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iss", $searched_user_id, $day, $time);
                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                        continue;
                    }
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        if ($displayed) {
                            // Если что-то уже было отображено, пропускаем дальнейшие выводы
                            continue;
                        }
                        if ($user_status == 'student') {
                            $subject_query = "SELECT subject_name FROM subjects WHERE subject_id = ?";
                            $subject_stmt = $conn->prepare($subject_query);
                            $subject_stmt->bind_param("i", $row['subject']);
                            $subject_stmt->execute();
                            $subject_result = $subject_stmt->get_result();
                            $subject_name = $subject_result->fetch_assoc()['subject_name'];
                            echo htmlspecialchars($subject_name);
                            $displayed = true; // Устанавливаем флаг, что в этом слоте уже что-то отображено
                        } else if ($user_status == 'teacher') {
                            $class_query = "SELECT class_name FROM classes WHERE class_id = ?";
                            $class_stmt = $conn->prepare($class_query);
                            $class_stmt->bind_param("i", $row['class_id']);
                            $class_stmt->execute();
                            $class_result = $class_stmt->get_result();
                            $class_name = $class_result->fetch_assoc()['class_name'];
                            echo htmlspecialchars($class_name) . " (" . htmlspecialchars($row['subgroup']) . ")";
                            $displayed = true; // Устанавливаем флаг, что в этом слоте уже что-то отображено
                        }
                    }
                    if (!$displayed) {
                        echo "<button onclick=\"location.href='booking_form.php?day=$day&time=$time&userID=$searched_user_id'\">Записаться на встречу</button>";
                    }                
                }
                ?>
            </td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
