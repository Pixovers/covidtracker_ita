<?php
$regions = [	
"Abruzzo",
"Basilicata",
"Calabria",
"Campania",
"Emilia-Romagna",
"Friuli-Venezia Giulia",
"Lazio",
"Liguria",
"Lombardia",
"Marche",
"Molise",
"Piemonte",
"Puglia",
"Sardegna",
"Sicilia",
"Toscana",
"Trentino-Alto Adige",
"Umbria",
"Valle d'Aosta",
"Veneto"];

?>


<nav class="navbar navbar-expand-lg navbar-light  dark_mode_object shadow">
  <a class="navbar-brand text-white" href="#"> <p class="h4 ml-1 textWhite font-weight-bold">
                    <span class="text-success">COVID</span>
                    <span class="dark_mode_div">TRACKER2020</span>
                    <span class="text-danger">.LIVE</span>
                    <span class="dark_mode_div"><i class="fas fa-shield-virus"></i></span>

                </p></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link text-white font-weight-bold" href="https://it.covidtracker2020.live/">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white font-weight-bold" href="#">Map</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white font-weight-bold" href="#">Live</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white font-weight-bold" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Regioni
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         
        <?php 
        foreach($regions as $region){
        ?>

        <a class="dropdown-item" href="#"> <?php echo $region ?></a>
         <?php
         }
         ?>
        </div>
      </li>
    </ul>
  </div>
 
  <input class="dm_switch" data-on="Light Mode" data-off="Dark Mode" onchange="toggleDarkMode()" type="checkbox" id="dark_mode_switch" name="theme">
        <label class="dm_switch mr-4 mt-2 " for="dark_mode_switch" onchange="toggleDarkMode()" class="mr-4 mt-2 ml-1">Toggle</label>

  <form class="form-inline">
  <script type='text/javascript' src='https://ko-fi.com/widgets/widget_2.js'></script>
        <script type='text/javascript'>
            kofiwidget2.init('Supportaci', '#20e648', 'S6S41Y4BV');
            kofiwidget2.draw();
        </script>   
  </form>
</nav>

<style>
            input[type=checkbox].dm_switch {
                height: 0;
                width: 0;
                visibility: hidden;
            }

            label.dm_switch {
                cursor: pointer;
                text-indent: -9999px;
                width: 52px;
                height: 27px;
                background: grey;
                float: right;
                border-radius: 100px;
                position: relative;
            }

            label.dm_switch:after {
                content: '';
                position: absolute;
                top: 3px;
                left: 3px;
                width: 20px;
                height: 20px;
                background: #fff;
                border-radius: 90px;
                transition: 0.3s;
            }

            input.dm_switch:checked+label.dm_switch {
                background: var(--color-headings);
            }

            input.dm_switch:checked+label.dm_switch:after {
                left: calc(100% - 5px);
                transform: translateX(-100%);
            }

            label.dm_switch:active:after {
                width: 45px;
            }

            html.transition,
            html.transition *,
            html.transition *:before,
            html.transition *:after {
                transition: all 750ms !important;
                transition-delay: 0 !important;
            }
        </style>