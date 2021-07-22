<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="#"> <img alt="image" src="<?php echo base_url() . 'assets/img/bangu.png'; ?>" class="header-logo" /> <span class="logo-name">MBANGU PAY</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="dropdown">
      <a href="<?php echo site_url('Manager'); ?>" class="nav-link"><i class="fa fa-home"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url('Manager/devise'); ?>" class="nav-link"><i class="fa fa-dollar-sign"></i><span>Ajouter Devises</span></a>
    </li>
    <li class="dropdown">
      <a href="" class="menu-toggle nav-link has-dropdown"><i class="fa fa-map-marked-alt"></i><span>Province</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("province/index"); ?>">Ajouter provinces</a></li>
        <li><a class="nav-link" href="<?php echo site_url("province/ville"); ?>">Ajouter Ville</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Banque</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admBanque/loadbanque"); ?>">Liste de Banques</a></li>
        <li><a class="nav-link" href="<?php echo site_url("admBanque/addbanque"); ?>">Ajouter Banque</a></li>
        <li><a class="nav-link" href="<?php echo site_url("AdmCompte/listecompte"); ?>">Liste de comptes</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Université</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admUniversite/loaduniversite"); ?>">Liste Universités</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Ecole</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admUniversite/ecole"); ?>">Liste ecoles</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="" class="menu-toggle nav-link has-dropdown"><i class="fa fa-chalkboard"></i><span>Faculté</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admFaculte/listefaculte"); ?>">Liste de faculté</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-user-graduate"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admEtudiant/listeetudiant"); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Rapport</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("admEtudiant/listepaiement") ?>">Liste de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-tag"></i><span>Annonces</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("manager/annonces"); ?>">Nos annonces</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url('Index'); ?>" class="menu-toggle nav-link has-dropdown"><i class="fa fa-sign-out-alt"></i><span>Se déconnecter</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url('Index/deconnexion'); ?>">déconnexion</a></li>
      </ul>
    </li>
  </ul>
</aside>