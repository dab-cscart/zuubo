{assign var="columns" value=4}
{if !$wishlist_is_empty}

    {script src="js/tygh/exceptions.js"}

    {assign var="show_hr" value=false}
    {assign var="location" value="cart"}
{/if}
{if $products}
    <div class="wishlist-container">
    {include file="blocks/list_templates/products_list.tpl" 
        show_name=true 
        show_sku=false 
        show_rating=true 
        show_features=true 
        show_prod_descr=true 
        show_old_price=true 
        show_price=true 
        show_clean_price=true 
        show_list_discount=true  
        show_product_amount=false 
        show_qty=false
        show_product_edp=true 
        show_add_to_cart=true  
        show_descr=true 
        but_role="action"
        but_text=__("buy_now")
        is_wishlist=true 
        no_sorting=true 
        show_sep_hr=true}
    </div>
{else}
{*
{math equation="100 / x" x=$columns|default:"2" assign="cell_width"}
<table class="fixed-layout multicolumns-list table-width {if $wishlist_is_empty}wish-list-empty{/if}">
    <tr class="row-border">
    {assign var="iteration" value=0}
    {capture name="iteration"}{$iteration}{/capture}
    {hook name="wishlist:view"}
    {/hook}
    {assign var="iteration" value=$smarty.capture.iteration}
    {if $iteration == 0 || $iteration % $columns != 0}
        {math assign="empty_count" equation="c - it%c" it=$iteration c=$columns}
        {section loop=$empty_count name="empty_rows"}
            <td class="product-spacer">&nbsp;</td>
            <td class="product-cell product-cell-empty valign-top" style="width: {$cell_width}%">
                <div>
                    <p>{__("empty")}</p>
                </div>
            </td>
            <td class="product-spacer">&nbsp;</td>
        {/section}
    {/if}

    </tr>
</table>
*}
<>
{/if}
{if !$wishlist_is_empty}
    <div class="buttons-container wish-list-btn">
        {include file="buttons/continue_shopping.tpl" but_href=$continue_url|fn_url but_role="submit" but_extra_class="submit"}
        {include file="buttons/button.tpl" but_text=__("clear_wishlist") but_href="wishlist.clear" but_extra_class="clear-but"}
    </div>
{else}
    <div class="buttons-container wish-list-btn wish-list-continue">
        {include file="buttons/continue_shopping.tpl" but_href=$continue_url|fn_url but_role="submit" but_extra_class="submit"}
    </div>
{/if}

{capture name="mainbox_title"}{__("my_wishlist")}{/capture}
