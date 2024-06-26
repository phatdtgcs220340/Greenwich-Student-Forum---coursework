<?php
session_start();
// if already login then redirect to the home page
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=cw-student-forum-db', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('SELECT * FROM `user` WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if (!$user['is_enabled']) {
                header("Location: ../error/global-ban.php");
                exit;
            }
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['image'] = $user['image'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: ../index.php');
            exit;
        } else {
            $error = "authentication failed";
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200&family=Nunito:wght@300;400&family=Open+Sans&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="../../resource/static/images/favicon.jpg">
    <title>Greenwich Student Forum</title>
</head>

<body class="bg-gray-100">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <img class="h-32 ml-16" src="https://upload.wikimedia.org/wikipedia/vi/b/bf/Official_logo_of_Greenwich_Vietnam.png" alt="logo">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Sign in to your account
                </h1>
                <form class="space-y-4 md:space-y-6" action="login.php" method="post">
                    <div>
                        <label for="email" 
                        class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                        <input type="email" name="email" id="email" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none block w-full p-2.5" 
                        placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none block w-full p-2.5"
                        required="">
                    </div>
                    <?php echo isset($error) ? '<p class="text-sm font-lg text-red-700">authentication failed</p>' : ""?>
                    <button type="submit" 
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Login</button>
                    <p class="text-sm font-light text-gray-500">
                        Don’t have an account yet? <a href="register.php" 
                        class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>