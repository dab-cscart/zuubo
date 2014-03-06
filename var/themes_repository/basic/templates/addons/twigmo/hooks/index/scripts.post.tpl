{assign var="state" value=$smarty.session.twg_state}

{if $state.twg_can_be_used and !$state.mobile_link_closed}
    <script>
    //<![CDATA[
    {literal}
    $(function () {
        $('#close_notification_mobile_avail_notice').bind('click', function (e) {
            $(e.target).parents('div.mobile-avail-notice').hide();
            $.ajax({
                url: '{/literal}{fn_url("twigmo.post&close_notice=1") nofilter}{literal}',
                dataType: 'json'
            });
        });
        if(window.devicePixelRatio && window.devicePixelRatio > 1) {
            changeSizes();
        }
        function changeSizes(){
            var scale = 1,
                buttonsHeight = {/literal}{if $state.device == "ipad"}54{else}80{/if}{literal},
                fontSize = {/literal}{if $state.device == "ipad"}30{else}34{/if}{literal},
                crossWidth = 30,
                textPadding = {/literal}{if $state.device == "ipad"}'0 1% 0 1%'{else}'0 2% 0 2%'{/if}{literal};

            if (typeof window.orientation !== 'undefined' && Math.abs(window.orientation) === 90) {
                scale = 0.7;
                textPadding = '0 1% 0 1%';
            }
            $('.mobile-avail-notice a').css({'height': buttonsHeight * scale + 'px', 'line-height': buttonsHeight * scale + 'px', 'font-size': fontSize * scale + 'px', 'padding': textPadding});
            $('.mobile-avail-notice img').css({'width': crossWidth * scale + 'px !important', 'height': crossWidth * scale + 'px !important', 'margin-top': -1 * (crossWidth * scale/2) + 'px'});
        }
        window.onorientationchange = function () {
            changeSizes();
        };
        changeSizes();
    });
    {/literal}
    //]]>
    </script>
{/if}
