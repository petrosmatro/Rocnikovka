<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

    $conn = mysqli_connect('localhost', 'root', '', 'mytierlist');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $uploads_dir = 'uploads';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    $files = $_FILES['files'];
    $response = [];

    $session_id = $_SESSION['session_id'];


    for ($i = 0; $i < count($files['name']); $i++) {
        $tmp_name = $files['tmp_name'][$i];
        $name = basename($files['name'][$i]);
        $upload_file = "$uploads_dir/$name";

        if (move_uploaded_file($tmp_name, $upload_file)) {
            // Vložení informací o souboru do databáze
            $stmt = $conn->prepare("INSERT INTO temp_images (img_name, session_id) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $session_id);

            if ($stmt->execute()) {
                $response[] = ["name" => $name, "status" => "success"];
            } else {
                $response[] = ["name" => $name, "status" => "error", "error" => $stmt->error];
            }
            $stmt->close();
        } else {
            $response[] = ["name" => $name, "status" => "error"];
        }
    }

    $conn->close();
    echo json_encode($response);
}
?>
