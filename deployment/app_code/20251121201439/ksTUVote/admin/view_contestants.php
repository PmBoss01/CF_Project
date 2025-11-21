<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Please log in first'); window.location='login.php';</script>";
    exit();
}

include 'db.php';

// Fetch all positions for the filter dropdown
$positions = [];
$result = $conn->query("SELECT * FROM positions ORDER BY position_name ASC");
while ($row = $result->fetch_assoc()) {
    $positions[] = $row;
}

// Fetch all contestants with position name
$contestants = [];
$sql = "SELECT c.id, c.name, c.profile_image, p.position_name 
        FROM contestants c 
        LEFT JOIN positions p ON c.position_id = p.id
        ORDER BY c.name ASC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $contestants[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php include 'cdn.php'; ?>
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/auth.css">
</head>
</head>
<body>
        <?php include 'sidebar.php'; ?>
<div class="alls">
    <div class="all_box">
        
<h1>Contestants List</h1>

<div class="filters">
 <div class="forms">
       <label for="positionFilter">Filter by Position:</label>
    <select id="positionFilter">
        <option value="">All Positions</option>
        <?php foreach ($positions as $pos): ?>
            <option value="<?php echo htmlspecialchars($pos['position_name']); ?>">
                <?php echo htmlspecialchars($pos['position_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
 </div>

<div class="forms">
        <label for="searchInput">Search by Name:</label>
    <input type="text" id="searchInput" placeholder="Enter contestant name..." />
</div>
</div>

<table id="contestantsTable">
    <thead>
        <tr>
            <th>#</th>
            <th>Profile Image</th>
            <th>Name</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($contestants) > 0): ?>
            <?php foreach ($contestants as $index => $c): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><img src="<?php echo htmlspecialchars($c['profile_image']); ?>" alt="Profile Image" class="profile-img" style="width: 50px; height:auto;" /></td>
                    <td class="contestant-name"><?php echo htmlspecialchars($c['name']); ?></td>
                    <td class="contestant-position"><?php echo htmlspecialchars($c['position_name']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4">No contestants found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
    </div>
</div>

<script>
    const positionFilter = document.getElementById('positionFilter');
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('contestantsTable');
    const tbody = table.querySelector('tbody');

    function filterTable() {
        const filterPosition = positionFilter.value.toLowerCase();
        const searchTerm = searchInput.value.toLowerCase();

        // Loop through all table rows
        Array.from(tbody.rows).forEach(row => {
            const name = row.querySelector('.contestant-name').textContent.toLowerCase();
            const position = row.querySelector('.contestant-position').textContent.toLowerCase();

            // Check if row matches filter and search
            const matchesPosition = filterPosition === "" || position === filterPosition;
            const matchesSearch = name.includes(searchTerm);

            if (matchesPosition && matchesSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    positionFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('input', filterTable);
</script>

</body>
</html>
