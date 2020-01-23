<?php

use Kirby\Toolkit\F;
use Kirby\Toolkit\Tpl;

Kirby::plugin('schnti/video', [
	'tags' => [
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

				$image = image($tag->parent()->id() . DS . $filename);

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