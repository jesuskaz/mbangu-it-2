<aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="<?=base_url("assets/img/bangu.png");?>" class="header-logo" /> <span
                class="logo-name">MbanguPay</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
              <a href="<?=site_url('prof/login'); ?>" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="menu-togg  le nav-link has-dropdown"><i
                  data-feather="chevrons-down"></i><span>Sylabus</span></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?=site_url("prof/admin/postSyllabus"); ?>">Publier Syllabus</a>
                </li>
                <li class="dropdown">
                  <a href="<?=site_url("prof/admin/listSyllabus"); ?>" class="has-dropdown">Liste Syllabus</a>
                </li>
              </ul>
            </li>
            <li class="dropdown active">
              <a href="<?=site_url('prof/login'); ?>" class="nav-link"><i data-feather="monitor"></i><span>Se Deconnecter</span></a>
            </li>
          </ul>
</aside>