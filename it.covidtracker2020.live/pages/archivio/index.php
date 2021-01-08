<!DOCTYPE html>

<?php
include '/home/covid/it.resources/config.php';
include '/home/covid/it.resources/classes/info_card.php';
include_once "/home/covid/it.resources/classes/sanitizer.php";

?>
<html lang="it">

<head>


<?php include "/home/covid/resources/templates/head.php"; ?>




  <link rel="stylesheet" type="text/css" href="css/fade.css">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel='manifest' href='/manifest.json'>
  <link rel='apple-touch-icon' href='https://it.covidtracker2020.live/pwa/img/150x150.png'>
  <meta name="theme-color" content="#009578">

 


</head>


<body>
  <style>
    @keyframes transition {

      from {
        opacity: 0;
        transform: rotateX(-10deg);

      }

      to {
        opacity: 3;
        transform: rotateX(0);

      }

    }

    .container-fluid {
      animation: transition 0.75s;

    }

    .form-control {
    display: block;
    width: 70%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #e0cc39;
    background-color: #32383e;
    background-clip: padding-box;
    border: 1px solid #3079c1;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;

    
}
.btn-secondary {
    color: #fff;
    background-color: #00549e;
    border-color: #00498a;
}
  </style>

  <?php
  include '/home/covid/it.resources/templates/navbar.php';
  ?>

  <div class="container-fluid">
    <div class="row mt-2">
      <?php
      $cards = new InfoCard("Italia", $DATE);
      $cards->GenerateCode();
      $cards->GenerateModals();


      /*
        6 mesi + oggi
        

      */
      ?>

      <?php

      $counters = array();

      foreach ($regions as $region) {
      ?>
        <div class="col-md-12 col-xl-6  py-2">
          <div class="card text-white dark_mode_object shadow-lg h-100 zoom">
            <div class="card-header card-header d-flex flex-row align-items-center justify-content-between py-2">
              <h5 class="m-0 font-weight-bold text-primary text-truncate"><?php echo $region ?></h5>

              <div class="">

                <button type="button" class="btn btn-success btn-sm py-0" data-toggle="tooltip" data-placement="bottom" title="Tabella delle regioni d'Italia">
                  <i class="fas fa-info fa-sm"></i></button>
              </div>

            </div>
            <div class="card-body">


              <table class="table table-striped " data-toggle="table" data-height="300" data-detail-view="true" data-detail-view-icon="false" data-detail-formatter="detailFormatter" data-header-style="headerStyle" data-show-export="true" id="table" data-click-to-select="true" data-show-toggle="true" sdata-show-columns="true" data-footer-style="footerStyle" data-mobile-responsive="true" data-search="true" data-search-align="left" data-sort-class="table-active" data-show-print="true" data-url="https://it.covidtracker2020.live/table_json_data.php?tipo=div&data=2020-10-25&location=<?php echo Sanitizer::encode_url_name($region); ?>">



                <thead class="thead dark_mode_object">
                  <tr>


                    <th data-field="provincia" scope="col" data-sortable="true">PROVINCIA</th>
                    <th data-field="Casi_Totali" scope="col" data-sortable="true">CASI TOTALI</th>
                    <th data-field="sigla" scope="col" data-sortable="true">SIGLA</th>





                  </tr>

                </thead>


              </table>

            </div>
          </div>
        </div>

      <?php
      }
      ?>

    </div>
  </div>



  <script>
    $(function() {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  <?php
  include '/home/covid/resources/templates/footer.php';
  include '/home/covid/resources/templates/cookie-popup.php';
  ?>
  <?php


  $cards->GenerateCharts();


  ?>




  <script>
    var $table = $('#table')

    $(function() {
      $('#toolbar').find('select').change(function() {
        $table.bootstrapTable('destroy').bootstrapTable({
          exportDataType: $(this).val(),
          exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],

        })
      }).trigger('change')
    })
  </script>



</body>

</html>