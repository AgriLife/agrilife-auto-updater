<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php _e( 'Auto Updates', 'agriflex' ); ?></h2><?php;

		if(get_site_transient('agrilife_auto_updater_triggered')){

			echo '<p>Auto update action last triggered on ' . get_site_transient('agrilife_auto_updater_triggered') . '</p>';

			$transient1 = get_site_transient('agrilife_auto_updater_true');

			if($transient1 && gettype($transient1) != 'string'){

				echo '<p>Plugins which were included during the update action: <ol>';

				foreach ($transient1 as $key => $value) {
					echo '<li>' . $key . ': ' . $value . '</li>';
				}

				echo '</ol></p>';

			} else {

				?><p>Transient "agrilife_auto_updater_true" = <?php print_r($transient1); ?>.</p><?php

			}

			$transient2 = get_site_transient('agrilife_auto_updater_false');

			if($transient2 && gettype($transient2) != 'string'){

				?><p>Plugins which were skipped over during the update action: <ol><?php

				foreach ($transient2 as $key => $value) {
					echo '<li>' . $key . ': ' . $value . '</li>';
				}

				?></ol></p><?php

			} else {

				?><p>Transient "agrilife_auto_updater_false" = <pre><?php print_r($transient2); ?></pre>.</p><?php

			}

		} else {
			?><p>Auto update has not yet triggered.</p><?php
		}
	?>
	<p>All plugins not on this list will update automatically every 12 hours or so.<br>
		<ol>
			<?php
			$agau_plugins = array (
				'acf',
				'gravityforms',
				'relevanssi',
				'soliloquy',
				'tablepress',
				'events-calendar-pro',
				'the-events-calendar',
				'user-role-editor-pro',
				'wp-document-revisions',
				'remove-date-from-permalink',
				'remove-workflow-states',
				'wpGoogleMaps',
				'wp-google-maps-gold',
				'wp-google-maps-pro',
				'google-maps-builder'
			);
			foreach ($agau_plugins as $plugin) {
				echo '<li>' . $plugin . '</li>';
			}
			?>
		</ol>
	</p>
	<?php
		$aau_checked = get_site_transient('agrilife_auto_updater_checked');
		$aau_update_events = get_site_transient('agrilife_auto_updater_events');
		$aau_should_update = get_site_transient('agrilife_auto_updater_should_update');
		$aau_update_result = get_site_transient('agrilife_auto_updater_update_result');
		echo '<h2>Checked for Update:</h2><pre>';
		print_r($aau_checked);
		echo '</pre>';
		echo '<h2>Update Events:</h2><pre>';
		print_r($aau_update_events);
		echo '</pre>';
		echo '<h2>Results of Should Update Function:</h2><pre>';
		print_r($aau_should_update);
		echo '</pre>';
		echo '<h2>Results of Update Function:</h2><pre>';
		print_r($aau_update_result);
		echo '</pre>';
	?>
</div><!-- .wrap -->
