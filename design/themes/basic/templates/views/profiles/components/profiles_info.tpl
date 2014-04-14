{include file="common/subheader.tpl" title=__("customer_information")}

{* angel *}
{if $display_contact_info}
    <h5>{__("contact_information")}</h5>
    <span class="fld-name-small">{__("email")}: </span>{$order_info.email}
{/if}

{assign var="profile_fields" value=$location|fn_get_profile_fields}
{split data=$profile_fields.C size=2 assign="contact_fields" simple=true size_is_horizontal=true}

<table class="orders-info valign-top table-width">
<tr class="valign-top">
    {if $profile_fields.B}
        <td id="tygh_order_billing_adress" style="width: {if $contact_fields.0}31{else}50{/if}%">
            <h5>{__("billing_address")}</h5>
            <div class="orders-field">{include file="views/profiles/components/profile_fields_info.tpl" fields=$profile_fields.B title=__("billing_address") display_description=true}</div>
        </td>
    {/if}
    {if $profile_fields.S}
        <td id="tygh_order_shipping_adress" style="width: {if $contact_fields.0}31{else}50{/if}%">
            <h5>{__("shipping_address")}</h5>
            <div class="orders-field">{include file="views/profiles/components/profile_fields_info.tpl" fields=$profile_fields.S title=__("shipping_address") display_description=true}</div>
        </td>
    {/if}
    {if $contact_fields.0}
    <td style="width: 35%">
            {capture name="contact_information"}
                {include file="views/profiles/components/profile_fields_info.tpl" fields=$contact_fields.0 title=__("contact_information")}
            {/capture}
            {if $smarty.capture.contact_information|trim != ""}
                <h5>{__("contact_information")}</h5>
                <div class="orders-field">{$smarty.capture.contact_information nofilter}</div>
            {/if}
    </td>
    {/if}
</tr>
</table>
{* /angel *}