<div class="youtube-container disabled <?= $class; ?>">
	<?php if (isset($id)) : ?>
		<?= $image; ?>
        <div class="embed-container" style="display: none; padding-bottom: <?= str_replace(',', '.', $image->height() / $image->width() * 100); ?>%">
            <iframe data-src="https://www.youtube-nocookie.com/embed/<?= $id; ?>"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen></iframe>
        </div>
        <div class="youtube-hint">
            <div class="youtube-hint-text">
                <div>
                    <p>Zum Aktivieren des Videos musst du auf den Link klicken. Wir möchten dich darauf hinweisen, dass nach der Aktivierung Daten an YouTube übermittelt
                        werden.</p>
                    <button class="button is-success is-normal youtube-hint-button">Video aktivieren</button>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>