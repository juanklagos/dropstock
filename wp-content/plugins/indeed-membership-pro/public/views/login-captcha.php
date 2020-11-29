<?php if ( $type !== false && $type == 'v3' ):?>
    <div class="js-ump-recaptcha-v3-item"></div>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $key;?>"></script>
    <script>
      grecaptcha.ready(function() {
          grecaptcha.execute( '<?php echo $key;?>', { action: 'homepage' } ).then(function(token) {
              jQuery('.js-ump-recaptcha-v3-item').html('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
          });
      });
    </script>
<?php else :?>
    <div class="g-recaptcha-wrapper" class="<?php echo $class;?>">
        <div class="g-recaptcha" data-sitekey="<?php echo $key;?>"></div>
        <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=<?php echo $langCode;?>"></script>
    </div>
<?php endif;?>
