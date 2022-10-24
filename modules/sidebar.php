<style>
    #sidebar {
        width: 4.5rem;
        height: 100vh;
        background-color: rgb(208, 208, 208);
        display: flex;
    }

    .thin-navbar {
        display: none;
        width: 100vw;
    }

    .active {
        fill: white;
    }

    @media (max-width: 768px) {
        #sidebar {
            display: none;
        }

        .thin-navbar {
            display: inline;
        }
    }

    .show {
        z-index: 2;
    }
</style>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="people-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
    </symbol>
    <symbol id="card" viewBox="0 0 16 16">
        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
        <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z" />
    </symbol>
    <symbol id="calendar" viewBox="0 0 16 16">
        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
        <path fill-rule="evenodd" d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
    </symbol>
    <symbol id="home" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
    </symbol>
    <symbol id="gear" viewBox="0 0 16 16">
        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
    </symbol>
    <symbol id="buttonlist" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
    </symbol>
    <symbol id="presentoir" viewBox="0 0 16 16">
        <path d="M8 0a.5.5 0 0 1 .473.337L9.046 2H14a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1.85l1.323 3.837a.5.5 0 1 1-.946.326L11.092 11H8.5v3a.5.5 0 0 1-1 0v-3H4.908l-1.435 4.163a.5.5 0 1 1-.946-.326L3.85 11H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h4.954L7.527.337A.5.5 0 0 1 8 0zM2 3v7h12V3H2z"/>
    </symbol>
    <symbol id="sono" viewBox="0 0 16 16">
        <path d="M5 3a3 3 0 0 1 6 0v5a3 3 0 0 1-6 0V3z"/>
        <path d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"/>
    </symbol>
    
</svg>

<script>
    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<!-- PHONE -->
<div class="thin-navbar">
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JW Lodelinsart</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <svg class="bi pe-none" width="28" height="28" role="img">
                    <use xlink:href="#buttonlist"></use>
                </svg>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown" name="menu">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/accueil/") {echo "active";} ?>" aria-current="page" href="<?php if ($_SERVER['REQUEST_URI'] == "/accueil/") {echo "#";} else {echo "/accueil/";} ?>">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/programmes/") {echo "active";} ?>" href="<?php if ($_SERVER['REQUEST_URI'] == "/programmes/") {echo "#";} else {echo "/programmes/";} ?>">Programmes</a>
        </li>
        <?php
        $page = $_SERVER['REQUEST_URI'];
        if($_SESSION["presentoir"]){
            echo '
            <li class="nav-item">
                <a class="nav-link';
            if ($_SERVER['REQUEST_URI'] == "/presentoir/") {echo " active";}
            echo'" href="';
            if ($_SERVER['REQUEST_URI'] == "/presentoir/") {echo "#";} else {echo "/presentoir/";}
            echo '">Présentoir</a></li>';
        }
        ?>
        <?php
        $page = $_SERVER['REQUEST_URI'];
        if($_SESSION["sono"]){
            echo '
            <li class="nav-item">
                <a class="nav-link';
            if ($_SERVER['REQUEST_URI'] == "/sono/") {echo " active";}
            echo'" href="';
            if ($_SERVER['REQUEST_URI'] == "/sono/") {echo "#";} else {echo "/sono/";}
            echo '">Sono</a></li>';
        }
        ?>

        <?php
        $page = $_SERVER['REQUEST_URI'];
        if($_SESSION["admin"]){
            echo '
            <li class="nav-item">
                <a class="nav-link';
            if ($page == "/admin/") {echo " active";}
            echo'" href="';
            if ($page == "/admin/") {echo "#";} else {echo "/admin/";}
            echo '">Administration</a></li>';
        }
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mon compte</a>
          <ul class="dropdown-menu text-small shadow collapse" id="pageSubmenu">
            <li>
                <a href="/participations/" class="dropdown-item">Mes participations</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a onclick="displaychangepwd()" class="dropdown-item">Modifier le mot de passe</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a href="../index.php?exit" class="dropdown-item text-danger">Déconnexion</a>
            </li>
        </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
</div>

<!-- WEB -->
<nav id="sidebar" class="flex-column flex-shrink-0 bg-light">

    <a href="#" class="d-block p-2 link-dark text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="right">
        <!-- <svg class="bi pe-none" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg> -->
        <img width="50" height="50" src="/img/jw4.jpg" alt="logo">
    </a>

    <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">

        <li class="nav-item">
            <a href="<?php if ($_SERVER['REQUEST_URI'] == "/accueil/") {echo "#";} else {echo "/accueil/";} ?>" class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/accueil/") {echo "active";} ?> py-3 border-bottom border-top rounded-0" data-toggle="tooltip" data-placement="right" title="Accueil">
                <svg class="bi pe-none" width="28" height="28" role="img">
                    <use xlink:href="#home"></use>
                </svg>
            </a>
        </li>

        <li class="nav-item">
            <a href="<?php if ($_SERVER['REQUEST_URI'] == "/programmes/") {echo "#";} else {echo "/programmes/";} ?>" class="nav-link <?php if ($_SERVER['REQUEST_URI'] == "/programmes/") {echo "active";} ?> py-3 border-bottom rounded-0" data-toggle="tooltip" data-placement="right" title="Programmes">
                <svg class="bi pe-none" width="24" height="24" role="img">
                    <use xlink:href="#calendar"></use>
                </svg>
            </a>
        </li>

        <?php
        if($_SESSION["presentoir"]){
            echo '<li class="nav-item">
                <a href="';
                if ($_SERVER['REQUEST_URI'] == "/presentoir/") {echo "#";} else {echo "/presentoir/";}
                echo '" class="nav-link ';
                if ($_SERVER['REQUEST_URI'] == "/presentoir/") {echo "active";};
                echo ' py-3 border-bottom rounded-0" data-toggle="tooltip" data-placement="right" title="Présentoir">
                    <svg class="bi pe-none" width="26" height="26" role="img">
                        <use xlink:href="#presentoir"></use>
                    </svg>
                </a>
            </li>';
        }   
        ?>

        <?php
        if($_SESSION["sono"]){
            echo '<li class="nav-item">
                <a href="';
                if ($_SERVER['REQUEST_URI'] == "/sono/") {echo "#";} else {echo "/sono/";}
                echo '" class="nav-link ';
                if ($_SERVER['REQUEST_URI'] == "/sono/") {echo "active";};
                echo ' py-3 border-bottom rounded-0" data-toggle="tooltip" data-placement="right" title="Sonorisation">
                    <svg class="bi pe-none" width="26" height="26" role="img">
                        <use xlink:href="#sono"></use>
                    </svg>
                </a>
            </li>';
        }   
        ?>

    </ul>



    <?php
    if($_SESSION["admin"]){
        echo '
        <ul class="nav nav-pills nav-flush flex-column p-3 text-center">
            <li class="nav-item">   
            <a href="';
        if ($_SERVER['REQUEST_URI'] == "/admin/") {echo "#";} else {echo "/admin/";}
        echo '" data-toggle="tooltip" data-placement="right" title="Administration">
                <svg class="bi pe-none" width="24" height="24" role="img">
                    <use xlink:href="#gear"></use>
                </svg>
            </a>
            </li>
        </ul>
        ';
    }?>
    

    <div class="dropdown border-top dropup">
        <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="d-flex align-items-center justify-content-center p-3 link-dark text-decoration-none dropdown-toggle">
            <svg class="bi pe-none" width="24" height="24" role="img" aria-label="Customers">
                <use xlink:href="#people-circle"></use>
            </svg>
        </a>
        <ul class="dropdown-menu text-small shadow collapse" id="pageSubmenu">
            <li>
                <a href="/participations/" class="dropdown-item">Mes participations</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a onclick="displaychangepwd()" class="dropdown-item">Modifier le mot de passe</a>
            </li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <a href="../index.php?exit" class="dropdown-item text-danger">Déconnexion</a>
            </li>
        </ul>
    </div>
</nav>