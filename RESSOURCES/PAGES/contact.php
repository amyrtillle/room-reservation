<?php
require $_SERVER["DOCUMENT_ROOT"]."/RESSOURCES/ACTIONS/config.php";

if($isConnected) {
    echo $paraFile->displayHead("Contact");
    echo $paraFile->displayHeader($isAdmin, $isConnected);
    echo '
    <main>
        <div id="form-container">
            <h1>Besoin d\'aide ?</h1>
            <form action="/RESSOURCES/ACTIONS/contactFormTraitment.php" method="post" name="contact" class="form" id="form">
                <div class="formElement">
                    <label for="mail">Mon mail pour la réponse : <span class="infoLabel">(non modifiable)</span></label>
                    <input type="email" id="mail" name="mail" value="' . $_SESSION['email'] . '" disabled>
                </div>
                <div class="formElement">
                    <label for="sujet">Mon sujet : <span class="infoLabel">*</span></label>
                    <input type="text" name="sujet" id="sujet" maxlength="100" required>
                </div>
                <div class="formElement">
                    <label for="msg">Mon message : <span class="infoLabel">*</span></label>
                    <textarea name="msg" id="msg" maxlength="750" required></textarea>
                </div>
                <div class="formElement">
                    <label for="boutonsubmit" id="label-boutonsubit">
                        <div id="content-btn">
                            <span id="icon-btn"><ion-icon name="checkmark-outline"></ion-icon></span>
                            <span>Valider</span>
                        </div>
                    </label>
                    <input type="submit" value="Connexion" id="boutonsubmit"/>
                </div>
                <div class="formElement">
                    <p id="msg-infoObligatoire">* : infos obligatoires</p>
                </div>
            </form>
        </div>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    ';
    echo $paraFile->displayFooter();
} else {
    header('Location: ./RESSOURCES/ACTIONS/login.php');
}