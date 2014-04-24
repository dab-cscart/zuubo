{** block-description:text_links **}

{if $block.properties.show_items_in_line == 'Y'}
    {assign var="inline" value=true}
{/if}
{strip}
{if $items}
    <ul class="text-links {if $inline}text-links-inline{/if}">
    {* angel *}
        {foreach from=$items item="menu" name="mitems"}
            <li class="level-{$menu.level|default:0}{if $menu.active} active{/if}">
                {if $menu.param_id == $smarty.const.TOP_LINK_ID}{$smarty.const.METRO_CITY_ID|fn_get_metro_city_name}{/if}<a {if $menu.href}href="{$menu.href|fn_url}"{/if}>{$menu.item}</a>{if $inline && !$smarty.foreach.mitems.last}&nbsp;|&nbsp;{/if}
                {if $menu.subitems}
                    {include file="blocks/menu/text_links.tpl" items=$menu.subitems}
                {/if}
            </li>
        {/foreach}
    {* /angel *}
    </ul>
{/if}
{/strip}