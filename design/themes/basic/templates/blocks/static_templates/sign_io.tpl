{** block-description:sign_io **}

<div class="sign-io-wrp" id="account_info_{$block.snapping_id}">
    &nbsp;|&nbsp;
    {assign var="return_current_url" value=$config.current_url|escape:url}
    {if $auth.user_id}
        <a href="{"auth.logout?redirect_url=`$return_current_url`"|fn_url}">{__("sign_out")}</a>
    {else}
        <a href="{"auth.login_form"|fn_url}">{__("sign_in")}</a>
    {/if}
<!--account_info_{$block.snapping_id}--></div>
