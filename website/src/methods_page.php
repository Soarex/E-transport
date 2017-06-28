<html>
    <form id="add_method_form" action="src/add_credit_card.php" method="POST">
      <table>
        <tr>
          <th><input type="text" pattern="[0-9]{16,16}" title="Può contenere solo caratteri numerici e deve essere di 16 cifre" name="numero_carta" placeholder="Numero carta" required /></th>
          <th><select name="tipo"><option>mastercard</option><option>visa</option><option>maestro</option><option>american_express</option><option>postepay</option></select></th>
          <th><input type="text" pattern="[a-zA-Z ]{0,25}" title="Può contenere solo caratteri alfabetici" name="nome_titolare" placeholder="Nome titolare" required /></th>
          <th style='width:12.5%'><input type="number" pattern="[0-9]{1, 2}" title="Può contenere solo caratteri numerici e deve essere di 1 o 2 cifre" name="mese_scadenza" placeholder="Mese scadenza" required /></th>
          <th style='width:12.5%'><input type="number" pattern="[0-9]{1, 2}" title="Può contenere solo caratteri numerici e deve essere di 1 o 2 cifre" name="anno_scadenza" placeholder="Anno scadenza" required /></th>
        </tr>
        <tr>
          <th><input type="text" pattern="[a-zA-Z0-9 ]{0,25}" title="Può contenere solo caratteri alfabetici" name="via" placeholder="Via" required /></th>
          <th><input type="text" pattern="[a-zA-Z ]{0,25}" title="Può contenere solo caratteri alfabetici" name="provincia" placeholder="Provincia" required /></th>
          <th><input type="text" pattern="[a-zA-Z ]{0,25}" title="Può contenere solo caratteri alfabetici" name="citta" placeholder="Città" required /></th>
          <th colspan=2><input type="text" pattern="[0-9]{5}" title="Può contenere solo caratteri numerici e deve essere di 5 cifre" name="CAP" placeholder="CAP" required /></th>
        </tr>
        <tr><th colspan=4><input type="submit" value="Aggiungi" /></th></tr>
      </table>
    </form>
    <?php
        require_once("user.php");
        require_once("database.php");
        session_start();
        $user = $_SESSION['logged_user'];

        $database = new Database();
        $database->connect("localhost", "root", "");
        $database->selectDatabase("e_transport");

        $result = $database->query(
          "SELECT * 
            FROM metodo_pagamento 
          WHERE id_cliente=".$user->id
        );
          
        if($result->num_rows == 0)
            echo "Nessun metodo di pagamento registrato";
        else
            for($i = 0; $i < $result->num_rows; $i++) {
                $data = $result->fetch_assoc();
                $data_scadenza = explode("-", $data['data_scadenza']);
                $anno = str_split($data_scadenza[0], 2)[1];
                $mese = $data_scadenza[1];
                $numero_carta = str_split($data['numero_carta'], 4)[0].' **** **** ****';
                echo '<div class="div_info_carta" onclick=method_info('.$data['id'].')><table>';
                echo '<tr><th rowspan="2"><img src="res/credit_card.png" id="icona_carta" /></th>
                        <th colspan="3" class="table_numero_carta">N° Carta: '.$numero_carta.'</th></tr>';
                echo '<tr class="table_info"><th>Tipo: '.$data['tipo_carta'].'</th><th>Titolare: '.$data['nome_titolare'].'</th><th>Scadenza: '.$mese.'/'.$anno.'</th></tr>';
                echo '</table></div>';
            }

        $database->close();
    ?>
</html>