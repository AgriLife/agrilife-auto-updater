<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php _e( 'Auto Updates', 'agriflex' ); ?></h2><?php;

		if(get_site_transient('agrilife_auto_updater_triggered')){

			$transient = get_site_transient('agrilife_auto_updater_true');

			if($transient && gettype($transient) != 'string'){

				echo '<p>The following plugins were automatically updated at the listed times: <ol>';

				foreach ($transient as $key => $value) {

					if(gettype($value) == 'integer'){

						echo '<li>' . $key . ': ' . date('l jS \of F Y h:i:s A', $value) . '</li>';

					} else {

						echo '<li>' . $key . ': ' . $value . '</li>';

					}

				}

				echo '</ol></p>';

			} else {

				?><p>No plugins updated.</p><?php

			}

		} else {
			?><p>Plugins have not yet updated automatically.</p><?php
		}
	?>
	<p>All plugins not on this list will update automatically every 12 hours or so.<br>
		<ol>
			<?php
			$agau_plugins = array (
				'Advanced Custom Fields',
				'Advanced Custom Fields Pro',
				'Gravity Forms',
				'Relevanssi',
				'Soliloquy',
				'TablePress',
				'The Events Calendar',
				'The Events Calendar Pro',
				'User Role Editor Pro',
				'WP Document Revisions',
				'Remove Date from Permalink',
				'Remove Workflow States',
				'WP Google Maps',
				'WP Google Maps - Gold Add-on',
				'WP Google Maps - Pro Add-on',
				'Google Maps Builder'
			);
			foreach ($agau_plugins as $plugin) {
				echo '<li>' . $plugin . '</li>';
			}
			?>
		</ol>
	</p>
	<h2>Plugins returned in completion response</h2>
	<pre><?php print_r(get_site_transient('agrilife_auto_updater_plugins'));?></pre>
</div><!-- .wrap -->
