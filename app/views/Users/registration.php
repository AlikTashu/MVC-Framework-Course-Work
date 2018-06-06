

<main class="container-fluid">
    <div class="row">
      <div class="col-lg-4 offset-lg-4 ">
        <form   id="reg__form"action="register" method="post" class="form">
          <section class="form__wrapper">
            <h4 class="form__title">Sign Up</h4>
              <div class="form-row">
                  <label class="form__error" for="loginField"><?=$message?></label>
              </div>
            <div class="form__row">
              <label class="form__label" for="loginField">Login</label>
              <input class="form__input" type="text" name="reg_login" id="loginField" value = "<?=isset($data["reg_login"])?$data["reg_login"]:""?>">
            </div>
            <div class="form__row">
              <label class="form__label" for="emailField">Email</label>
              <input class="form__input" type="email" name="reg_email" id="emailField" value = "<?=isset($data["reg_email"])?$data["reg_email"]:""?>">
            </div>
            <div class="form__row">
              <label class="form__label" for="passwordField">Password</label>
              <input class="form__input" type="password" name="reg_password" id="passwordField">
            </div>
              <div class="form__row">
                  <label class="form__label" for="passwordField">Repeat Password</label>
                  <input class="form__input" type="password" name="reg_password_rep" id="passwordRepField" >
              </div>
            <button data-callback="onRegSubmit" id="reg__button" class="button button--bordered form__button" data-sitekey="<?=$cfg["public_key"]?>" name="reg_btn" type="submit">Sign Up</button>
          </section>
        </form>
      </div>
    </div>
  </main>

