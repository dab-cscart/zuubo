{if $auth.user_id}
    <li {if $runtime.controller == 'gift_certificates' && $runtime.mode == 'list'}class="active"{/if}><a href="{"gift_certificates.list"|fn_url}" rel="nofollow">{__('gift_certificates')}</a></li>
    <li {if $runtime.controller == 'spec_dev' && $runtime.mode == 'savings'}class="active"{/if}><a href="{"spec_dev.savings"|fn_url}" rel="nofollow">{__('savings')}</a></li>
    <li {if $runtime.controller == 'spec_dev' && $runtime.mode == 'payment_details'}class="active"{/if}><a href="{"spec_dev.payment_details"|fn_url}" rel="nofollow">{__("payment_details")}</a></li>
{/if}
<li {if $runtime.controller == 'spec_dev' && $runtime.mode == 'feedbacks'}class="active"{/if}><a href="{"spec_dev.feedbacks"|fn_url}" rel="nofollow">{__('feedbacks_and_ratings')}</a></li>
