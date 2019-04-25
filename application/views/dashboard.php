<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url();?>template/node_modules/bootstrap/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo base_url();?>template/css/style.css">

    <title>Omba Research Center - KPU Real Count</title>
  </head>
<body>
  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">ORS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo base_url();?>">Alternative Dashboard Real Count KPU</a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

<main role="main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12" id="chart">
      </div>
      <div class="col-12" id="suara">
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <!-- <footer class="container">
    <p class="float-right"><a href="#">Kembali ke atas</a></p>
    <p>© 2019 ORS, Inc.
  </footer> -->
</main>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?php echo base_url();?>template/node_modules/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url();?>template/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    function get_suara (prov='',kab='',kec='',kel='',tps='') {
      $("#suara").html('Loading data..');
      $.ajax({
        url:  "<?php echo base_url();?>dashboard/get_suara",
        type: 'POST',
        data: 'prov='+ prov + '&kab=' + kab + '&kec=' + kec + '&kel=' + kel + '&tps=' + tps,
        success: function(html){
          $("#suara").html(html);
        },
        error: function() {
          $("#suara").html('Loading gagal, Silahkan coba lagi..');
        }
      });
    }
    get_suara();
  </script>
</body>
</html>