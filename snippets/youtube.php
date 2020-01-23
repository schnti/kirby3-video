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
                    <p><?= t('schnti.video.text'); ?></p>
                    <button class="button is-success is-normal youtube-hint-button"><?= t('schnti.video.buttonText'); ?></button>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>