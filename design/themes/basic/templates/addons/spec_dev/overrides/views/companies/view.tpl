{hook name="companies:view"}

{assign var="obj_id" value=$company_data.company_id}
{assign var="obj_id_prefix" value="`$obj_prefix``$obj_id`"}
    {include file="common/company_data.tpl" company=$company_data show_name=true show_descr=true show_rating=true show_logo=true hide_links=true}
    <div class="company-page clearfix">

        <div id="block_company_{$company_data.company_id}" class="clearfix">
            <h1 class="mainbox-title"><span>{$company_data.company}</span> - {__("microsite")}</h1>

            <div class="company-page-top-links clearfix">
                {hook name="companies:top_links"}
                    <div id="company_products">
                        <a href="{"products.search?company_id=`$company_data.company_id`&search_performed=Y"|fn_url}">{__("view_vendor_products")}
                            ({$company_data.total_products} {__("items")})</a>
                    </div>
                {/hook}
            </div>
            <div class="company-page-info">
                <div class="company-logo">
                    {assign var="capture_name" value="logo_`$obj_id`"}
                    {$smarty.capture.$capture_name nofilter}
                </div>
            </div>
           
	</div>

	<h1 class="mainbox-title"><span>{__("description")}</span></h1>
	<div id="block_company_description">
	    {if $company_data.company_description}
		<div class="wysiwyg-content">
		    {$company_data.company_description nofilter}
		</div>
	    {/if}
	</div>

	{hook name="companies:tabs"}
	{/hook}
	
    </div>

{/hook}