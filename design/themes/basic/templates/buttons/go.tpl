{* angel *}
{if $text}<span class="search-but"><span class="search-but-inside">{/if}
<button title="{$alt}"{if !$text} class="go-button"{/if} type="submit">{if !$text}<i class="icon-right-dir"></i>{/if}{if $but_text}{$but_text}{/if}</button>
{if $text}</span></span>{/if}
{* /angel *}
<input type="hidden" name="dispatch" value="{$but_name}" />