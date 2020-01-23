const classname = document.getElementsByClassName('youtube-hint-button');

Array.from(classname).forEach(function (element) {
    element.addEventListener('click', function () {

        const youtubeContainer = element.closest('.youtube-container');
        youtubeContainer.classList.remove('disabled');

        const img = youtubeContainer.getElementsByTagName('img')[0];
        img.style.display = 'none';

        const embed = youtubeContainer.getElementsByClassName('embed-container')[0];
        embed.style.display = 'block';

        console.log(embed);

        const frame = embed.children[0];
        frame.src = frame.dataset.src;
    });
});