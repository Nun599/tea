<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?error=' . urlencode('Please login first.'));
    exit;
}

$res = $mysqli->query("SELECT id, first_name, last_name, email, address, created_at FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Users List</title></head>
<body>
  <h2>Registered Users</h2>
  <table border="1" cellpadding="6" cellspacing="0">
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Address</th><th>Created At</th></tr>
    <?php while ($row = $res->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['address']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
  <p><a href="main.php">Back</a></p>
</body>
</html>
