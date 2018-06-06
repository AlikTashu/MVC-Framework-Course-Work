

<main class="container-fluid">
    <div class="row">
        <div class="col-lg-4 offset-lg-4 ">
            <form id = "res__form" action="restore" method="post" class="form">
                <section class="form__wrapper">
                    <h4 class="form__title">Restore password</h4>
                    <div class="form-row">
                        <label class="form__error" for="loginField"><?=isset($message)?$message:""?></label>
                    </div>
                    <div class="form__row">
                        <label class="form__label" for="emailField">Email</label>
                        <input class="form__input" type="text" name="res_email" id="emailField" value="<?=isset($email)?$email:""?>">
                    </div>
                    <button  data-callback="onResSubmit" id = "res__button" class="button button--bordered form__button" data-sitekey="6LeMJF0UAAAAAFt06BsyRL6XJ8sH7TFTwWstdwJe" name = "res_btn" type="submit">Confirm</button>

                </section>
            </form>
        </div>
    </div>
</main>