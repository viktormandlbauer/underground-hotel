<?php
include 'src/views/includes/header.php';
include 'src/views/includes/navbar.php';
?>

<title>Admin Dashboard</title>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="/admin/manage/users">Manage Users</a></li>
                <li><a href="/admin/manage/bookings">Manage Bookings</a></li>
                <li><a href="/admin/manage/rooms">Mange Rooms</a></li>
                <li><a href="/admin/manage/news">Manage News</a></li>
            </ul>
        </nav>
    </header>
</body>

</html>

<?php include 'src/views/includes/footer.php'; ?>