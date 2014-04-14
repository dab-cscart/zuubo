{if $metro_cities}
{assign var="r_url" value=$return_url|escape:url}
{split data=$metro_cities size="4" assign="splitted_metro_cities" preverse_keys=true}
<table class="view-all table-width choose-location">
{foreach from=$splitted_metro_cities item="metro_cities"}
<tr class="valign-top">
    {foreach from=$metro_cities item="metro_city" key="index"}
    <td class="center" style="width: 25%">
        <div>
            {if $metro_city}
		{if $metro_city.cities}
		    <h2 class="subheader"><a id="sw_subcities_{$metro_city.metro_city_id}" class="cm-combination">{$metro_city.metro_city}</a></h2>
		    <div id="subcities_{$metro_city.metro_city_id}" class="product-options hidden">
			<ul>
			    {foreach from=$metro_city.cities item="city"}
				<li><a href="{"spec_dev.set_location?mc_id=`$metro_city.metro_city_id`&c_id=`$city.city_id`&return_url=`$r_url`"|fn_url}">{$city.city}</a></li>
			    {/foreach}
			</ul>
		    </div>
		{else}
		    <h2 class="subheader"><a href="{"spec_dev.set_location?mc_id=`$metro_city.metro_city_id`&return_url=`$r_url`"|fn_url}">{$metro_city.metro_city}</a></h2>
		{/if}
            {else}&nbsp;{/if}
        </div>
    </td>
    {/foreach}
</tr>
{/foreach}
</table>
{/if}
{capture name="mainbox_title"}{__("choose_location")}{/capture}