<?php
    namespace Src\Register;
    session_start();

    use PDO, PDOException;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $email == "admin@gmail.com" ? "Admin" : "Student";
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Check if the email already exists
        $stmt = $pdo->prepare('SELECT * FROM `user` WHERE email = ?');
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch();
        if ($existingUser) {
            header("Location: register.php");
            $error = "authentication failed";
        } else {
            // Insert the new user
            $stmt = $pdo->prepare('INSERT INTO `user` (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$firstName, $lastName, $email, $password, $role]);
            header("Location: login.php");
        }
    } catch (PDOException $e) {
      header("Location: ../error/database-connection-failed.php");
      exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200&family=Nunito:wght@300;400&family=Open+Sans&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="..\images\favicon.jpg">
    <title>Greenwich Student Forum</title>
  </head>
  <body class="bg-gray-100">
      <div
        class="flex flex-col items-center px-6 py-8 mx-auto md:h-screen"
      >
        <div
          class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md"
        >
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <img class="h-32 ml-16" src="https://upload.wikimedia.org/wikipedia/vi/b/bf/Official_logo_of_Greenwich_Vietnam.png" alt="logo">

            <h1
              class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl"
            >
              Create an account
            </h1>
            <form
              onsubmit="return validateForm()"
              class="space-y-4 md:space-y-6"
              action="register.php"
              method="post"
            >
              <div>
                <label
                  for="firstName"
                  class="block mb-2 text-sm font-medium text-gray-900"
                  >Firstname</label
                >
                <input
                  type="text"
                  name="firstName"
                  id="firstName"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  placeholder="Johny"
                  required=""
                />
              </div>
              <div>
                <label
                  for="lastName"
                  class="block mb-2 text-sm font-medium text-gray-900"
                  >Lastname</label
                >
                <input
                  type="text"
                  name="lastName"
                  id="lastName"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  placeholder="Sin"
                  required=""
                />
              </div>
              <div>
                <label
                  for="email"
                  class="block mb-2 text-sm font-medium text-gray-900"
                  >Your email</label
                >
                <input
                  type="email"
                  name="email"
                  id="email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  placeholder="name@company.com"
                  required=""
                />
              </div>
              <div>
                <label
                  for="password"
                  class="block mb-2 text-sm font-medium text-gray-900"
                  >Password</label
                >
                <input
                  type="password"
                  name="password"
                  id="password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  required=""
                />
              </div>
              <div>
                <label
                  for="confirm-password"
                  class="block mb-2 text-sm font-medium text-gray-900"
                  >Confirm password</label
                >
                <input
                  type="password"
                  name="confirm-password"
                  id="confirm-password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  required=""
                />
              </div>
              <div>
                <p id="check-matching-errors" class="text-red-300"></p>
                <?php echo isset($error) ? '<p class="text-sm font-lg text-red-700">authentication failed</p>' : ""?>

              </div>
              <button
                id="submit-button"
                type="submit"
                class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
              >
                Create an account
              </button>
              <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                Already have an account?
                <a
                  href="login.php"
                  class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                  >Login here</a
                >
              </p>
            </form>
          </div>
        </div>
      </div>
    <script>
      function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirm-password").value;
        if (password != confirmPassword) {
          document.getElementById("check-matching-errors").innerText =
            "Passwords do not match!";
          return false; // Prevent form submission
        } 
        if (password.length < 8) {
            document.getElementById("check-matching-errors").innerText =
              "Password must be at least 8 characters";
            return false;
          
        }
        document.getElementById("check-matching-errors").innerText = "";
        return true;
      }
    </script>
  </body>
</html>
