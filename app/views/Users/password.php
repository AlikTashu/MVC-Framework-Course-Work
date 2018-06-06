<main class="container-fluid">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 ">
            <form action="password.php" method="post" class="form">
                <section class="form__wrapper">
                    <h4 class="form__title">New password</h4>
                    <div class="form-row">
                        <label class="form__error" for="loginField"><?= isset($message) ? $message : "" ?></label>
                    </div>
                    <div class="form-row">
                        <input type="hidden" name="res_id" value="<?= isset($id) ? $id : "" ?>"/>
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="passwordField">Password</label>
                        <input class="form__input" type="password" name="res_password" id="passwordField">
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="repeatPasswordField">Repeat password</label>
                        <input class="form__input" type="password" name="res_password_rep" id="repeatPasswordField">
                    </div>
                    <button class="button button--bordered form__button" name="res_btn" type="submit">Confirm</button>
                </section>
            </form>
        </div>
    </div>
</main>