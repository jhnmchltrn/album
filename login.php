<?php
require_once 'core/dbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect and sanitize user input
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  // Prepare the SQL query to check the user credentials
  $query = "SELECT * FROM user WHERE username = :username";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':username', $username);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password'])) {
    // If password is correct, start the session and redirect
    session_start();
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['username'] = $user['username'];
    header("Location: index.php"); // Redirect to dashboard
    exit();
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
  <div class="flex items-center justify-center min-h-screen px-4">
    <div class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] w-full">
      <form method="POST" class="space-y-4">
        <div class="mb-8">
          <h3 class="text-gray-800 text-3xl font-extrabold text-center">Sign in</h3>
        </div>
        <div>
          <label for="username" class="text-gray-800 text-sm mb-2 block">Username</label>
          <div class="relative flex items-center">
            <input id="username" name="username" type="text" required
              class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
              placeholder="Enter user name" />
          </div>
        </div>
        <div>
          <label for="password" class="text-gray-800 text-sm mb-2 block">Password</label>
          <div class="relative flex items-center">
            <input id="password" name="password" type="password" required
              class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
              placeholder="Enter password" />
          </div>
        </div>
        <div class="!mt-8">
          <button type="submit"
            class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
            Log in
          </button>
        </div>
        <p class="text-sm !mt-8 text-center text-gray-800">
          Don't have an account?
          <a href="register.php" class="text-blue-600 font-semibold hover:underline ml-1">Register here</a>
        </p>
      </form>
    </div>
  </div>
</body>

</html>