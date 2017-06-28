<html>
  <body>
    <div id="user_info">
      <table>
        <?php
            require_once("user.php");
            require_once("database.php");
            session_start();
            
            $user = $_SESSION["logged_user"];
            echo '<tr id="table_username"><th colspan=2>'.$user->nome.' '.$user->cognome.'</th></tr>';
            echo '<tr id="table_email"><th colspan="2">'.$user->email.'</th></tr>';
            echo '<tr><th colspan="1"><input type="button" value="Profilo" onclick="profilo()" /></th><th colspan="1"><input type="button" value="Cronologia" onclick="cronologia()" /></th></tr>';
            echo '<tr><th colspan="1"><input type="button" value="Metodi di pagamento" onclick="metodi()" /></th><th colspan="1"><input type="button" value="Carte" onclick="load_user()" /></th></tr>';
            echo '<tr><th colspan="2"><input type="button" value="Log out" onclick="logout()" /></th></tr>';
        ?>
      </table>
    </div>
    <div id="card_info">
      <form id="add_card_form" action="src/add_card.php" method="POST">
        <input type="text" pattern="[0-9]{16,16}" title="Può contenere solo caratteri numerici e deve essere di 16 cifre" name="numero_carta" placeholder="Numero carta" required />
        <input type="submit" value="Aggiungi" />
      </form>
      <?php
          $database = new Database();
          $database->connect("localhost", "root", "");
          $database->selectDatabase("e_transport");

          $result = $database->query(
            "SELECT * 
              FROM carta_trasporto 
              WHERE id_proprietario=".$user->id
          );
          
          if($result->num_rows == 0)
              echo "Nessuna carta registrata";
          else
              for($i = 0; $i < $result->num_rows; $i++) {
                $data = $result->fetch_assoc();
                echo '<div class="div_info_carta" onclick=card_page("'.$data['numero_carta'].'",'.$data['saldo'].')><table>';
                echo '<tr class="table_numero_carta"><th rowspan="2"><img src="res/card.png" id="icona_carta" /></th>
                        <th colspan="2">Carta N°: '.chunk_split($data['numero_carta'], 4, " ").'</th></tr>';
                echo '<tr class="table_info"><th>Saldo: €'.$data['saldo'].'</th><th>Rilasciata il: '.$data['data_rilascio'].'</th></tr>';
                echo '</table></div>';
              }

          $database->close();
      ?>
    </div>
  </body>
</html>