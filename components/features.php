<?php

$args = array(
    "title" => "Ücretsiz Gönderim",
    "description" => "Dünyanın her noktasına kargo hızlı ve uygun fiyatlarla gönderim yapabilirsiniz.",
    "image" => get_template_directory_uri() . "/assets/images/free-shipping.svg"
);

$printGuarantee = array(
    "title" => "Baskı Garantisi",
    "description" => "Baskı hakkında detaylı bilgi almak istiyorsanız, baskı garantisi hakkında detaylı bilgi alabilirsiniz.",
    "image" => get_template_directory_uri() . "/assets/images/print-quality.svg"
);

$corporateDiscount = array(
    "title" => "Kurumsal İndirim",
    "description" => "Kurumsal indirim hakkında detaylı bilgi alabilirsiniz.",
    "image" => get_template_directory_uri() . "/assets/images/corporate-discount.svg"
);

$specialDesign = array(
    "title" => "Özel Tasarım",
    "description" => "Özel tasarım hakkında detaylı bilgi alabilirsiniz.",
    "image" => get_template_directory_uri() . "/assets/images/custom-design.svg"
);

?>
<section class="w-full max-w-[1920px] flex items-center justify-center px-20 py-20 md:py-80">
    <div class="features-slider w-full flex flex-row justify-start items-center">
        <div class="features-slider-wrapper w-full relative flex flex-row justify-start">
            <?php site_feature_box($args); ?>
            <?php site_feature_box($printGuarantee); ?>
            <?php site_feature_box($corporateDiscount); ?>
            <?php site_feature_box($specialDesign); ?>
        </div>
    </div>
</section>