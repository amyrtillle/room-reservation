<?php
require $_SERVER["DOCUMENT_ROOT"] . "/RESSOURCES/ACTIONS/config.php";
echo $paraFile->displayHead("Panneau d'administration");
echo $paraFile->displayHeader($isAdmin, $isConnected);
require $_SERVER['DOCUMENT_ROOT'] . '/RESSOURCES/ACTIONS/API.php';
?>
<main>
    <link rel="stylesheet" href="../CSS/gestion.css">
    <link rel="stylesheet" href="../CSS/gestion-admin.css">
    <ul id="nav">
        <li class="" id="btnManager">Réserver</li>
        <li class="active" id="btnRequest">Gestion</li>
        <li class="" id="btnSupport">Support</li>
    </ul>
    <div id='booking' class="container">
        <div id="formReservation">
            <div id="form-container">
                <form action="" method="post" name="reservation" class="formReservation" id="form">
                    <h2>Réserver une salle</h2>
                    <div class="formElement">
                        <label for="nom">Nom : <span class="infoLabel">(non modifiable)</span></label>
                        <input id="nom" type="text" name="nom"
                            value="' . strtoupper($_SESSION['name']) . ' ' . $_SESSION['fname'] . '" disabled>
                    </div>
                    <div class="formElement">
                        <label for="room">Salle : <span class="infoLabel">*</span></label>
                        <select id="room" name="room" required>
                            <option value="selection">Sélectionnez une salle</option>';
                            <?php
                            $api = new API();

                            $roomSelect = [
                                'action' => 'select',
                                'table' => 'room',
                                'orderBy' => 'room_name'
                            ];

                            $response = $api->dataVerification($roomSelect);

                            if ($response['state']) {
                                foreach ($response['data'] as $item) {
                                    echo '<option value="' . $item['room_name'] . '">' . $item['room_name'] . '</option>';
                                    $rooms[] = (object) [
                                        "id" => $item['room_id'],
                                        "title" => $item['room_name']
                                        ,
                                    ];
                                }
                                $jsonRooms = json_encode($rooms);
                            }
                            ?>
                        </select>
                    </div>
                    <div class="formElement">
                        <label for="datedebut">Date de début : <span class="infoLabel">*</span></label>
                        <input type="date" id="datedebut" name="datedebut" required>
                    </div>
                    <div class="formElement">
                        <label for="datefin">Date de fin <span class="infoLabel">*</span></label>
                        <input type="date" id="datefin" name="datefin" required>
                    </div>
                    <div id="formFilter">
                        <button type="button" id="filterButton"><ion-icon name="funnel-outline"></ion-icon>
                            Filtres</button>
                        <div id="backgroundFilterList"></div>
                        <div id="filterPage">
                            <div id="cross">
                                <ion-icon name="close-outline"></ion-icon>
                            </div>
                            <div id="filterTitle">
                                <h2>Choisir un filtre</h2>
                            </div>
                            <div id="filterList">
                                <div class="filterElement">
                                    <input type="checkbox" id="teacherComputer" name="teacherComputer">
                                    <label for="teacherComputer">Ordinateur prof</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="projector" name="projector">
                                    <label for="projector">Video projecteur</labelTeacherComputer>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="studentComputer" name="studentComputer">
                                    <label for="studentComputer">Ordinateurs étudiant</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="adobe" name="adobe">
                                    <label for="adobe">Suite adobe</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="linux" name="linux">
                                    <label for="linux">Système linux</label>
                                </div>
                                <div class="filterElement">
                                    <input type="checkbox" id="drowingRoom" name="drowingRoom">
                                    <label for="drowingRoom">Salle de dessin</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formElement">
                        <label for="boutonsubmit" id="label-boutonsubit">
                            <div id="content-btn">
                                <span id="icon-btn"><ion-icon name="checkmark-outline"></ion-icon></span>
                                <span>Réserver</span>
                            </div>
                        </label>
                        <input type="submit" value="Connexion" id="boutonsubmit" />
                    </div>
                    <div class="formElement">
                        <p id="msg-infoObligatoire">* : infos obligatoire</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="request" class="container">
        <div class="header">
            <h2>Demandes de reservation</h2>
            <div class="amount">
                <p>Il y a <span id="requestAmount"></span> demandes de reservations</p>
                <button class="refresh" id="reservation">Rafraichir</button>
            </div>
        </div>
        <div id="request-body" class="container body">
            <div id="request-body-header" class="body-header">
                <span>ReservationID</span>
                <span>Utilisateur.ice</span>
                <span>Date de début</span>
                <span>Date de fin</span>
                <span>Salle</span>
                <span>Status de la demande</span>
                <span id=action>Actions</span>
            </div>
        </div>
    </div>

    <div id='support' class="container">
        <div class="header">
            <h2>Demandes de contact</h2>
            <div class="amount">
                <p>Il y a <span id="supportAmount"></span> messages</p>
                <button class="refresh" id="message">Rafraichir</button>
            </div>
        </div>
        <div id="support-body" class="body">
            <div id="support-body-header" class="body-header">
                <span>SupportID</span>
                <span>Email</span>
                <span>Sujet</span>
                <span>Contenu</span>
            </div>
        </div>
    </div>
    <script src="../JS/adminPanelApi.js"></script>
</main>
<?php
echo $paraFile->displayFooter();
?>