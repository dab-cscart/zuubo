<div class="info-list">
    <div>
	<span>{$company_data.address}</span>
    </div>
    <div>
	<span>{$company_data.city}
	    , {$company_data.state|fn_get_state_name:$company_data.country} {$company_data.zipcode}</span>
    </div>
    <div>
	<span>{$company_data.country|fn_get_country_name}</span>
    </div>
</div>
<div class="info-list">
    {if $company_data.email}
	<div>
	    <label>{__("email")}:</label>
	    <span><a href="mailto:{$company_data.email}">{$company_data.email}</a></span>
	</div>
    {/if}
    {if $company_data.phone}
	<div>
	    <label>{__("phone")}:</label>
	    <span>{$company_data.phone}</span>
	</div>
    {/if}
    {if $company_data.fax}
	<div>
	    <label>{__("fax")}:</label>
	    <span>{$company_data.fax}</span>
	</div>
    {/if}
    {if $company_data.url}
	<div>
	    <label>{__("website")}:</label>
	    <span><a href="{$company_data.url}">{$company_data.url}</a></span>
	</div>
    {/if}
</div>