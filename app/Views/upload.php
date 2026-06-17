<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Formulaire d'upload</h1>
    <form action="<?= site_url('import/upload') ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file">
        <button type="submit">
            Importer
        </button>
    </form>
</body>

</html>