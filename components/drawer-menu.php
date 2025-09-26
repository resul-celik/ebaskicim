<?php

class DrawerMenu
{

    public function render($args, $content)
    {
        $args["width"] = $args["width"] ?? 'w-1/4';
        $args["customClass"] = $args["customClass"] ?? '';
        $args["title"] = $args["title"] ?? '';
        $args["icon"] = $args["icon"] ?? '';
        $args["badgeCount"] = $args["badgeCount"]  ?? '';
?>

        <div class="<?php echo $args["customClass"] . " "; ?>drawer-menu <?php echo $args["width"]; ?> h-screen top-0 right-0 bottom-0 fixed z-999 flex flex-col p-20<?php echo is_user_logged_in() ? ' pt-52' : ''; ?>">
            <div class="w-full h-full flex flex-col bg-white rounded-[15px] items-start justify-start shadow-md overflow-hidden">
                <header class="w-full flex flex-row items-center justify-between p-20 grow-0 shrink-0">
                    <div class="flex flex-row gap-10 items-center justify-start">
                        <?php if ($args["icon"]) : ?>
                            <i class="icon <?php echo $args["icon"]; ?> text-primary-500"></i>
                        <?php endif; ?>
                        <?php if ($args["title"]) : ?>
                            <h2 class="paragraph-lg paragraph-bold text-gray-900"><?php echo $args["title"]; ?></h2>
                        <?php endif; ?>
                        <?php if ($args["badgeCount"]) : ?>
                            <?php echo ebs_get_badge($args["badgeCount"]); ?>
                        <?php endif; ?>
                    </div>
                    <?php echo get_button(array("icon" => "close", "hierarchy" => "tertiary", "classes" => "close-drawer", "type" => "button")); ?>
                </header>
                <?php echo $content ? $content() : ''; ?>
            </div>
        </div>
<? }
}

function get_drawer_menu($args, $content)
{
    $drawerMenu = new DrawerMenu();
    return $drawerMenu->render($args, $content);
}
