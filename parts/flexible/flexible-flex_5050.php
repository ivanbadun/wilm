<?php
$side = get_sub_field('text_side');
$media_type = get_sub_field('media_type');
$display_mode = get_sub_field('display_mode');

$row_class = ($side == 'right') ? 'flex-row-reverse' : '';
$mode_class = ($display_mode == 'fit') ? 'gradient-overlay' : '';
$img_object_class = ($display_mode == 'fit') ? 'img-contain' : 'img-cover';
?>

<section class="module-section">
    <div class="container">
        <div class="content-module-50-50 <?php echo $row_class; ?> <?php echo $mode_class; ?>">

            <div class="module-column text-column career-details">
                <?php the_sub_field('editor_content'); ?>
            </div>

            <div class="module-column media-column">
                <div class="media-wrapper">
                    <?php if ( $media_type == 'image' ) :
                        $img = get_sub_field('image_field'); ?>
                        <img src="<?php echo esc_url($img['url']); ?>"
                             class="<?php echo $img_object_class; ?>"
                             alt="<?php echo esc_attr($img['alt'] ?? ''); ?>">

                    <?php else :
                        $video_url = get_sub_field('video_url');
                        $video_html = wp_oembed_get($video_url);

                        if ($video_html) {
                            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                $video_html = preg_replace('/src="([^"]+)"/', 'src="$1&autoplay=1&mute=1&controls=1&rel=0&modestbranding=1"', $video_html);
                            } elseif (strpos($video_url, 'vimeo.com') !== false) {
                                $video_html = preg_replace('/src="([^"]+)"/', 'src="$1?autoplay=1&muted=1&controls=1"', $video_html);
                            }
                            echo $video_html;
                        }
                    endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>