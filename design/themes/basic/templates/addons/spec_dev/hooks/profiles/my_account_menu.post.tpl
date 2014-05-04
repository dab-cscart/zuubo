{if $auth.user_id}
    <li class="user-name"><a href="{"gift_certificates.list"|fn_url}" rel="nofollow" class="underlined">{__('gift_certificates')}</a></li>
    <li class="user-name"><a href="{"spec_dev.savings"|fn_url}" rel="nofollow" class="underlined">{__('savings')}</a></li>
{/if}
