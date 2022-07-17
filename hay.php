<?php

function pre($val)
{
  echo "<pre>";
  print_r($val);
  echo "</pre>";
}

$link = $_SERVER['PHP_SELF'];
pre($link);
pre($_SERVER);
pre($_SERVER['REQUEST_URI']);


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>hay</title>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  <a href="<?php echo $link ?>?id=2">
    go to school
  </a>


</body>

</html>