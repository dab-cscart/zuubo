{if $metro_cities}
{split data=$metro_cities size="4" assign="splitted_metro_cities" preverse_keys=true}
<table class="view-all table-width">
{foreach from=$splitted_metro_cities item="metro_cities"}
<tr class="valign-top">
    {foreach from=$metro_cities item="metro_city" key="index"}
    <td class="center" style="width: 25%">
        <div>
            {if $metro_city}
                {include file="common/subheader.tpl" title=$metro_city.metro_city}
                <ul>
                {foreach from=$metro_city.cities item="city"}
                    <li><a href="{"spec_dev.set_location?mc_id=`$metro_city.metro_city_id`&c_id=`$city.city_id`"|fn_url}">{$city.city}</a></li>
                {/foreach}
            </ul>
            {else}&nbsp;{/if}
        </div>
    </td>
    {/foreach}
</tr>
{/foreach}
</table>
{/if}