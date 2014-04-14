{assign var="id" value=$id|default:"main_login"}

{capture name="login"}
<form name="{$id}_form" action="{""|fn_url}" method="post">
<input type="hidden" name="return_url" value="{$smarty.request.return_url|default:$config.current_url}" />
<input type="hidden" name="redirect_url" value="{$config.current_url}" />

{if $style == "checkout"}
    <div class="checkout-login-form">{include file="common/subheader.tpl" title=__("returning_customer")}
{/if}
            <div class="control-group">
                <label for="login_{$id}" class="cm-required cm-trim{if $settings.General.use_email_as_login == "Y"} cm-email{/if}">{if $settings.General.use_email_as_login == "Y"}{__("email")}{else}{__("username")}{/if}</label>
                <input type="text" id="login_{$id}" name="user_login" size="30" value="{$config.demo_username}" class="input-text" />
            </div>

            <div class="control-group password">
                <label for="psw_{$id}" class="forgot-password-label cm-required">{__("password")}</label>
                <input type="password" id="psw_{$id}" name="password" size="30" value="{$config.demo_password}" class="input-text" maxlength="32" />
            </div>

            {include file="common/image_verification.tpl" option="use_for_login" align="left"}

{if $style == "checkout"}
        </div>
    <div class="clear-both"></div>
    <div class="checkout-buttons clearfix">
{/if}
    {hook name="index:login_buttons"}
        {if $style != "checkout"}
            <div class="{if $style == "popup"}buttons-container{/if}">
        {/if}
            <div class="clearfix login-sets">
                <table class="table-width">
                <tr>
                    <td width="60%">
                        <div class="remember-me-chekbox">
                            <label for="remember_me_{$id}" class="valign"><input class="valign checkbox" type="checkbox" name="remember_me" id="remember_me_{$id}" value="Y" />{__("keep_me_signed_in")}</label>
                        </div>
                    </td>
                    <td width="40%" class="right"><a href="{"auth.recover_password"|fn_url}" class="forgot-password"  tabindex="5">{__("forgot_password_question")}</a></td>
                </tr>
                </table>
            </div>
            
            <p class="login-button">
                {include file="buttons/login.tpl" but_name="dispatch[auth.login]" but_role="action" but_text=__("log_in")}
            </p>
        {if $style != "checkout"}
            </div>
        {/if}
    {/hook}
{if $style == "checkout"}
    </div>
{/if}

</form>
{/capture}

{if $style == "popup"}
    {$smarty.capture.login nofilter}
{else}
    <div{if $style != "checkout"} class="{if $style != "popup"}form-wrap{/if} login"{/if}>
        {$smarty.capture.login nofilter}
    </div>

    {capture name="mainbox_title"}{__("log_in")}{/capture}
{/if}
