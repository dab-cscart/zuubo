{if $auth.user_id}
    <li><a href="{"gift_certificates.list"|fn_url}" rel="nofollow">{__('gift_certificates')}</a></li>
    <li><a href="{"spec_dev.savings"|fn_url}" rel="nofollow">{__('savings')}</a></li>
{/if}
