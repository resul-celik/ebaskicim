<?php

$args = array(
    "title" => "Ücretsiz Gönderim",
    "description" => "Dünyanın her noktasına kargo hızlı ve uygun fiyatlarla gönderim yapabilirsiniz."
);
$printGuarantee = array(
    "title" => "Baskı Garantisi",
    "description" => "Baskı hakkında detaylı bilgi almak istiyorsanız, baskı garantisi hakkında detaylı bilgi alabilirsiniz."
);

?>
<section class="w-full max-w-[1920px] flex items-center justify-center px-20 py-80">
    <div class="w-full flex flex-row gap-20">
        <?php site_feature_box($args); ?>
        <?php site_feature_box($printGuarantee); ?>
        <?php site_feature_box(array("title" => "Kurumsal İndirim", "description" => "Kurumsal indirim hakkında detaylı bilgi alabilirsiniz.")); ?>
        <?php site_feature_box(array("title" => "Özel Tasarım", "description" => "Özel tasarım hakkında detaylı bilgi alabilirsiniz.")); ?>
    </div>
</section>