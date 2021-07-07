<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo site_url('ecole'); ?>"> <img alt="image" src="<?php echo base_url('assets/img/bangu.png'); ?>" class="header-logo" /> <span class="logo-name">MbanguPay</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="dropdown">
      <a href="<?php echo site_url("ecole"); ?>" class="nav-link"><i class="fa fa-home"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url("ecole/solde"); ?>" class="nav-link"><i class="fa fa-chart-bar"></i><span>Solde</span></a>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-credit-card"></i><span>Frais</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/frais"); ?>">Liste de frais</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Université</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("faculte/anneeacademique"); ?>">Annee Academique</a></li>
        <li><a class="nav-link" href="<?php echo site_url("faculte/listefaculte"); ?>">Liste de faculté</a></li>
        <li><a class="nav-link" href="<?php echo site_url("faculte/promotion"); ?>">Ajouter promotion</a></li>
        <li><a class="nav-link" href="<?php echo site_url("faculte/option"); ?>">Ajouter option</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-user-graduate"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banque/listertudiant"); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Rapport</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banque/listerapport"); ?>">Liste de paiement</a></li>
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