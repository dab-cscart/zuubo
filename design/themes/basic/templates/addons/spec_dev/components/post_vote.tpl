<div class="post-vote" id="vote_helpful_{$post_id}">
    {$votes_stat = $post_id|fn_get_post_votes_stat}
    {__("was_this_review_helpful")}&nbsp;&nbsp;{if $value != 'Y'}<a href="{"spec_dev.rate_post?post_id=`$post_id`&v=Y"|fn_url}" class="download-link cm-ajax" data-ca-target-id="vote_helpful_{$post_id}">{else}<em>{/if}{__("yes")}({$votes_stat.positive}){if $value != 'Y'}</a>{else}</em>{/if}|{if $value != 'N'}<a href="{"spec_dev.rate_post?post_id=`$post_id`&v=N"|fn_url}" class="download-link cm-ajax" data-ca-target-id="vote_helpful_{$post_id}">{else}<em>{/if}{__("no")}({$votes_stat.negative}){if $value != 'N'}</a>{else}</em>{/if}{if $votes_stat.all}&nbsp;{$votes_stat.prc}%&nbsp;{__("are_positive")}{/if}
<!--vote_helpful_{$post_id}--></div>
