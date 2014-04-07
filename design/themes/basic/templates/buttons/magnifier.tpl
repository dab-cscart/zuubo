{* angel *}
{if $text}<span class="search-but"><span class="search-but-inside">{/if}
    <button title="{$alt}"{if !$text} class="search-magnifier"{/if} type="submit">{if $text}{__("search")}{else}<i class="icon-search"></i>{/if}</button>
{if $text}</span></span>{/if}
{* /angel *}
<input type="hidden" name="dispatch" value="{$but_name}" />