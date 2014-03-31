<div id="star_bar_{$star}"   style="display: inline-block;width: 200px; height: 15px;"></div>

{scripts}
<script type="text/javascript">
//<![CDATA[
var star = '{$star}';
var percent = '{$value_width}';
    
{literal}
(function(_, $) {
    $("#star_bar_" + star).progressbar({
	value: parseFloat(percent),
    });
}(Tygh, Tygh.$));
{/literal}

//]]>
</script>
{/scripts}