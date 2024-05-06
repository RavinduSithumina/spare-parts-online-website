php
<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];

// Replace this with your own database connection and user validation logic
$conn = new mysqli('localhost', 'username', 'password', 'login');

if ($conn->connect_error) {
    die(json_encode(['success' => false]));
}

$sql = "SELECT * FROM users WHERE username = ? AND email = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $username, $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
$stmt->close();
$conn->close();
?>