<?php
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/config.php";
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/API.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo $paraFile->displayHead("Accueil");
echo $paraFile->displayHeader(false, false);
?>


<form action="" method="post" name="reservation" class="formReservation" id="formReservation">
    <h2>Demande de réservation</h2>
    <div class="elmtformulaire">
        <label for="nom">Nom :</label>
        <input id="nom" type="text" name="nom">
    </div>
    <div class="elmtformulaire">
    <label for="room">Salle :</label>
        <select id="room" name="room" required>
        <option value="selection">Sélectionnez une salle</option>
            <?php
            $api = new API();

            $data = [
                'action' => 'select',
                'table' => 'room'
            ];

            $response = $api->dataVerification($data);

            if($response['state']){
                foreach ($response['data'] as $item){
                    var_dump($item);
                    echo '<option value="'.$item['room_name'] .'">'.$item['room_name'] .'</option>';
                }
            }
            ?>
    </select>
    </div>
    <div class="elmtformulaire">
    <label for="datedebut">Date de début</label>
    <input type="date" id="datedebut" name="datedebut" required>
    </div>
    <div class="elmtformulaire">
        <label for="datefin">Date de fin</label>
        <input type="date" id="datefin" name="datefin" required>
    </div>
    <div class="elmtformulaire">
        <input type="submit" value="Envoyer" id="boutonsubmit">
    </div>
</form>