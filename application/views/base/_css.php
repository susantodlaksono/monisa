<?php
$_css_file = isset($_css) && $_css ? $_css : FALSE;

if ($_css_file) {
    if (!is_array($_css_file)) {
        $_css_file = array((string) $_css_file);
    }
    foreach ($_css_file as $v) {
        $_url = $v;
        if (!preg_match('/^http/', $_url)) {
            $_url = base_url($_url);
        }
        ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $_url; ?>" />
        <?php
    }
}