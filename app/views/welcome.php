<?php
    $version = $this->v('framework_version');
    $framework = $this->framework;
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    <meta name="robots" content="noindex">

    <title><?php SITENAME ?></title>

</head>
<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<h1>Welcome</h1>

<p><?php echo $framework ?></p>
<p>Author: <?php $this->e('framework_author') ?></p>
<p>Version: <?php echo $version ?></p>

</body>
</html>
