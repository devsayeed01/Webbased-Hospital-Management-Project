<?php
include('db_config.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['del_type']) && isset($_GET['id'])) {
    $type = $_GET['del_type'];
    $id = $_GET['id'];
    if ($type == 'doctor') $query = "DELETE FROM doctors WHERE id = $id";
    if ($type == 'pathology') $query = "DELETE FROM pathology WHERE id = $id";
    if ($type == 'ambulance') $query = "DELETE FROM ambulance WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: admin_dash.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Staff Dashboard | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <header class="admin-header animate-pop">
            <h1>Staff Control Panel</h1>
            <div class="user-badge">
                <span>Logged in as: <strong>Admin</strong></span>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
        </header>

        <div class="dashboard-grid">
            <div class="admin-section animate-slide-in">
                <div class="section-icon">👨‍⚕️</div>
                <h3>Add New Doctor</h3>
                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_doctor">
                    <input type="text" name="name" placeholder="Doctor Name" required>
                    <input type="text" name="doc_id" placeholder="ID (e.g. D-101)" required>
                    <input type="text" name="dept" placeholder="Department" required>
                    <input type="text" name="phone" placeholder="Phone" required>
                    <input type="password" name="pass" placeholder="Password" required>
                    <button type="submit" class="btn-primary">Add Doctor</button>
                </form>
            </div>

            <div class="admin-section animate-slide-in" style="animation-delay: 0.2s;">
                <div class="section-icon">🔬</div>
                <h3>Pathology & Tests</h3>
                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_pathology">
                    <input type="text" name="t_name" placeholder="Test Name" required>
                    <input type="text" name="t_cat" placeholder="Category" required>
                    <input type="number" name="t_price" placeholder="Price" required>
                    <button type="submit" class="btn-primary">Add Test</button>
                </form>
                <div class="scroll-table">
                    <table class="admin-table">
                        <tr><th>Test</th><th>Price</th><th>Action</th></tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM pathology");
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<tr><td>{$row['test_name']}</td><td>৳{$row['price']}</td>
                                  <td><a href='admin_dash.php?del_type=pathology&id={$row['id']}' class='btn-del'>Delete</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="admin-section animate-slide-in" style="animation-delay: 0.4s;">
                <div class="section-icon">🚑</div>
                <h3>Ambulance Fleet</h3>
                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_ambulance">
                    <input type="text" name="d_name" placeholder="Driver Name" required>
                    <input type="text" name="phone" placeholder="Phone Number" required>
                    <input type="text" name="type" placeholder="Ambulance Type" required>
                    <button type="submit" class="btn-primary">Add Ambulance</button>
                </form>
                <div class="scroll-table">
                    <table class="admin-table">
                        <tr><th>Driver</th><th>Phone</th><th>Action</th></tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM ambulance");
                        while($row = mysqli_fetch_assoc($res)) {
                            echo "<tr><td>{$row['driver_name']}</td><td>{$row['phone']}</td>
                                  <td><a href='admin_dash.php?del_type=ambulance&id={$row['id']}' class='btn-del'>Delete</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>