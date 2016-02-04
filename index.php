<!DOCTYPE html>

<?php require('config.php'); ?>

<html>
  <head>
    <title>Projetos</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimal-ui,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="content-language" content="pt-br">

    <link rel="shortcut icon" href="img/favicons/home.png" type="image/x-icon" />

    <link rel="stylesheet" href="css/main.css" type="text/css">
  </head>

  <body>

    <?php

      $projects = array();

      foreach ( $dir as $d ) {

        $dirsplit = explode('/', $d);
        $dirname = $dirsplit[count($dirsplit)-2];

        foreach( glob( $d ) as $file ) {

          $project = basename($file);

          if ( in_array( $project, $hiddensites ) ) continue;


          $siteroot = sprintf( 'http://%1$s.%3$s', $project, $dirname, $tld );

          // Display an icon for the site
          $icon_output = '<span class="no-img"></span>';

          if ( !file_exists( 'img/favicons/' . $project . '.png' ) ) {

            foreach ( $icondirs as $icondir ) {
              foreach( $icons as $icon ) {

                if ( file_exists( $file . '/' . $icondir . $icon ) ) {

                  copy($file . '/' . $icondir . $icon , 'img/favicons/' . $project . '.png');

                  $icon_output = sprintf( '<img src="img/favicons/%1$s.png">', $project);
                  break;
                } // if ( file_exists( $file . '/' . $icon ) )

              } // foreach( $icons as $icon )
            } // foreach( $icondirs as $icondir )

          } else {
            $icon_output = sprintf( '<img src="img/favicons/%1$s.png">', $project);
          }

          // echo $icon_output;

          // Display a link to the site
          $displayname = $project;
          if ( array_key_exists( $project, $siteoptions ) ) {
            if ( is_array( $siteoptions[$project] ) )
              $displayname = array_key_exists( 'displayname', $siteoptions[$project] ) ? $siteoptions[$project]['displayname'] : $project;
            else
              $displayname = $siteoptions[$project];
          }

          // printf( '<a class="site" href="%1$s" target="_blank">%2$s</a>', $siteroot, $displayname );

          // Display an icon with a link to the admin area
          $adminurl = '';
          // We'll start by checking if the site looks like it's a WordPress site
          if ( is_dir( $file . '/wp-admin' ) )
            $adminurl = sprintf( '%1$s/wp-admin', $siteroot );
          elseif ( is_dir( $file . '/app' ) )
            $adminurl = sprintf( '%1$s/', $siteroot );

          // If the user has defined an adminurl for the project we'll use that instead
          if (isset($siteoptions[$project]) &&  is_array( $siteoptions[$project] ) && array_key_exists( 'adminurl', $siteoptions[$project] ) )
            $adminurl = $siteoptions[$project]['adminurl'];


          if (is_dir( $file . '/wp-admin' ))
            $sitetype = 'wordpress';
          elseif (is_dir( $file . '/app' ))
            $sitetype = 'rails';
          else
            $sitetype = 'html';

          $project_property = array();

          $project_property['name'] = $project;

          if (isset($siteoptions[$project]) &&  is_array( $siteoptions[$project] ) && array_key_exists( 'fullname', $siteoptions[$project] ) ) {
            $project_property['fullname'] = $siteoptions[$project]['fullname'];
          } else {
            $project_property['fullname'] = $project;
          }

          $project_property['url'] = $siteroot;
          $project_property['type'] = $sitetype;
          $project_property['admin-url'] = $adminurl;

          if (isset($siteoptions[$project]) &&  is_array( $siteoptions[$project] ) && array_key_exists( 'color', $siteoptions[$project] ) ) {
            $project_property['color'] = $siteoptions[$project]['color'];
          } else {
            $project_property['color'] = '#279ad6';
          }

          if (isset($siteoptions[$project]) &&  is_array( $siteoptions[$project] ) && array_key_exists( 'git-repo', $siteoptions[$project] ) ) {
            $project_property['git-repo'] = $siteoptions[$project]['git-repo'];
          }

          $projects[$project] = $project_property;

        } // foreach( glob( $d ) as $file )

      } // foreach ( $dir as $d )

    ?>

    <section id="projects">
      <div class="container-fluid">

        <?php
          $loopindex = 0;

          foreach ( $projects as $project ) {

            $loopindex += 1;
            $rowfinder = $loopindex % 3;
            $rowcolor = $loopindex % 2;
            $rowcolorclass = '';

            if ($rowcolor == 0) {
              $rowcolorclass = 'light';
            } else {
              $rowcolorclass = 'dark';
            }

            ?>

            <?php if ($rowfinder == 1): ?>
              <div class="row">
              <?php $almost_last = $loopindex + 1; ?>

              <?php if ($loopindex == count($projects)): ?>
                <div class="col-md-4 col-md-offset-4">
              <?php elseif ($almost_last == count($projects)): ?>
                <div class="col-md-4 col-md-offset-2">
              <?php else: ?>
                <div class="col-md-4">
              <?php endif; ?>

                <div class="project <?php echo $rowcolorclass; ?>">
                  <div class="image-wrap">

                    <a href="<?php echo $project['url']; ?>" target='_blank'>
                      <div class="screenshot site">
                        <div class="top-bar"><span class="traffic-lights"></span></div>

                        <?php if ( file_exists( 'img/screenshots/' . $project['name'] . '-'. $project['type'] . '.png' ) ): ?>
                          <img src="img/screenshots/<?php echo $project['name']; ?>-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php else: ?>
                          <img src="img/screenshots/default-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php endif; ?>
                      </div>
                    </a>

                  </div>

                  <div class="text-wrap">
                    <div class="text-wrap-inner">
                      <a class="link-title" href="<?php echo $project['url']; ?>" target='_blank'>
                        <h3 class="title"><?php echo $project['fullname']; ?></h3>
                        <span class="project-type"><?php echo $project['type']; ?></span>
                        <?php if (false)://(array_key_exists('git-repo', $project)): ?>
                          <span class="project-type"><a href="<?php echo $project['git-repo']; ?>" target="_blank">GIT REPO</a></span>
                        <?php endif; ?>
                      </a>

                      <div class="text-wrap-color" style="background-color: <?php echo $project['color']; ?>"></div>
                    </div>
                  </div>
                </div>


              </div>
            <?php elseif ($rowfinder == 0): ?>
              <div class="col-md-4">

                <div class="project <?php echo $rowcolorclass; ?>">
                  <div class="image-wrap">

                    <a href="<?php echo $project['url']; ?>" target='_blank'>
                      <div class="screenshot site">
                        <div class="top-bar"><span class="traffic-lights"></span></div>

                        <?php if ( file_exists( 'img/screenshots/' . $project['name'] . '-'. $project['type'] . '.png' ) ): ?>
                          <img src="img/screenshots/<?php echo $project['name']; ?>-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php else: ?>
                          <img src="img/screenshots/default-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php endif; ?>
                      </div>
                    </a>

                  </div>

                  <div class="text-wrap">
                    <div class="text-wrap-inner">
                      <a class="link-title" href="<?php echo $project['url']; ?>" target='_blank'>
                        <h3 class="title"><?php echo $project['fullname']; ?></h3>
                        <span class="project-type"><?php echo $project['type']; ?></span>
                        <?php if (false)://(array_key_exists('git-repo', $project)): ?>
                          <span class="project-type"><a href="<?php echo $project['git-repo']; ?>" target="_blank">GIT REPO</a></span>
                        <?php endif; ?>
                      </a>

                      <div class="text-wrap-color" style="background-color: <?php echo $project['color']; ?>"></div>
                    </div>
                  </div>
                </div>


              </div>
              </div>
            <?php else: ?>
              <div class="col-md-4">
                <div class="project <?php echo $rowcolorclass; ?>">
                  <div class="image-wrap">

                    <a href="<?php echo $project['url']; ?>" target='_blank'>
                      <div class="screenshot site">
                        <div class="top-bar"><span class="traffic-lights"></span></div>

                        <?php if ( file_exists( 'img/screenshots/' . $project['name'] . '-'. $project['type'] . '.png' ) ): ?>
                          <img src="img/screenshots/<?php echo $project['name']; ?>-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php else: ?>
                          <img src="img/screenshots/default-<?php echo $project['type']; ?>.png" class="main-image">
                        <?php endif; ?>
                      </div>
                    </a>

                  </div>

                  <div class="text-wrap">
                    <div class="text-wrap-inner">
                      <a class="link-title" href="<?php echo $project['url']; ?>" target='_blank'>
                        <h3 class="title"><?php echo $project['fullname']; ?></h3>
                        <span class="project-type"><?php echo $project['type']; ?></span>
                        <?php if (false)://(array_key_exists('git-repo', $project)): ?>
                          <span class="project-type"><a href="<?php echo $project['git-repo']; ?>" target="_blank">GIT REPO</a></span>
                        <?php endif; ?>
                      </a>

                      <div class="text-wrap-color" style="background-color: <?php echo $project['color']; ?>"></div>
                    </div>
                  </div>
                </div>


              </div>
            <?php endif;

            }

        ?>

      </div>
    </section>
  </body>
</html>

