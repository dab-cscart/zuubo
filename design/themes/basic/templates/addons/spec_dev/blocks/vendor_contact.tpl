<div class="clearfix">
    <div class="info-list">
        <div>
        <strong>{$company_data.address}</strong>
        </div>
        <p>
            {$company_data.city}, {$company_data.state|fn_get_state_name:$company_data.country} {$company_data.zipcode}<br />
            {$company_data.country|fn_get_country_name}
        </p>
    </div>
</div>
<div class="clearfix">
    <div class="info-list">
        {if $company_data.email}
        <p>
            {* <label>{__("email")}:</label> *}
            <span><a href="mailto:{$company_data.email}">{$company_data.email}</a></span>
        </p>
        {/if}
        {if $company_data.phone}
        <p>
            {* <label>{__("phone")}:</label> *}
            <span>{$company_data.phone}</span>
        </p>
        {/if}
        {if $company_data.fax}
        <p>
            {* <label>{__("fax")}:</label> *}
            <span>{$company_data.fax}</span>
        </p>
        {/if}
        {if $company_data.url}
        <p>
            {* <label>{__("website")}:</label> *}
            <span><a href="{$company_data.url}" target="_blank">{$company_data.url}</a></span>
        </p>
        {/if}
    </div>
</div>