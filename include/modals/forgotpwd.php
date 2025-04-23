<form action="php/reset_pwd.php" method="post" class="captcha">
    <input name="g-recaptcha-response" hidden="true">
    <div class="form-floating mb-3">
        <input name="email" type="email" class="form-control border-top-0 border-start-0 border-end-0 border-2 border-black  border-bottom-3 rounded-0 bg-transparent no-outline" placeholder="Indirizzo email" required="true">
        <label>Indirizzo email</label>
    </div>
    <div id="g-recaptcha-forgotpwd" class="mb-3"></div>
    <button type="submit" class="loader border-0 bg-black text-white p-3 text-center fw-bold text-uppercase d-block w-100 mb-3 lh-1 rounded">Invia recupero</button>
</form>
<script>
    function initCaptcha() {
        if (typeof grecaptcha != "undefined")
            grecaptcha.render('g-recaptcha-forgotpwd', {
                'sitekey': '6LeW0tQiAAAAAJtx4Y8_ZZNBCXjThysFKwcj2OQd'
            });
    }
    initCaptcha();
</script>