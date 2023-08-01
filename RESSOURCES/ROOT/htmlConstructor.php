<?php

Class htmlConstructor{

    public function displayHead($page){
        //construct the head of page
        return '
            <!doctype html>
            <html lang="fr">
                <head>
                    <meta charset="utf-8">
                    <title>MMI - ' . ucfirst($page) . '</title>
                    <link rel="stylesheet" href="/RESSOURCES/CSS/general.css">
                    <link rel="stylesheet" href="/RESSOURCES/CSS/header-footer.css">
                    <link rel="shortcut icon" href="/RESSOURCES/IMAGES/logo.png" />
                    <meta name="viewport" content="width=device-width" initial-scale="1.0">
                    
                    <!-- calendar -->
                    <link rel="stylesheet" href="/RESSOURCES/CSS/calendar.css">
                    <script src="https://cdn.jsdelivr.net/npm/@event-calendar/build@1.5.0/event-calendar.min.js"></script>
                    
                    <!-- font -->
                    <link rel="preconnect" href="https://fonts.googleapis.com">
                    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@300;400&family=Secular+One&display=swap" rel="stylesheet">
                    
                    <link rel="stylesheet" href="/RESSOURCES/CSS/' . strtolower($page) . '.css">

                </head>
        ';
    }

    public function displayHeader($isAdmin, $isConnected){
        //construct the body tag and the header
            $isAdmin ? $isAdminText = "Gestion" :
                $isAdminText = "Réserver une salle";
            $isAdmin ? $isAdminUrl = "/RESSOURCES/PAGES/gestion-admin.php" :
                $isAdminUrl = "/RESSOURCES/PAGES/gestion-user.php";

            $isConnected ? $isConnectedText = "Deconnexion" :
                $isConnectedText = "Connexion";
            $isConnected ? $isConnectedUrl = "/RESSOURCES/ACTIONS/destroySession.php" :
                $isConnectedUrl = "/RESSOURCES/ACTIONS/login.php";

        return '
                <body>
                    <header>
                        <nav>
                            <div id="logo">
                                <a href="/"><img src="/RESSOURCES/IMAGES/logo.png"></a>
                            </div>
                            <ul>
                                <li class="button-underline"><a href="/RESSOURCES/PAGES/contact.php">Aide</a></li>
                                <li class="button-underline"><a href="' . $isAdminUrl . '">' . $isAdminText . '</a></li>
                                <li><a href="' . $isConnectedUrl . '" class="button">' . $isConnectedText . '</a></li>
                            </ul>
                        </nav>
                        <div id="bottom-header"></div>
                    </header>
        ';
    }

    public function displayFooter(){
        //construct the footer and close the body tag
        return '
                    <footer>
                        <div>
                            <ul>
                                <li><a href="https://iut1-mmi-moodle.univ-grenoble-alpes.fr/"><img src="/RESSOURCES/IMAGES/logo.png"/></a></li>
                                <li><a href="https://www.univ-grenoble-alpes.fr/"><img src="/RESSOURCES/IMAGES/logo_IUT1.png"/></a></li>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <li><a href="https://iut1-mmi-moodle.univ-grenoble-alpes.fr/">Moodle</a></li>
                                <li><a href="https://leo.univ-grenoble-alpes.fr/">LEO</a></li>
                                <li><a href="https://www.univ-grenoble-alpes.fr/">UGA</a></li>
                            </ul>
                        </div>
                        <div>
                            <ul>
                                <li><a href="/RESSOURCES/PAGES/cgu.php">Conditions Générales d\'Utilisation</a></li>
                                <li><a href="/RESSOURCES/PAGES/contact.php">Contacter le support</a></li>
                            </ul>
                        </div>
                    </footer>
                </body>
            </html>
        ';
    }

}



