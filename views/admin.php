<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php _e( 'Auto Updates', 'agriflex' ); ?></h2>
	<p><?php
		if(get_site_transient('agrilife_auto_updater_triggered')){
			echo 'Auto update action triggered on ' . get_site_transient('agrilife_auto_updater_triggered');
			?><br><p>Plugins which have updated automatically: <?php
				$transient1 = get_site_transient('agrilife_auto_updater_true');
				if($transient1 && gettype($transient1) != 'string'){
					echo '<ol>';
					foreach ($transient1 as $key => $value) {
						echo '<li>' . $key . ': ' . $value . '</li>';
					}
					echo '</ol>';
				} else {
					echo '<li>Transient "agrilife_auto_updater_true" not set, which means the action has not executed or no plugins were updated.</li>';
				}
			?></p>
			<p>Plugins which were skipped over during auto-update: <?php
				$transient2 = get_site_transient('agrilife_auto_updater_false');
				if($transient2 && gettype($transient2) != 'string'){
					echo '<ol>';
					foreach ($transient2 as $key => $value) {
						echo '<li>' . $key . ': ' . $value . '</li>';
					}
					echo '</ol>';
				} else {
					echo 'Transient "agrilife_auto_updater_false" not set, which means the action has not executed or no plugins were skipped over during the update.';
				}
			?></p><?php
		} else {
			echo 'Auto update has not yet triggered.';
		}
	?></p>
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
