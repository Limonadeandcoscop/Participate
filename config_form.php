
<div class="field ui form">

    <div class="inputs five columns omega">
        <p class="presentation">
            <?php echo __("Presentation text for newsletter subscribing"); ?><br />
            <textarea name="presentation" rows="5" cols="120"><?php echo @$presentation ?></textarea>
        </p>
    </div>

    <script>
    jQuery(document).ready(function($) {

        $('.base_language')
            .dropdown({
                maxSelections: 3,
                onChange: function(value, text, $selectedItem) {
                    $('.ui.dropdown.translations .item').show();
                    $('.ui.dropdown.translations .item[data-value="' + value + '"]').hide();
            }
        });

        $('.translations')
            .dropdown({
                maxSelections: 10,
                onChange: function(value, text, $selectedItem) {
            }
        });

        $('input[type=submit').click(function() {

            var base_language   = $('input[name=base_language]').val();
            var translations    = $('input[name=translations]').val();
            var errors          = false;

            if(base_language === "") {
                alert("<?php echo __('The \"Base language\" field is required') ?>");
                errors = true;
            }

            if(translations === "") {
                alert("<?php echo __('The \"Translations\" field is required') ?>");
                errors = true;
            }

            if(errors) return false;
        });

    });
    </script>
</div>

