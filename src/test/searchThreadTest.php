<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        require_once("../main/Thread/thread-list.php");

        use function Src\Thread\threadListAll;
        use function Src\Thread\threadStartWith;
        foreach (threadStartWith()["thread_list"] as $node) {
            echo $node['title'];
        }
    ?>
</body>
</html>