<?php include('heade.php');?>
<section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">              
              <div class="card-header">
                <h4>Login</h4>
              </div>
              <div class="card-body">
                <form method="POST" action=<?=site_url('prof/admin/login')?> class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email">Nom d'utilisateur</label>
                    <input id="email" type="text" class="form-control" name="username" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Veuillez saisir votre adresse mail
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Mot de passe</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Mot de passe oublié?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="mdp" tabindex="2" required>
                    <div class="invalid-feedback">
                    Veuillez saisir votre mot de passe
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Se souvenir de moi</label>
                    </div>
                  </div>
                  <p class="text-red"><?php if(isset($error)){echo $error;}?></p>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Connexion
                    </button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php include('footer.php');?>