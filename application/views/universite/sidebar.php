<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="<?php echo site_url('Index'); ?>"> <img alt="image" src="<?php echo base_url('assets/img/bangu.png'); ?>" class="header-logo" /> <span class="logo-name">MbanguPay</span>
    </a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">Main</li>
    <li class="dropdown">
      <a href="<?php echo site_url("index/home"); ?>" class="nav-link"><i data-feather="monitor"></i><span>Accueil</span></a>
    </li>
    <li class="dropdown">
      <a href="<?php echo site_url("index/solde"); ?>" class="nav-link"><i data-feather="monitor"></i><span>Solde</span></a>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="briefcase"></i><span>Frais</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeCompte"); ?>">Liste de frais</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Université</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Faculte/anneeAcademique"); ?>">Annee Academique</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/listeFaculte"); ?>">Liste de faculté</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/promotion"); ?>">Ajouter promotion</a></li>
        <li><a class="nav-link" href="<?php echo site_url("Faculte/option"); ?>">Ajouter option</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Etudiant</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeEtudiant"); ?>">Voir la liste des Etudiants</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="copy"></i><span>Rapport</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("Banque/listeRapport"); ?>">Liste de paiement</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Autres</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("banque/profil"); ?>">Profil</a></li>
      </ul>
    </li>
    <li class="dropdown">
      <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Se deconnecter</span></a>
      <ul class="dropdown-menu">
        <li><a class="nav-link" href="<?php echo site_url("index/deconnexion"); ?>">Deconnecter</a></li>
      </ul>
    </li>
  </ul>
</aside>