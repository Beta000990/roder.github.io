<?php
include $_SERVER["DOCUMENT_ROOT"] . '/inc/header.php';
include $_SERVER["DOCUMENT_ROOT"] . '/inc/nav.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/inc/config.php';

$id = $_GET['id'] ?? 0;

if ($isloggedin !== 'yes') {
    header('location: /login.aspx');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $content = $_POST["content"];
    
    $stmt = $conn->prepare("INSERT INTO comments (id, userid, assetid, content, time_posted) VALUES (NULL, :userid, :assetid, :content, :time_posted)");
    $stmt->bindParam(':userid', $_USER['id'], PDO::PARAM_INT);
    $stmt->bindParam(':assetid', $id, PDO::PARAM_INT);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':time_posted', time(), PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Successfully posted a comment!";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
    exit;
}

echo "<script>document.location = \"Item.aspx?id=$id\"</script>";

?>