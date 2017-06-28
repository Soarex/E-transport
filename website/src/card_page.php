<html>
  <?php
    require_once("user.php");
    require_once("database.php");
    session_start();
    $numero_carta = $_POST['carta'];
    $saldo = $_POST['saldo'];
    $user = $_SESSION['logged_user'];
    echo 'Carta: '.chunk_split($numero_carta, 4, " ");

    $database = new Database();
    $database->connect("localhost", "root", "");
    $database->selectDatabase("e_transport");

    $result = $database->query(
        "SELECT * 
        FROM carta_trasporto 
        WHERE id_proprietario=".$user->id
    );

    $result_pagamento = $database->query(
        "SELECT * 
        FROM metodo_pagamento 
        WHERE id_cliente=".$user->id
    );
          
    $database->close();
  ?>

  <div class="div_op_carta">
    <table>
        <tr><th colspan="3"><h3>Ricarica carta</h3></th></tr>
        <tr><th>Quantità: <input type="number" id="quantita_ricarica" step=".01" required></th>
        <th>Fonte: <select id="metodo_pagamento_ricarica">
          <?php
            if($result_pagamento->num_rows == 0)
                echo "<option>Nessun metodo registrato</option>";
            else
                for($i = 0; $i < $result_pagamento->num_rows; $i++) {
                    $data = $result_pagamento->fetch_assoc();
                    echo '<option>'.chunk_split($data['numero_carta'], 4, " ").'</option>';
                }
          ?>
          </select></th><th><?php
            echo '<input type="button" value="Ricarica" onclick=carica_denaro("'.str_replace(" ", "", $numero_carta).'")>';
          ?></th></tr>
    </table>
  </div>

  <div class="div_op_carta">
    <table>
        <tr><th colspan="3"><h3>Trasferimento</h3></th></tr>
        <tr><th>Quantità: <input type="number" id="quantita" step=".01" required></th>
        <th>Destinazione: <select id="carta_destinazione">
          <?php
            if($result->num_rows == 1)
                echo "<option>Nessuna carta disponibile</option>";
            else
                for($i = 0; $i < $result->num_rows; $i++) {
                    $data = $result->fetch_assoc();
                    if($data['numero_carta'] != $numero_carta)
                        echo '<option>'.chunk_split($data['numero_carta'], 4, " ").'</option>';
                }
          ?>
          </select></th><th><?php
            echo '<input type="button" value="Trasferisci" onclick=trasferisci_denaro("'.str_replace(" ", "", $numero_carta).'",'.$saldo.')>';
          ?></th></tr>
    </table>
  </div>

  <div class="div_op_carta">
    <table>
        <tr><th><h3>Rimuovi carta</h3></th></tr>
        <tr><th><?php
          echo '<input type="button" value="Rimuovi" onclick=rimuovi_carta("'.$numero_carta.'")>';
        ?></th></tr>
    </table>
  </div>
</html>