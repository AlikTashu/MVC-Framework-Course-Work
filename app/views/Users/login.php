

  <main class="container-fluid">
    <div class="row">
      <div class="col-lg-4 offset-lg-4 ">
        <form id="auth__form" action="login" method="post" class="form">
          <section class="form__wrapper">
            <h4 class="form__title">Log in</h4>
              <div class="form-row">
                  <label class="form__error" for="loginField"><?= isset($message) ? $message : "" ?></label>
              </div>
            <div class="form__row">
              <label class="form__label" for="loginField">Login</label>
              <input class="form__input" type="text" name="log_login" id="loginField">
            </div>
            <div class="form__row">
              <label class="form__label" for="passwordField">Password</label>
              <input class="form__input" type="password"name="log_password" id="passwordField">
            </div>
              <div class="text-center">
                  <a class="" href="restore" >Forgot password?</a>
              </div>
            <button data-callback="onAuthSubmit" id="auth__button" class="button button--bordered form__button" data-sitekey="6LeMJF0UAAAAAFt06BsyRL6XJ8sH7TFTwWstdwJe" name = "log_btn" type="submit">Log In</button>
          </section>
        </form>
      </div>
    </div>
  </main>
<!---->
<!--  g-recaptcha-->