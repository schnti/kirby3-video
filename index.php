<?php

use Kirby\Cms\File;
use Kirby\Toolkit\F;
use Kirby\Toolkit\Tpl;

Kirby::plugin('schnti/video', [
	'translations' => [
		'de' => [
			'schnti.video.text'       => 'Klicke zum Aktivieren des Videos auf den Link. Wir möchten darauf hinweisen, dass nach der Aktivierung Daten an YouTube übermittelt werden',
			'schnti.video.buttonText' => 'Video aktivieren',
			'schnti.video.linkText'   => 'oder auf YouTube anschauen',
			'schnti.video.id'         => 'YouTube ID:',
		],
		'en' => [
			'schnti.video.text'       => 'Click the button to activate the video. Then a connection to YouTube is established.',
			'schnti.video.buttonText' => 'Activate video',
			'schnti.video.linkText'   => 'or watch on youtube',
			'schnti.video.id'         => 'YouTube ID:',
		]
	],
	'tags'         => [
		'youtube' => [
			'attr' => array(
				'class',
				'width',
			),
			'html' => function ($tag) {

				preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $tag->value, $match);

				if (isset($match[1])) {
					$id = $match[1];
				} else {
					$id = $tag->value;
				}

				$class = $tag->class;
				$width = ($tag->width) ? $tag->width : 1000;

				$imageUrl = 'https://i.ytimg.com/vi/' . $id . '/maxresdefault.jpg';

				$filename = F::safeName('youtube_' . $id . '.jpg');
				$path = $tag->parent()->root() . DS . $filename;

				if (!file_exists($path)) {
					file_put_contents($path, file_get_contents($imageUrl));
				}

				$image = new File([
					'source'   => file_get_contents($path),
					'filename' => $filename,
					'parent'   => $tag->parent()
				]);

				if (isset($image)) {

					$image->resize($width);

					return Tpl::load(__DIR__ . DS . 'snippets' . DS . 'youtube.php', [
						'class' => $class,
						'id'    => $id,
						'image' => $image,
						'width' => $width
					]);
				}

				return 'YouTube Video not found';
			}
		]
	]
]);