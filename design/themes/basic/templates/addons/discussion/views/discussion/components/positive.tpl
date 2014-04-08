<div>
{assign var="positive_rating" value=$object_id|fn_get_positive_rating_percentage:$object_type}
{$positive_rating}%&nbsp;{__("l_positive")}
</div>