<html>
  <body>
      <?php
          require_once("database.php");
          session_start();

          $database = new Database();
          $database->connect("localhost", "root", "");
          $database->selectDatabase("e_transport");

          $tratta = $_GET['tratta'];

          $result = $database->query(
            "SELECT * 
              FROM tratta INNER JOIN ".$tratta." 
              ON tratta.id = ".$tratta.".id_tratta"
          );
        
          
          if($tratta == "tratta_urbano") {
              echo '<h1>Tratte urbano</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:50%;">Città</th><th style="width:50%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["citta"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }

          if($tratta == "tratta_extraurbano") {
              echo '<h1>Tratte extraurbano</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:33.33%">Da KM</th><th style="width:33.33%">A KM</th><th style="width:33.33%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["da_km"].'</th><th>'.$data["a_km"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }

          if($tratta == "tratta_treno") {
              echo '<h1>Tratte treno</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:33.33%">Da</th><th style="width:33.33%">A</th><th style="width:33.33%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["da"].'</th><th>'.$data["a"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }

          if($tratta == "tratta_metro") {
              echo '<h1>Tratte metro</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:33.33%">Da zona</th><th style="width:33.33%">A zona</th><th style="width:33.33%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["da_zona"].'</th><th>'.$data["a_zona"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }

          if($tratta == "tratta_tram") {
              echo '<h1>Tratte tram</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:50%">Città</th><th style="width:50%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["citta"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }

          if($tratta == "tratta_traghetto") {
              echo '<h1>Tratte traghetto</h1>';
              echo '<table id="table_tratte">';
              echo '<tr style="background-color: #0070ff;color: white;"><th style="width:33.33%">Da</th style="width:33.33%"><th>A</th><th style="width:33.33%">Costo</th></tr>';
              for($i = 0; $i < $result->num_rows; $i++) {
                  $data = $result->fetch_assoc();
                  echo '<tr><th>'.$data["da"].'</th><th>'.$data["a"].'</th><th>'.$data["costo"].'</th></tr>';
              }
          }
          echo '</table>';

          $database->close();
      ?>
    </div>
  </body>
</html>