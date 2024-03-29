<?php
  $weather = "";
  $error = "";
if (array_key_exists('city', $_GET)){
    $city = str_replace(' ', '', $_GET['city']);
    $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $error = "That city could not be found!";
  } else {
    $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
      $pageArray = explode('(1&ndash;3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
      if (sizeof ($pageArray) > 1) {
      $secondPageArray = explode('</span></p></td><td class="b-forecast__table-description-cell--js" colspan="9">', $pageArray[1]);
       if (sizeof ($secondPageArray) > 1) {
         $weather = $secondPageArray;
       } else {
         $error = "That city could not be found!";
       }
      $weather = $secondPageArray[0];
    } else {
      $error = "That city could not be found!";
    }
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Weather Scraper</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
      html {
        background: url(background.jpeg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        }
        body{
          background: none;
        }
        .container{
          text-align: center;
          margin-top: 100px;
          width: 450px;
        }
        #heading{
          padding: 20px;
          background: #d6e6fc;
          border-radius: 25px;
          border: 2px solid black;
        }
        input{
          margin: 20px 0px;
        }
        #weather{
          margin-top: 15px;
        }
        #format{
          color: white;
          font-weight: bolder;
          font-size: 20px;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <h1 id="heading">What's the Weather?</h1>

    <form>
  <div class="form-group">
    <label for="city" id="format">Enter the name of a city</label>
    <input type="text" class="form-control" name="city" id="city" placeholder="E.g. London, Tokyo" value="<?php

    if (array_key_exists('city', $_GET)){
      echo $_GET['city'];
    } ?>">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<div id="weather">
  <?php
  if ($weather){
    echo '<div class="alert alert-warning" role="alert">
  '.$weather.'</div>';
  }
  else if ($error){
    echo '<div class="alert alert-danger" role="alert">
  '.$error.'</div>';
  }

  ?>
</div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
