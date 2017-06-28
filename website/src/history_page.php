<html>
    <?php
        require_once("user.php");
        require_once("database.php");
        session_start();
        $user = $_SESSION['logged_user'];

        $database = new Database();
        $database->connect("localhost", "root", "");
        $database->selectDatabase("e_transport");

        $result = $database->query(
          "SELECT transazione.id AS id, transazione.timestamp AS timestamp, transazione.tipo AS tipo, tratta.costo AS costo
            FROM transazione INNER JOIN carta_trasporto INNER JOIN tratta
              ON transazione.numero_carta = carta_trasporto.numero_carta 
              AND transazione.id_tratta = tratta.id
          WHERE carta_trasporto.id_proprietario=".$user->id."
          ORDER BY transazione.timestamp"
        );
        
        if($result->num_rows == 0)
            echo "Nessuna transazione registrata";
        else
            for($i = 0; $i < $result->num_rows; $i++) {
                $data = $result->fetch_assoc();
                echo '<div class="div_info_carta" style="cursor: default;")><table>';
                echo '<tr class="table_numero_carta"><th rowspan="2"><img src="res/transaction.png" id="icona_carta" /></th>
                        <th colspan="3">Transazione N°: '.$data['id'].'</th></tr>';
                echo '<tr class="table_info"><th>Data: '.$data['timestamp'].'</th><th>Quantità: €'.$data['costo'].'</th><th>Tipo: '.$data['tipo'].'</th></tr>';
                echo '</table></div>';
            }

        $database->close();
    ?>
</html>