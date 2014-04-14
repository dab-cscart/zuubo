{if $auth.user_id}
<li {if $runtime.controller == 'reward_points' && $runtime.mode == 'userlog'}class="active"{/if}><a href="{"reward_points.userlog"|fn_url}" rel="nofollow">{__("my_zbucks")}&nbsp;<span>({$user_info.points|default:"0"})</span></a></li>
{/if}