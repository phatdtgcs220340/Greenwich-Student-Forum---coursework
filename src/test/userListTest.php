<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

use function Src\User\userList;

    require_once("../main/profile/user-list.php");
    foreach(userList() as $user) {
        echo '<h1>'.$user['email'].'</h1>';
    }
    ?>
</body>
</html>