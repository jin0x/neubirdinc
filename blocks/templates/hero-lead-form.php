<?php
/*
 * Hero + Lead Form Block Template
 * Structure:
 * - Left Column: headline, description, primary CTA
 * - Right Column: Gravity Form inside a card (defaults to ID 7)
 *
 * ACF Fields (group_hero_lead_form):
 * - logo_1 (image) — first logo
 * - logo_2 (image) — second logo
 * - headline (text)
 * - description (wysiwyg)
 * - cta_text (text)
 * - cta_url (url)
 * - cta_new_tab (true_false)
 * - (removed) cta_source
 * - (removed) hero_flex
 * - gravity_form (select) — selected GF id
 * - form_id (number) — default 7 (fallback)
 * - (removed) form_panel_title
 */

// Ensure ACF is available
if (!function_exists('get_field')) {
    return;
}

$logo_1      = get_field('logo_1');
$logo_2      = get_field('logo_2');
$heading_subtitle = get_field('heading_subtitle');
$headline    = get_field('headline');
$heading_level_raw = get_field('heading_level') ?: 'h1';
$description = get_field('description');
$cta_text    = get_field('cta_text');
$cta_url     = get_field('cta_url');
$cta_new_tab = get_field('cta_new_tab');
$selected_form   = get_field('gravity_form');
$form_id         = $selected_form ?: get_field('form_id');

// Fallbacks
if (!$form_id) {
    $form_id = 7;
}

$target_attr = $cta_new_tab ? ' target="_blank" rel="noopener"' : '';

// Optional second CTA
$cta_2_text = get_field('cta_2_text');
$cta_2_url  = get_field('cta_2_url');
$cta_2_new_tab = get_field('cta_2_new_tab');
$target2_attr = $cta_2_new_tab ? ' target="_blank" rel="noopener"' : '';

// Section ID: allow optional override via ACF for in-page jump links
$section_id_raw = get_field('section_id');
$section_id_sanitized = '';
if ($section_id_raw) {
    $section_id_sanitized = strtolower(preg_replace('/[^a-zA-Z0-9\-]/', '-', $section_id_raw));
    $section_id_sanitized = trim(preg_replace('/-+/', '-', $section_id_sanitized), '-');
}

// Fallback unique ID for scoping any inline behavior
$block_uid = $section_id_sanitized ? $section_id_sanitized : 'hero-lead-form-' . uniqid();

// Normalise heading level to a safe tag (h1–h4 only)
$allowed_heading_levels = array('h1', 'h2', 'h3', 'h4');
$heading_level = in_array($heading_level_raw, $allowed_heading_levels, true) ? $heading_level_raw : 'h1';
?>

<section class="hero-lead-form" id="<?php echo esc_attr($block_uid); ?>">
    <div class="container">
        <div class="hero-lead-grid">
            <div class="hero-lead-left">
                <?php if ($heading_subtitle) : ?>
                    <div class="hero-lead-subtitle"><?php echo esc_html($heading_subtitle); ?></div>
                <?php elseif ($logo_1 || $logo_2) : ?>
                    <div class="hero-lead-logos">
                        <?php if ($logo_1) : ?>
                            <div class="hero-lead-logo">
                                <img src="<?php echo esc_url($logo_1['url']); ?>" alt="<?php echo esc_attr($logo_1['alt']); ?>" />
                            </div>
                        <?php endif; ?>
                        <?php if ($logo_2) : ?>
                            <div class="hero-lead-logo">
                                <img src="<?php echo esc_url($logo_2['url']); ?>" alt="<?php echo esc_attr($logo_2['alt']); ?>" />
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($headline) : ?>
                    <<?php echo esc_html($heading_level); ?> class="hero-lead-title">
                        <?php echo esc_html($headline); ?>
                    </<?php echo esc_html($heading_level); ?>>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="hero-lead-desc">
                        <?php echo wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>

                <?php if (($cta_text && $cta_url) || ($cta_2_text && $cta_2_url)) : ?>
                    <div class="hero-lead-cta">
                        <?php if ($cta_text && $cta_url) : ?>
                            <a class="btn btn-primary" href="<?php echo esc_url($cta_url); ?>"<?php echo $target_attr; ?>><?php echo esc_html($cta_text); ?></a>
                        <?php endif; ?>
                        <?php if ($cta_2_text && $cta_2_url) : ?>
                            <a class="btn btn-secondary" href="<?php echo esc_url($cta_2_url); ?>"<?php echo $target2_attr; ?>><?php echo esc_html($cta_2_text); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="hero-lead-right">
                <div class="hero-form-card">
                <?php if (function_exists('gravity_form')) : ?>
                    <?php gravity_form($form_id, false, false, true, null, true); ?>
                <?php else : ?>
                    <p class="gf-missing">Gravity Forms is not available.</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>