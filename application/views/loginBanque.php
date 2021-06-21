<!DOCTYPE html>
<html lang="en">

<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Admin Banque</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/app.min.css'; ?>">
  <!-- Template CSS -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/style.css' ;?>">
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/components.css'; ?>">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/css/custom.css'; ?>">
  <link rel='shortcut icon' type='image/x-icon' href="<?php echo base_url().'assets/img/favicon.ico';?>"/>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Connexion</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo site_url('AdminCredential/bankConnexion'); ?>" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Banque</label>
                    <input id="email" type="text" class="form-control" name="login" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Ce champs est obligatoire
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Code</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="code" tabindex="2" required>
                    <div class="invalid-feedback">
                      Ce champs est obligatoire
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Se souvenir de moi</label>
                    </div>
                    <p><b><?php if(isset($error)) echo $error ?></b></p>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                  <div class="form-group">
                    <a href="<?php echo site_url('poster/index'); ?>">
                      <p type="text" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Retour
                      </p>
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
<!-- General JS Scripts -->
<script src="<?php echo base_url().'assets/js/app.min.js'; ?>"></script>
  <!-- JS Libraies -->
  <script src="<?php echo base_url().'assets/bundles/apexcharts/apexcharts.min.js'; ?>"></script>
  <!-- Page Specific JS File -->
  <script src="<?php echo base_url().'assets/js/page/index.js'; ?>"></script>
  <!-- Template JS File -->
  <script src="<?php echo base_url().'assets/js/scripts.js'; ?>"></script>
  <!-- Custom JS File -->
  <script src="<?php echo base_url().'assets/js/custom.js'; ?>"></script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>