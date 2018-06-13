<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php _e( 'Auto Updates', 'agriflex' ); ?></h2><?php;

		if(get_site_transient('agrilife_auto_updater_triggered')){

			$transient = get_site_transient('agrilife_auto_updater_true');

			if($transient && gettype($transient) != 'string'){

				echo '<p>Plugins which were included during the update action: <ol>';

				foreach ($transient as $key => $value) {
					echo '<li>' . $key . ': ' . $value . '</li>';
				}

				echo '</ol></p>';

			} else {

				?><p>No plugins updated.</p><?php

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
</div><!-- .wrap -->
