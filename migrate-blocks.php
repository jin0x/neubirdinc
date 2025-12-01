<?php
/**
 * Migration script to update AWS block names to generic names
 * 
 * Access via browser: http://localhost:10013/wp-content/themes/neubird/migrate-blocks.php
 * Make sure you're logged in as an administrator first!
 */

// Load WordPress - try multiple paths
$possible_paths = [
    dirname(dirname(dirname(__DIR__))) . '/wp-load.php',
    dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php',
    __DIR__ . '/../../../wp-load.php',
    __DIR__ . '/../../../../wp-load.php',
];

$wp_loaded = false;
foreach ($possible_paths as $path) {
    if (file_exists($path)) {
        require_once($path);
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded || !function_exists('get_current_user_id')) {
    die('WordPress not loaded. Please check the path or run this from WordPress admin.');
}

// Check permissions (only allow admin users)
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You must be logged in as an administrator to run this script. <a href="' . wp_login_url($_SERVER['REQUEST_URI']) . '">Log in</a>');
}

// Block name mappings
$block_mappings = [
    'acf/aws-hero-timeline' => 'acf/hero-timeline',
    'acf/aws-features-grid' => 'acf/features-grid',
    'acf/aws-how-it-works' => 'acf/how-it-works',
    'acf/aws-cta-retire-war-room' => 'acf/cta-retire-war-room',
];

global $wpdb;
$updated_count = 0;
$posts_updated = [];
$errors = [];

// Get all posts and pages that contain AWS blocks
$posts = $wpdb->get_results($wpdb->prepare("
    SELECT ID, post_title, post_content, post_type 
    FROM {$wpdb->posts} 
    WHERE post_status = 'publish' 
    AND (post_type = 'post' OR post_type = 'page')
    AND post_content LIKE %s
", '%acf/aws-%'));

?>
<!DOCTYPE html>
<html>
<head>
    <title>Block Migration</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #f1f1f1;
        }
        .container {
            background: #fff;
            padding: 30px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        h2 {
            color: #23282d;
            border-bottom: 1px solid #dadada;
            padding-bottom: 10px;
        }
        p {
            margin: 15px 0;
            line-height: 1.6;
        }
        ul {
            list-style: disc;
            margin-left: 30px;
        }
        .success {
            color: #008c61;
            font-weight: 600;
        }
        .error {
            color: #d00;
            font-weight: 600;
        }
        .info {
            background: #f0f6fc;
            border-left: 4px solid #2271b1;
            padding: 12px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background: #2271b1;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 3px;
            margin-top: 20px;
        }
        .button:hover {
            background: #135e96;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Migrating AWS Block Names to Generic Names</h2>
        
        <?php if (empty($posts)): ?>
            <div class="info">
                <p class="success">✓ No posts found with old AWS block names. Migration not needed.</p>
            </div>
        <?php else: ?>
            <p>Found <strong><?php echo count($posts); ?></strong> post(s)/page(s) to check.</p>
            <hr>

            <?php
            foreach ($posts as $post) {
                $original_content = $post->post_content;
                $updated_content = $original_content;
                $post_updated = false;
                $changes = [];
                
                // Replace each old block name with new one
                foreach ($block_mappings as $old_name => $new_name) {
                    if (strpos($updated_content, $old_name) !== false) {
                        $count = substr_count($updated_content, $old_name);
                        $updated_content = str_replace($old_name, $new_name, $updated_content);
                        $post_updated = true;
                        $changes[] = "'{$old_name}' → '{$new_name}' ({$count} occurrence(s))";
                    }
                }
                
                // Update the post if content changed
                if ($post_updated) {
                    $result = $wpdb->update(
                        $wpdb->posts,
                        ['post_content' => $updated_content],
                        ['ID' => $post->ID],
                        ['%s'],
                        ['%d']
                    );
                    
                    if ($result !== false) {
                        // Clear post cache
                        clean_post_cache($post->ID);
                        
                        $updated_count++;
                        $posts_updated[] = [
                            'title' => $post->post_title,
                            'id' => $post->ID,
                            'type' => $post->post_type,
                            'changes' => $changes
                        ];
                        
                        echo "<p class='success'>✓ Updated: <strong>{$post->post_title}</strong> (ID: {$post->ID}, Type: {$post->post_type})</p>";
                        echo "<ul>";
                        foreach ($changes as $change) {
                            echo "<li>{$change}</li>";
                        }
                        echo "</ul>";
                    } else {
                        $errors[] = "Failed to update: {$post->post_title} (ID: {$post->ID})";
                        echo "<p class='error'>✗ Failed to update: <strong>{$post->post_title}</strong> (ID: {$post->ID})</p>";
                    }
                }
            }
            ?>
            
            <hr>
            <h3>Migration Complete!</h3>
            <p><strong><?php echo $updated_count; ?></strong> post(s)/page(s) updated successfully.</p>
            
            <?php if (!empty($errors)): ?>
                <div class="info" style="border-left-color: #d00;">
                    <p class="error"><strong><?php echo count($errors); ?></strong> error(s) occurred:</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li class="error"><?php echo esc_html($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($posts_updated)): ?>
                <h4>Updated Posts/Pages:</h4>
                <ul>
                    <?php foreach ($posts_updated as $item): ?>
                        <li><strong><?php echo esc_html($item['title']); ?></strong> (ID: <?php echo $item['id']; ?>, Type: <?php echo $item['type']; ?>)</li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>

        <hr>
        <p><a href="<?php echo admin_url(); ?>" class="button">← Return to WordPress Admin</a></p>
        <div class="info">
            <p><strong>Next Steps:</strong></p>
            <ol>
                <li>Refresh your page editor</li>
                <li>The blocks should now appear correctly with the new generic names</li>
                <li>Your content is preserved - only the block names have been updated</li>
            </ol>
        </div>
    </div>
</body>
</html>
