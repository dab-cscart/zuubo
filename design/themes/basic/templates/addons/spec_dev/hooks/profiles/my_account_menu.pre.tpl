{if $auth.user_id}
    <li {if $runtime.controller == 'spec_dev' && $runtime.mode == 'dashboard'}class="active"{/if}><a href="{"spec_dev.dashboard"|fn_url}" rel="nofollow">{__("my_dashboard")}</a></li>
{/if}
