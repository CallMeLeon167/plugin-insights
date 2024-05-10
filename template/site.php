<?php
function pi_render_site()
{
    $plugin_data = pi_get_plugin_info();
    global $wp_version;
?>
    <div class="wrap pi_site">
        <h2>Your Plugin Insights</h2>
        <h3>Currently installed plugins <button onclick="filterPlugins()" class="button">Show Updates Only</button></h3>
        <div class="table-container">
            <table class="modern-table" id="plugin-table">
                <thead>
                    <tr>
                        <th>Active</th>
                        <th>Name</th>
                        <th>Last Updated</th>
                        <th>Installed Version</th>
                        <th>Available Version</th>
                        <th>Requires WP Version</th>
                        <th>Required PHP Version</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plugin_data as $plugin) : extract($plugin) ?>
                        <tr class="<?php echo ($UpdateAvailable) ? 'update-available' : ''; ?>">
                            <td><?= $Active ?></td>
                            <td>
                                <a href="https://wordpress.org/plugins/<?= $Slug ?>" target="_blank" title="WordPress Plugin Page"><?= $Name ?></a>
                                <?php if ($InStore) : ?>
                                    <a href="<?= $PluginURI ?>" target="_blank" title="Visit Plugin Homepage">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 10px; width: 10px;">
                                            <path d="M320 0c-17.7 0-32 14.3-32 32s14.3 32 32 32h82.7L201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L448 109.3V192c0 17.7 14.3 32 32 32s32-14.3 32-32V32c0-17.7-14.3-32-32-32H320zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?= $LastUpdated ?></td>
                            <td><?= $Version ?></td>
                            <td class="<?= ($UpdateAvailable) ? 'pi_success' : '' ?>"><?= ($UpdateAvailable) ? $UpdateAvailable : "" ?></td>
                            <td class="<?= (version_compare($RequiresWP, (float)$wp_version, '<=') && $RequiresWP) ? 'pi_success' : 'pi_danger' ?>"><?= ($RequiresWP) ? $RequiresWP : 'Unknown' ?></td>
                            <td class="<?= (version_compare($RequiresPHP, (float)phpversion(), '<') && $RequiresPHP) ? 'pi_success' : 'pi_danger' ?>"><?= ($RequiresPHP) ? $RequiresPHP : 'Unknown' ?></td>
                            <td><?= $Rating ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
}
