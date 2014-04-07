{** block-description:search_page_title **}
{if $search}
    {assign var="_title" value=__("search_results")}
    {assign var="_collapse" value=true}
{else}
    {assign var="_title" value=__("advanced_search")}
    {assign var="_collapse" value=false}
{/if}
{assign var="title_extra" value="`$search.total_items` {__("results")}"}
<h1 class="category-mainbox-title"><span>{$_title} <span class="extra">({$title_extra})</span></span></hi>
