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
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-university"></i><span>Ecole</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/anneescolaire"); ?>">Année Scolaire</a></li>
        <li><a class="nav-link" href="<?php echo site_url("ecole/section"); ?>">Liste de sections</a></li>
        <li><a class="nav-link" href="<?php echo site_url("ecole/classes"); ?>">Ajouter classe</a></li>
        <li><a class="nav-link" href="<?php echo site_url("ecole/option"); ?>">Ajouter option</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-users"></i><span>Elèves</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/eleves"); ?>">Liste d'Elèves</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-print"></i><span>Rapport</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/rapport"); ?>">Liste de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-tag"></i><span>Annonces</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/annonces"); ?>">Nos annonces</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class="fa fa-shopping-bag"></i><span>Magasin</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/magasin"); ?>">Articles</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i class=" fa fa-cog"></i><span>Paramètres</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("ecole/profil"); ?>">Profil</a></li>
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