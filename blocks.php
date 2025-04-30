<?php
$blocks = get_field('all_blocks');
$blocks == '' ? $blocks = get_field('all_blocks', 'theme_' . get_queried_object()->term_id) : '';

if ($blocks) :
  $i = 1;

  foreach ($blocks as $block) :
    if ($block['acf_fc_layout'] == 'template1') :
      echo '<section id="sphere-' . $i . '" class="sphere section-bg">';
        $sphere_bg = $block['sphere_bg'];
        $bg_preview = $sphere_bg['bg_preview'];
        $bg_video = $sphere_bg['bg_video'];
        echo '<video class="sphere__bg" playsinline webkit-playsinline autoplay muted loop poster="'. $bg_preview .'">';
          echo '<source src="'. $bg_video .'" type="video/mp4">';
        echo '</video>';

        echo '<div class="sphere__container">';
          echo '<div class="sphere__main">';
            $info = $block['sphere-info'];
            $info_date = $info['info_date'];
            if ($info_date) :
              echo '<div class="sphere__heading">';
                echo '<div class="sphere__date">'. $info_date .'</div>';
              echo '</div>';
            endif;
            
            echo '<div class="sphere__about sphere-about">';
              echo '<div class="sphere-about__left">';
                $about_title = $block['about_title'];
                $sphere_logo = $block['sphere_logo'];
                if ($about_title) :
                  echo '<h1 class="sphere-about__title">';
                    echo '<span class="title-gradient">'. $about_title .'</span>';
                    if ($sphere_logo) :
                      echo '<div class="sphere-about__title-logo">';
                        echo '<img class="lazy-loaded-image lazy" src="data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20{{'. $sphere_logo['width'] .'}}%20{{'. $sphere_logo['height'] .'}}%22%3E%3C%2Fsvg%3E" data-lazy="'. $sphere_logo['url'] .'" alt="'. $sphere_logo['alt'] .'" width="'. $sphere_logo['width'] .'" height="'. $sphere_logo['height'] .'">';
                      echo '</div>';
                    endif;
                  echo '</h1>';
                endif;

                $info_caption = $info['info_caption'];
                $info_location = $info['info_location'];
                if ($info_caption || $info_date || $info_location) :
                  echo '<div class="sphere-about__info sphere-info">';
                    echo $info_caption != '' ? '<div class="sphere-info__caption">'. $info_caption .'</div>' : '';
                    echo $info_location != '' ? '<div class="sphere-info__location">'. $info_location .'</div>' : '';
                  echo '</div>';
                endif;
              echo '</div>';

              echo '<div class="sphere-about__right">';
                $about_schedule = $block['about_schedule'];
                $schedule_caption = $about_schedule['schedule_caption'];
                $schedule_list = $about_schedule['schedule_list'];
                echo '<div class="sphere-about__schedule sphere-schedule">';
                  echo $schedule_caption != '' ? '<div class="sphere-schedule__caption">'. $schedule_caption .'</div>' : '';
                  echo '<ul class="sphere-schedule__list">';
                    foreach ($schedule_list as $item) :
                      $schedule_time = $item['schedule_time'];
                      $schedule_name = $item['schedule_name'];

                      echo '<li class="sphere-schedule__item">';
                        echo '<div class="sphere-schedule__time">'. $schedule_time .'</div>';
                        echo '<div class="sphere-schedule__name">'. $schedule_name .'</div>';
                      echo '</li>';
                    endforeach;
                  echo '</ul>';
                echo '</div>';

                $about_button = $block['about_button'];
                echo '<div class="sphere-about__button">';
                  echo '<button type="button" class="btn btn_bg-white" data-popup="#registration">'. $about_button .'</button>';
                echo '</div>';
              echo '</div>';
            echo '</div>';
          echo '</div>';
        echo '</div>';
      echo '</section>';
    elseif ($block['acf_fc_layout'] == 'template2') :
      $location_title = $block['location_title'];
      $location_subtitle = $block['location_subtitle'];
      $location_map = $block['location_map'];

      echo '<section id="location-' . $i . '" class="section-bg location">';
        echo '<div class="location__container">';
          echo '<div class="location__heading">';
            echo $location_title != '' ? '<h2 class="location__title">'. $location_title .'</h2>' : '';
            echo $location_subtitle != '' ? '<h3 class="location__subtitle">'. $location_subtitle .'</h3>' : '';
          echo '</div>';

          echo '<div class="location__map">';
            echo $location_map;
          echo '</div>';
        echo '</div>';
      echo '</section>';
    elseif ($block['acf_fc_layout'] == 'template0') :
      $heading = $block['template0_heading'];

      echo '<section id="template0-' . $i . '" class="template0">';
        echo '<div class="template0__container">';
          echo $heading != '' ? '<div class="template0__heading _content">' . $heading . '</div>' : '';
        echo '</div>';
      echo '</section>';
    endif;
  endforeach;
  else :
    echo '<section id="template0-' . $i . '" class="template0">';
      echo '<div class="template0__container _content">';
        the_content();
      echo '</div>';
    echo '</section>';

endif;
