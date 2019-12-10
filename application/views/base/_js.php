<?php
$_js_file = isset($_js) && $_js ? $_js : FALSE;

if ($_js_file) {
    if (!is_array($_js_file)) {
        $_js_file = array((string) $_js_file);
    }
    foreach ($_js_file as $v) {
        $_url = $v;
        if (!preg_match('/^http/', $_url)) {
            $_url = base_url($_url);
        }
        ?>
        <script type="text/javascript" src="<?php echo $_url; ?>"></script>
        <?php
    }
}