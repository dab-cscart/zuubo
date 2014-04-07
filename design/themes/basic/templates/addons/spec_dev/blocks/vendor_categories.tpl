<div class="clearfix">
    <ul id="vmenu_{$block.block_id}" class="dropdown dropdown-vertical{if $block.properties.right_to_left_orientation =="Y"} rtl{/if}">
        {* angel *}
        {include file="blocks/sidebox_dropdown.tpl" items=$company_categories separated=false submenu=false name="category" item_id="category_id" childs="subcategories"}
        {* /angel *}
    </ul>
</div>
