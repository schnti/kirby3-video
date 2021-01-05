<?php

use Kirby\Cms\File;
use Kirby\Toolkit\F;

function parseYoutube(string $url) {
    $data = [];

    # Extract YouTube video ID
    # See http://stackoverflow.com/questions/2936467/parse-youtube-video-id-using-preg-match
    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[\w\-?&!#=,;]+/[\w\-?&!#=/,;]+/|(?:v|e(?:mbed)?)/|[\w\-?&!#=,;]*[?&]v=)|youtu\.be/)([\w-]{11})(?:[^\w-]|\Z)%i', $url, $match);
    $data['id'] = $match[1] ?? $url;

    # Extract YouTube playlist ID
    # See https://stackoverflow.com/questions/5115233/fetching-youtube-playlist-id-with-php-regex
    $parts = parse_url($url);

    if (isset($parts['query'])) {
        parse_str($parts['query'], $query);

        if (isset($query['list'])) {
            $data['playlist'] = $query['list'];
        }
    }

    # Build embed URL
    $data['src'] = 'https://www.youtube-nocookie.com/embed/' . $data['id'] . '?autoplay=1';

    if (isset($data['playlist'])) {
        $data['src'] = 'https://www.youtube-nocookie.com/embed/videoseries?list=' . $data['playlist'] . '&autoplay=1';
    }

    return $data;
}


Kirby::plugin('schnti/video', [
	'translations' => [
		'de' => [
			'schnti.video.headline'   => 'Wir respektieren deinen Datenschutz!',
			'schnti.video.text'       => 'Klicke zum Aktivieren des Videos auf den Link. Wir möchten darauf hinweisen, dass nach der Aktivierung deine Daten an YouTube übermittelt werden',
			'schnti.video.buttonText' => 'Video aktivieren',
			'schnti.video.linkText'   => 'oder auf YouTube anschauen',
			'schnti.video.id'         => 'YouTube ID:',
		],
		'en' => [
			'schnti.video.headline'   => 'We respect your privacy!',
			'schnti.video.text'       => 'Click the button to activate the video. Then a connection to YouTube is established.',
			'schnti.video.buttonText' => 'Activate video',
			'schnti.video.linkText'   => 'or watch on youtube',
			'schnti.video.id'         => 'YouTube ID:',
		]
	],
	'snippets'     => [
		'youtube' => __DIR__ . '/snippets/youtube.php',
	],
	'tags'         => [
		'youtube' => [
			'attr' => array(
				'class',
				'width',
			),
			'html' => function ($tag) {

				$data = parseYoutube($tag->value);

				$class = $tag->class;
				$width = ($tag->width) ? $tag->width : 1000;

				$imageUrl = 'https://i.ytimg.com/vi/' . $data['id'] . '/maxresdefault.jpg';

				$filename = F::safeName('youtube_' . $data['id'] . '.jpg');
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

					return snippet('youtube', [
						'class' => $class,
						'id'    => $data['id'],
						'src'   => $data['src'],
						'image' => $image,
						'width' => $width
					]);
				}

				return 'YouTube Video not found';
			}
		]
	]
]);
