{if $metro_cities}
{assign var="r_url" value=$return_url|escape:url}
{split data=$metro_cities size="4" assign="splitted_metro_cities" preverse_keys=true}
<table class="view-all table-width">
{foreach from=$splitted_metro_cities item="metro_cities"}
<tr class="valign-top">
    {foreach from=$metro_cities item="metro_city" key="index"}
    <td class="center" style="width: 25%">
        <div>
            {if $metro_city}
		{if $metro_city.cities}
		    <a id="sw_subcities_{$metro_city.metro_city_id}" class="cm-combination detailed-link">{include file="common/subheader.tpl" title=$metro_city.metro_city}</a>
		    <div id="subcities_{$metro_city.metro_city_id}" class="product-options hidden">
			<ul>
			    {foreach from=$metro_city.cities item="city"}
				<li><a href="{"spec_dev.set_location?mc_id=`$metro_city.metro_city_id`&c_id=`$city.city_id`&return_url=`$r_url`"|fn_url}">{$city.city}</a></li>
			    {/foreach}
			</ul>
		    </div>
		{else}
		    <a href="{"spec_dev.set_location?mc_id=`$metro_city.metro_city_id`&return_url=`$r_url`"|fn_url}">{include file="common/subheader.tpl" title=$metro_city.metro_city}</a>
		{/if}
            {else}&nbsp;{/if}
        </div>
    </td>
    {/foreach}
</tr>
{/foreach}
</table>
{/if}