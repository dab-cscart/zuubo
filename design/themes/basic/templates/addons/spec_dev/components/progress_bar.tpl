<div id="star_bar_{$star}"></div>

<script type="text/javascript">
//<![CDATA[
var star = '{$star}',
    percent = '{$value_width}';
    
{literal}
 $( document ).ready( function() {
    $("#star_bar_" + star).progressbar({
	value: percent
    });
});
{/literal}

//]]>
</script>