<div class="payment-details form-label-left text-fields-only">
    <div class="control-group">
        <label>{__("type")} : </label>
        <p>American Express</p>
    </div>
    <div class="control-group">
        <label>{__("number")} : </label>
        <p>************5672</p>
    </div>
    <div class="control-group">
        <label>{__("expiration_date")} : </label>
        <p>06/2014</p>
    </div>
    <div class="control-group">
        <label>{__("cardholder_name")} : </label>
        <p>Rahul Jairath</p>
    </div>
    <div class="control-group">
        <label>{__("billing_address")} : </label>
        <p>Rahul Jairath<br />
        1075 Mazzone Drive<br />
        San Jose, CA 95120<br />
        United States<br />
        +1 (408) 332 8032</p>
    </div>
    <div class="buttons-container clearfix">
        <div class="float-right">
            {include file="buttons/button.tpl" but_text=__("add_new_credit_card") but_href="spec_dev.update_card" but_id="but_id1"}
        </div>
        {include file="buttons/button.tpl" but_text=__("edit") but_href="spec_dev.update_card" but_id="but_id2"}
        {include file="buttons/button.tpl" but_text=__("delete") but_href="spec_dev.payment_details" but_id="but_id3" but_extra_class="submit"}
    </div>
</div>

{capture name="mainbox_title"}{__("my_payment_details")}{/capture}