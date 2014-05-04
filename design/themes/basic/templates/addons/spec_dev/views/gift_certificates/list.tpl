<table class="table table-width">
<tr>
    <th style="width: 60%">{__("code")}</th>
    <th style="width: 20%">{__("sender")}</th>
    <th style="width: 10%">{__("amount")}</th>
    <th style="width: 10%">{__("status")}</th>
</tr>
{foreach from=$gift_certificates item="certificate"}
<tr {cycle values=",class=\"table-row\""}>
    <td class="valign-top">{$certificate.gift_cert_code}</td>
    <td class="right valign-top">{$certificate.sender}</td>
    <td class="right valign-top">{include file="common/price.tpl" value=$certificate.amount}</td>
    <td class="valign-top">{include file="common/status.tpl" status=$certificate.status display="view" status_type="G"}</td>
</tr>
{foreachelse}
<tr>
    <td colspan="3"><p class="no-items">{__("no_items")}</p></td>
</tr>
{/foreach}
</table>


{capture name="mainbox_title"}{__("gift_certificates")}{/capture}
