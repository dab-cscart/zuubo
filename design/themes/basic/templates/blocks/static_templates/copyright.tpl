{** block-description:tmpl_copyright **}
{* angel *}
<p class="bottom-copyright">{__("copyright")} &copy; {if $smarty.const.TIME|date_format:"%Y" != $settings.Company.company_start_year}{$settings.Company.company_start_year}-{/if}{$smarty.const.TIME|date_format:"%Y"} {$settings.Company.company_name}. - {__("all_rights_reserved")}
</p>
{* /angel *}