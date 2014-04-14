{foreach from=$fields item=field}

{assign var="value" value=$user_data|fn_get_profile_field_value:$field}
{if $value}
{* angel *}
<div class="info-field {$field.field_name|replace:"_":"-"}">{if $display_description}<span class="fld-name">{$field.description}:</span>{/if}{$value}</div>
{* /angel *}
{/if}
{/foreach}