<div id="changepwdpannel" style="display:none" class="glass text-center">
    <div class="form-signin w-200">
        <form data-bitwarden-watching="1" action="../modules/dbconnect.php" method="POST">
            <h1 class="h1 mb-3 ">Modification du mot de passe</h1>

            <div class="mb-2">
                <input type="password" class="form-control" id="OldPass" name="OldPass" maxlength="128" placeholder="Ancien mot de passe">
            </div>
            <div class="mb-2">
                <input type="password" class="form-control" id="Newpass" name="Newpass" maxlength="128" placeholder="Nouveau mot de passe">
            </div>
            <div class="mb-5">
                <input type="password" class="form-control" id="ConfNewpass" name="ConfNewpass" maxlength="128" placeholder="Confirmer le nouveau mot de passe">
            </div>

            <button class="w-100 btn btn-lg btn-primary" name="changepassword" value="" type="submit">Enregistrer</button>
        </form>
        <button class="mt-2 w-100 btn btn-lg btn-danger" name="quit" onclick="hidechangepwd()">Annuler</button>
    </div>
</div>