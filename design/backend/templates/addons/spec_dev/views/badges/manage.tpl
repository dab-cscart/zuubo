{capture name="mainbox"}

<form action="{""|fn_url}" method="post" name="badges_form" class="{if $runtime.company_id} cm-hide-inputs{/if}">

{include file="common/pagination.tpl" save_current_page=true save_current_url=true}

{if $badges}
<table width="100%" class="table table-middle">
<thead>
<tr>
    <th width="1%">{include file="common/check_items.tpl"}</th>
    <th width="60%">{__("badge")}</th>
    <th width="5%">&nbsp;</th>
</tr>
</thead>
{foreach from=$badges item=badge}
<tr class="cm-row-status-{$badge.status|lower}">
    <td>
        <input type="checkbox" name="badge_ids[]" value="{$badge.badge_id}" class="checkbox cm-item" /></td>
    <td>
        <a class="row-status cm-external-click" data-ca-external-click-id="{"opener_group`$badge.badge_id`"}">{$badge.badge}</a>
	</td>
    <td class="nowrap">
        {capture name="tools_list"}
			<li>{include file="common/popupbox.tpl" id="group`$badge.badge_id`" text=$badge.badge link_text=__("edit") act="link" href="badges.update?badge_id=`$badge.badge_id`"}</li>
            <li>{btn type="list" class="cm-confirm" text=__("delete") href="badges.delete?badge_id=`$badge.badge_id`"}</li>
        {/capture}
        <div class="hidden-tools">
            {dropdown content=$smarty.capture.tools_list}
        </div>
    </td>
</tr>
{/foreach}
</table>
{else}
    <p class="no-items">{__("no_data")}</p>
{/if}

{include file="common/pagination.tpl"}

</form>


    {capture name="add_new_picker"}

    <form action="{""|fn_url}" method="post" name="add_badges_form" class="form-horizontal form-edit">
    <input type="hidden" name="badge_id" value="0" />

    <div class="cm-j-tabs">
        <ul class="nav nav-tabs">
            <li id="tab_new_badges" class="cm-js active"><a>{__("general")}</a></li>
        </ul>
    </div>

    <div class="cm-tabs-content">
    <fieldset>
        <div class="control-group">
            <label class="control-label" for="elm_badge_name">{__("badge")}:</label>
            <div class="controls">
            <input type="text" id="elm_badge_name" name="badge_data[badge]" size="55" value="" />
            </div>
        </div>

    </fieldset>
    </div>

    <div class="buttons-container">
        {include file="buttons/save_cancel.tpl" create=true but_name="dispatch[badges.update]" cancel_action="close"}
    </div>

	</form>

{/capture}


{capture name="buttons"}
    {capture name="tools_list"}
        {hook name="badges:manage_tools_list"}
            {if $badges}
                <li>{btn type="delete_selected" dispatch="dispatch[badges.m_delete]" form="badges_form"}</li>
            {/if}
        {/hook}
    {/capture}
    {dropdown content=$smarty.capture.tools_list}

    {if $badges}
        {include file="buttons/save.tpl" but_name="dispatch[badges.m_update]" but_role="submit-link" but_target_form="badges_form"}
    {/if}
{/capture}

{capture name="adv_buttons"}
    {include file="common/popupbox.tpl" id="new_badge" action="badges.add" text=$title content=$smarty.capture.add_new_picker title=__("add_badge") act="general" icon="icon-plus"}
{/capture}

{/capture}
{include file="common/mainbox.tpl" title=__("badges") content=$smarty.capture.mainbox adv_buttons=$smarty.capture.adv_buttons buttons=$smarty.capture.buttons select_languages=true}