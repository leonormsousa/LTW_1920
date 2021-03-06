<?php
    include_once('database/connection.php');
    include_once('database/habitations.php');

    function generate_random_token() {
        return bin2hex(openssl_random_pseudo_bytes(32));
      }
      session_start();
      session_regenerate_id(true);

      if (!isset($_SESSION['csrf'])) {
        $_SESSION['csrf'] = generate_random_token();
      }
          $logedin=false;
    if (isset($_SESSION['user']))
        $logedin=true;

    
    $action_form = "templates/forms/search_action.php?location=".$_GET['location']."&dateFrom=".$_GET['dateFrom']."&dateTo=".$_GET['dateTo'];
    $displaySearch = true;

    $datetime1 = strtotime($_GET['dateFrom'] . ' 00:00:00');
    $datetime2 = strtotime($_GET['dateTo'] . ' 00:00:00');
    $secs = $datetime2 - $datetime1;// == <seconds between the two times>
    $days = $secs / 86400;

   
    if($secs < 0 || !preg_match ("/^[a-zA-Z\s]+$/", $_GET['location']) || $_SESSION['csrf'] !== $_GET['csrf']) 
        header('Location: ./homepage.php');
    else{
    include_once('templates/common/header.php');

    echo '<h2 class="subtitle">Searched for "'.$_GET['location'].'" between '.$_GET['dateFrom'].' and '.$_GET['dateTo'].'.</h2>';

    echo '<div class="list_properties_options">';
    include_once("templates/common/filter.php");
    echo '</div>';

    if(isset($_GET['types']))
        $type = $_GET['types'];
    else
        $type = "%";

    if(isset($_GET['minNumberGuests']))
        $minNumberGuests = $_GET['minNumberGuests'];
    else
        $minNumberGuests = 1;

    if(isset($_GET['minNumberBedrooms']))
        $minNumberBedrooms = $_GET['minNumberBedrooms'];
    else
        $minNumberBedrooms = 1;

    if(isset($_GET['minPriceNight']))
        $minPriceNight = $_GET['minPriceNight'];
    else
        $minPriceNight = 0;

    if(isset($_GET['maxPriceNight']))
        $maxPriceNight = $_GET['maxPriceNight'];
    else
        $maxPriceNight = 99999;

    $properties = getHabitations($_GET['location'], $type, $minNumberGuests, $minNumberBedrooms, $minPriceNight, $maxPriceNight, $_GET['dateFrom'], $_GET['dateTo'] );

    
        if($properties != null){
            echo '<section class="listPropertiesMap">';
            echo '<aside id="map">';
            include('templates/properties/map.php');
            echo '</aside>';
            echo '<section id="propertiesSection">';
            foreach ($properties as $habitation){
                if(isAvailable($habitation['idHabitacao'], $_GET['dateFrom'],$_GET['dateTo']))
                    include("templates/properties/viewSearchProperty.php");
            }
            echo '</section>';
            echo '</section>';
        }
        else {
            echo '<h4 id="no_results"> No results found </h4>';
        }
       
        include_once('templates/common/footer.php');      
    }
  
?>