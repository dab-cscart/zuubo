<div class="recover-password-note">{__("recover_password_note")}</div>
<div class="login">
<form name="recoverfrm" action="{""|fn_url}" method="post">
<div class="left">
    <div class="control-group">
        <label class="cm-trim" for="login_id">{__("email")}</label>
        <input type="text" id="login_id" name="user_email" size="30" value="" class="input-text cm-focus" />
    </div>
    <div class="body-bc login-recovery">
        {include file="buttons/reset_password.tpl" but_name="dispatch[auth.recover_password]" but_role="action"}
    </div>
</div>
</form>
</div>
{capture name="mainbox_title"}{__("recover_password")}{/capture}