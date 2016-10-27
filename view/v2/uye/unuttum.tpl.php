<main id="main-content" class="col-md-8">
    <h4><?= $message ? '<br>' . $message : ''; ?></h4>
    <section class="widget">
        <!--Header-->
        <header class="clearfix"><h4>Şifremi Unuttum</h4></header>

        <!--Content: Sign in form-->
        <form role="form" method="POST">
            <input type="hidden" name="btnEpostaKontrol" value="1">

            <div class="form-group">
                <label for="exampleInputEmail1">Eposta Adresiniz</label>
                <input type="email" id="exampleInputEmail1" name="eposta" placeholder="Eposta Adresiniz" required>
            </div>
            <p>
                <button type="submit" class="btn btn-primary">Gönder</button>
            </p>
        </form>
    </section>
</main>
<?= $sag_menu_2 ?>