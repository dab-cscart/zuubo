{if $auth.user_id}
    <li><a href="{"gift_certificates.list"|fn_url}" rel="nofollow">{__('gift_certificates')}</a></li>
    <li><a href="{"spec_dev.savings"|fn_url}" rel="nofollow">{__('savings')}</a></li>
    <li><a href="{"spec_dev.zbucks"|fn_url}" rel="nofollow">{__("my_zbucks")}</a></li>
    <li><a href="{"spec_dev.payment_details"|fn_url}" rel="nofollow">{__("payment_details")}</a></li>
{/if}
<li><a href="{"spec_dev.feedbacks"|fn_url}" rel="nofollow">{__('feedbacks_and_ratings')}</a></li>
