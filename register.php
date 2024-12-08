<?php
require_once 'core/dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect and sanitize user input
  $username = htmlspecialchars($_POST['username']);
  $first_name = htmlspecialchars($_POST['first_name']);
  $last_name = htmlspecialchars($_POST['last_name']);
  $email = htmlspecialchars($_POST['email']);
  $password = htmlspecialchars($_POST['password']);
  $confirm_password = htmlspecialchars($_POST['confirm_password']);

  // Check if passwords match
  if ($password !== $confirm_password) {
    $error = "Passwords do not match.";
  } else {
    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the new user
    $query = "INSERT INTO user (username, first_name, last_name, email, password) 
                  VALUES (:username, :first_name, :last_name, :email, :password)";
    $stmt = $pdo->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
      header("Location: login.php"); // Redirect to login page after successful registration
      exit();
    } else {
      $error = "Error: Could not register user.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] w-full">
      <form action="register.php" method="POST" class="space-y-4">
        <div class="mb-8">
          <h3 class="text-gray-800 text-3xl font-extrabold text-center">Register</h3>
        </div>
        <?php if (isset($error)) {
          echo "<p class='text-red-600'>$error</p>";
        } ?>
        <div>
          <label for="username" class="text-gray-800 text-sm mb-2 block">Username</label>
          <input type="text" name="username" id="username" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Enter username">
        </div>
        <div>
          <label for="first_name" class="text-gray-800 text-sm mb-2 block">First Name</label>
          <input type="text" name="first_name" id="first_name" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Enter first name">
        </div>
        <div>
          <label for="last_name" class="text-gray-800 text-sm mb-2 block">Last Name</label>
          <input type="text" name="last_name" id="last_name" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Enter last name">
        </div>
        <div>
          <label for="email" class="text-gray-800 text-sm mb-2 block">Email</label>
          <input type="email" name="email" id="email" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Enter email">
        </div>
        <div>
          <label for="password" class="text-gray-800 text-sm mb-2 block">Password</label>
          <input type="password" name="password" id="password" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Enter password">
        </div>
        <div>
          <label for="confirm_password" class="text-gray-800 text-sm mb-2 block">Confirm Password</label>
          <input type="password" name="confirm_password" id="confirm_password" required
            class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
            placeholder="Confirm password">
        </div>
        <div class="!mt-8">
          <button type="submit"
            class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
            Register
          </button>
        </div>
        <p class="text-sm !mt-8 text-center text-gray-800">
          Already have an account?
          <a href="login.php" class="text-blue-600 font-semibold hover:underline ml-1">Login here</a>
        </p>
      </form>
    </div>
  </div>
</body>

</html>