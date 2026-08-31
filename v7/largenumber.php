<!DOCTYPE html>
<html lang="en">
<?php include "conf.php"; ?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Muhammad Rafi Arsya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="main.css?dev=<?php echo $version; ?>" />
    <link rel="icon" type="image/png" href="icon/rafi-ico.png">
    <script src="icon.js?dev=<?php echo $version; ?>"></script>
</head>

<body>
    <div class="row" style="position: relative">
        <?php
        $page = "largenumber";
        include('sidebar.php');
        ?>
        <div class="col">
            <div class="main-content" id="main-content">
                <?php include(__DIR__ . '/content/projects/largenumber.php'); ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="main.js?dev=<?php echo $version; ?>"></script>
</body>

</html>
