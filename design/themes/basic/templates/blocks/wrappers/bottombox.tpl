{if $content|trim}
    <p><span>{$title nofilter}</span></p>
    {$content|default:"&nbsp;" nofilter}
{/if}