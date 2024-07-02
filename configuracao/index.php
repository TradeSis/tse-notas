<?php
//Lucas 17102023 novo padrao
include_once(__DIR__ . '/../header.php');
?>
<!doctype html>
<html lang="pt-BR">

<head>

    <?php include_once ROOT . "/vendor/head_css.php"; ?>

</head>

<body>

<div class="container-fluid">
  <div class="row pt-4" >
    <div class="col-md-2 ">
      <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
        <?php
        $stab = 'parametros';
        if (isset($_GET['stab'])) {
          $stab = $_GET['stab'];
        }
        //echo "<HR>stab=" . $stab;
        ?>
        <li class="nav-item ">
          <a class="nav-link ts-tabConfig <?php if ($stab == "parametros") {
            echo " active ";
          } ?>"
            href="?tab=configuracao&stab=parametros" role="tab" >Parametros</a>
        </li>

      </ul>
    </div>
    <div class="col-md-10">
      <?php
          $ssrc = "";

          if ($stab == "parametros") {
            $ssrc = "parametros.php";
          }

          if ($ssrc !== "") {
            //echo $ssrc;
            include($ssrc);
          }

      ?>

    </div>
  </div>

</div>

  <!-- LOCAL PARA COLOCAR OS JS -->

  <?php include_once ROOT . "/vendor/footer_js.php"; ?>

  <!-- LOCAL PARA COLOCAR OS JS -FIM -->
</body>

</html>