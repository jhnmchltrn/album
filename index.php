<?php
require_once 'core/dbConfig.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login page if not logged in
  header("Location: login.php");
  exit();
}

// Query to get all the photos from the database
$query = "SELECT * FROM photos";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Fetch the result
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
</head>

<body>
  <?php include 'navbar.php'; ?>
  <div class="container mx-auto p-8">
    <h1 <?php echo empty($result) ? 'text-center' : ''; ?>">
      <?php if (empty($result)) {
        echo '<h1 class="text-3xl font-bold mb-6 text-center">No photos uploaded, be the first one!</h1>';
      } else {
        echo '<h1 class="text-3xl font-bold mb-6">Uploaded Photos</h1>';
      } ?>
    </h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($result as $row) { ?>
        <div class="bg-white rounded-lg shadow-lg p-4">
          <img src="uploads/<?php echo htmlspecialchars($row['photo_name']); ?>" alt="Photo"
            class="w-full h-48 object-cover rounded-md mb-4">
          <div class="flex justify-between items-center">
            <div class="flex-1">
              <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($row['title']); ?></h3>
              <p class="text-gray-600"><?php echo htmlspecialchars($row['description']); ?></p>
              <div class="flex space-x-4 justify-end">
                <!-- Edit Button -->
                <a href="editMoment.php?id=<?php echo $row['photo_id']; ?>"
                  class="text-blue-500 hover:text-blue-700">Edit</a>
                <!-- Delete Button -->
                <a href="deleteMoment.php?id=<?php echo $row['photo_id']; ?>"
                  class="text-red-500 hover:text-red-700">Delete</a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</body>

</html>