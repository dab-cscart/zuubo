{if $is_wishlist}
<div class="wishlist-remove-item">
    <a href="{"wishlist.delete?cart_id=`$product.cart_id`"|fn_url}" class="remove" title="{__("remove")}">{__("remove")}</a>
</div>
{/if}