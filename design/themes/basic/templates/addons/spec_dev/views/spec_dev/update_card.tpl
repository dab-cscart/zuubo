<div class="update-card">
<form class="form-label-left form-wrap">
    <div class="control-group">
        <label class="cm-required">Credit or Debit Card #:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">Cardholder’s Name:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">Expiration Date: </label>
        <input type="text" class="input-text-small" /><input type="text" class="input-text-small" />
    </div>
    <div class="control-group">
        <label class="cm-required">Address Line 1:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label>Address Line 2:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">City:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">State:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">Zip Code:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">Phone Number:</label>
        <input type="text" class="input-text" />
    </div>
    <div class="control-group">
        <label class="cm-required">Country:</label>
        <input type="text" class="input-text" />
    </div>
    
    <div class="buttons-container clearfix">
        <div class="float-right">
            {include file="buttons/button.tpl" but_text=__("save_card") but_href="spec_dev.update_card" but_id="but_id1"}
            {include file="buttons/button.tpl" but_text=__("cancel") but_href="spec_dev.update_card" but_id="but_id1" but_extra_class="submit"}
        </div>
        <p><input type="checkbox" class="checkbox" /><label>{__("make_primary_card")}</label></p>
    </div>
</form>

{capture name="mainbox_title"}{__("add_edit_card")}{/capture}