{hook name="blocks:sidebox_dropdown"}{strip}
{assign var="foreach_name" value="item_`$iid`"}

{foreach from=$items item="item" name=$foreach_name}

{hook name="blocks:sidebox_dropdown_element"}

    <li class="{if $separated && !$smarty.foreach.$foreach_name.last}b-border {/if}{if $item.$childs}dir{/if}{if $item.active || $item|fn_check_is_active_menu_item:$block.type} active{/if}">
    
        {if $item.$childs}
            <i class="icon-right-open"></i><i class="icon-left-open"></i>
            {hook name="blocks:sidebox_dropdown_childs"}
            <div class="menu-popup">
                <div class="clearfix">
                    <div class="column-1">
                        <div class="header-categ"><a href="">Nutrition & Weight Loss</a></div>
                        <p><a href="">Nutritionists</a>, <a href="">Trainers</a>, <a href="">Weight Loss</a>, <a href="">Meal Delivery</a>, <a href="">Supplements</a>,…</p>
                        <div class="header-categ"><a href="">Skin & Body Care</a></div>
                        <p><a href="">Aromatherapy</a>, <a href="">Day Spas</a>, <a href="">Laser Therapy</a>, <a href="">Tattoo Removal</a>,…</p>
                    </div>
                    <div class="column-2">
                        <div class="header-categ"><a href="">Cosmetic Treatments</a></div>
                        <p><a href="">Cosmetic Surgeons</a>, <a href="">Hair Loss</a>, <a href="">Laser Hair Removal</a>,…</p>
                        <div class="header-categ"><a href="">Therapeutic</a></div>
                        <p><a href="">Yoga</a>, <a href="">Tai Chi</a>, <a href="">Detox & Cleansing</a>, <a href="">Massage Therapy</a>, <a href="">Meditation</a>,…</p>
                    </div>
                    <div class="column-3">
                        <div class="header-categ"><a href="">Hot Deals</a></div>
                        <p><a href="">Laser Eye Surgery</a>, <a href="">Both Eyes for $999</a></p>
                        <p class="promo-image"><img src="{$images_dir}/promo_1.png" /><a class="promo-link">{__("shop_now")}</a></p>
                        <div class="header-categ"><a href="">Top Providers</a></div>
                        <p><a href="">Jenny Craig</a>, <a href="">NutriSystem starting $5 per day</a></p>
                        <p class="promo-image"><img src="{$images_dir}/promo_2.png" /><a class="promo-link">{__("shop_now")}</a></p>
                    </div>
                </div>
            {*
            <ul>
                {include file="blocks/sidebox_dropdown.tpl" items=$item.$childs separated=true submenu=true iid=$item.$item_id no_class=true}
            </ul>
            *}
            </div>
            {/hook}
        {/if}
        {assign var="item_url" value=$item|fn_form_dropdown_object_link:$block.type}
        <a{if $item_url} href="{$item_url}"{/if} {if $item.new_window}target="_blank"{/if}{if !$no_class} class="f-level"{/if}>{$item.$name}</a>
    </li>

{/hook}

{/foreach}
{/strip}{/hook}