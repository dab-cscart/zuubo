{if $content|trim}
    <div class="testimonial-grid">
    <h2>{$title nofilter}</h2>
    {$content|default:"&nbsp;" nofilter}
    </div>
{/if}