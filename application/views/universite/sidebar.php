<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo site_url('index/home'); ?>"> <img alt="image" src="<?php echo base_url('assets/img/bangu.png'); ?>" class="header-logo" /> <span class="logo-name">MbanguPay</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown">
      <a href="<?php echo site_url("index/home"); ?>" class="nav-link"><i class="fa fa-home"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url("index/solde"); ?>" class="nav-link"><i class="fa fa-chart-bar"></i><span>Solde</span></a>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-credit-card"></i><span>Frais</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeCompte"); ?>">Liste de frais</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Université</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Faculte/anneeAcademique"); ?>">Annee Academique</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/listeFaculte"); ?>">Liste de faculté</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/promotion"); ?>">Ajouter promotion</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/option"); ?>">Ajouter option</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-user-graduate"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeEtudiant"); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Rapport</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeRapport"); ?>">Liste de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class=" fa fa-cog"></i><span>Paramètres</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banque/profil"); ?>">Profil</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-sign-out-alt"></i><span>Se deconnecter</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("index/deconnexion"); ?>">Deconnecter</a></li>
      </ul>
    </li>
  </ul>
</aside>