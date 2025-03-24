export const initVideoPlayer = ($) => {
    $(document).ready(function () {
        const $videoPlayer = $("#videoPlayer");
        const $playButton = $("#playButton");
        const $playIcon = $("#playIcon");
        const $pauseIcon = $("#pauseIcon");
        const $videoContainer = $("#videoContainer");

        function togglePlay() {
            if ($videoPlayer[0].paused) {
                $videoPlayer[0].play();
                $playIcon.addClass("hidden");
                $pauseIcon.removeClass("hidden");
                $playButton.addClass("opacity-0");
            } else {
                $videoPlayer[0].pause();
                $playIcon.removeClass("hidden");
                $pauseIcon.addClass("hidden");
                $playButton.removeClass("opacity-0");
            }
        }

        $videoPlayer.on("click", togglePlay);
        $playButton.on("click", togglePlay);

        $videoContainer.on("mouseover", function () {
            if (!$videoPlayer[0].paused) {
                $playButton.removeClass("opacity-0");
            }
        });

        $videoContainer.on("mouseout", function () {
            if (!$videoPlayer[0].paused) {
                $playButton.addClass("opacity-0");
            }
        });

        $videoPlayer.on("ended", function () {
            $playIcon.removeClass("hidden");
            $pauseIcon.addClass("hidden");
            $playButton.removeClass("opacity-0");
        });
    });
};
