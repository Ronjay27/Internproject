<?php

include 'Db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to access this page.'); window.location.href='login.php';</script>";
    exit();
}

$user_role = $_SESSION['role'] ?? null; // Get the user's role

// Check if the user is an admin
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Access denied!'); window.location.href='index.php';</script>";
    exit();
}

// fetch audit logs from the database
$stmt = $conn->prepare("SELECT * FROM audit_logs ORDER BY timestamp DESC");
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="header">
        <img src="&.png" alt="Pharmacy Management System Logo" class="logo">
        <div class="header-text">
            <h1>Welcome to R&M Pharmacy Management System</h1>
            <p>Manage patients, pharmacists, cashiers, prescriptions, inventory, suppliers, and payments efficiently.</p>
        </div>
    </header>

    <nav class="navigation">
        <ul>
            <li><a href="index.php#dashboard">Dashboard</a></li>
            <li><a href="Editrecords.php">Details</a></li>
            <?php if ($user_role === 'admin'): ?>
                <li><a href="createUser.php">Manage Users</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Audit Logs</h2>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['action']); ?></td>
                        <td><?php echo $row['timestamp']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        $stmt->close();

        ?>
    </div>

    <footer class="footer">
        <p>&copy; 2025 R&M Pharmacy Management System. All rights reserved.</p>
        <p>Developed by Ssemanda Ronald</p>
    </footer>

</body>

</html>