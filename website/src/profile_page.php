<html>
  <?php
    require_once("user.php");
    require_once("database.php");
    session_start();
    $user = $_SESSION['logged_user'];
  ?>

  <div class="div_op_carta" style='text-align:center'>
        <h3>Modifica profilo</h3>
          <form action='src/aggiorna_utente.php' method='POST'>
            Email: <br>
            <input type="email" name="email" maxlength="254" placeholder="" value=<?php echo'"'.$user->email.'"'; ?> required /> <br>
            Password: <br>
            <input type="password" name="password" maxlength="32" pattern="[a-zA-Z0-9]{1, 25}" title="Può contenere solo caratteri alfanumerici e max 32 caratteri" placeholder="" value=<?php echo'"'.$user->password.'"'; ?> required /> <br>
            Nome: <br>
            <input type="text" name="nome" maxlength="25" placeholder="" value=<?php echo'"'.$user->nome.'"'; ?> required /> <br>
            Cognome: <br>
            <input type="text" name="cognome" maxlength="25" placeholder="" value=<?php echo'"'.$user->cognome.'"'; ?> required /> <br>
            Numero documento: <br>
            <input type="text" name="numero_documento" pattern="[a-zA-Z0-9]{9}" title="Può contenere solo caratteri alfanumerici e deve essere di 9 caratteri" maxlength="9" placeholder="" value=<?php echo'"'.$user->numero_documento.'"'; ?> required /> <br>
            Via: <br>
            <input type="text" name="via"  maxlength="25" pattern="[a-zA-Z0-9 ]{1, 25}" title="Può contenere solo caratteri alfanumerici e max 25 caratteri" placeholder="" value=<?php echo'"'.$user->via.'"'; ?> required /> <br>
            Provincia: <br>
            <input type="text" name="provincia" maxlength="25" pattern="[0-9 ]{1, 25}" title="Può contenere solo caratteri alfabetici e max 25 caratteri" placeholder="" value=<?php echo'"'.$user->provincia.'"'; ?> required /> <br>
            Citta: <br>
            <input type="text" name="citta" maxlength="25" pattern="[0-9 ]{1, 25}" title="Può contenere solo caratteri alfabetici e max 25 caratteri" placeholder="" value=<?php echo'"'.$user->citta.'"'; ?> required /> <br>
            Cap: <br>
            <input type="text" name="cap" maxlength="5" pattern="[0-9]{5}" title="Può contenere solo caratteri numerici e deve essere di 5 cifre" placeholder="" value=<?php echo'"'.$user->cap.'"'; ?> required /> <br>
            <input type="submit" name="submit" value="Aggiorna" /> <br>
        </form>
  </div>

  <div class="div_op_carta">
    <table>
        <tr><th><h3>Elimina account</h3></th></tr>
        <tr><th><?php
          echo '<input type="button" value="Rimuovi" onclick=rimuovi_account("'.$user->id.'")>';
        ?></th></tr>
    </table>
  </div>
</html>