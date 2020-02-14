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
                    <button class="youtube-hint-button"><?= t('schnti.video.buttonText'); ?></button>
                    <small><a href="https://www.youtube.com/watch?v=<?= $id; ?>" class="youtube-hint-link" target="_blank"><?= t('schnti.video.linkText'); ?></a></small>
                </div>
            </div>
        </div>
	<?php endif; ?>
</div>