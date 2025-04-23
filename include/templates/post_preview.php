<div class="row g-0 w-100 position-relative wow fadeIn">
    <div class="col-12">
        <?php if (isset($template['elements']['image'])) {
        ?>
            <div class="position-relative">
                <a style="filter: sepia(0.35);" class="spa d-block mb-2 bg-dark bg-opacity-10 rounded overflow-hidden" href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$template['data']['type']]; ?>/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>" rel="nofollow">

                    <picture class="ratio <?php echo "{$template['elements']['image']['ratio']} {$template['elements']['image']['custom_classes']}"; ?>">
                        <?php
                        if (file_exists($img = $webRoot . '/img/posts/' . $template['data']['id'] . (($template['elements']['image']['size'] != "") ? "_{$template['elements']['image']['size']}" : "") . '.webp'))
                            $img = "/img/" . (($template['elements']['image']['size'] != "") ? $template['elements']['image']['size'] : "default") . "/{$template['data']['id']}/" . strtourl($template['data']['title']) . ".webp?t=" . filemtime($img);
                        else $img = "/img/default.webp";
                        ?>
                        <img <?php if (($loading = $template['elements']['image']['loading']) != "") echo "loading='{$loading}'"; ?> src="<?php echo $img; ?>" alt="<?php echo $template['data']['title']; ?>" />
                    </picture>

                </a>
                <?php if (isset($template['elements']['image']['labels'])) { ?>
                    <div class="w-100 position-absolute bottom-0 p-2">
                        <div class="hstack gap-2">
                            <div class="ms-auto"></div>
                            <?php if ($template['data']['subscriptions'] != NULL) { ?>
                                <div>
                                    <small class="lh-1 d-inline-block bg-twitch fw-bold text-white p-1 px-2 border border-1 border-light text-uppercase rounded"><i class="bi bi-star-fill"></i></small>
                                </div>
                            <?php } ?>
                            <div>
                                <small class="lh-1 d-inline-block bg-black fw-bold text-white p-1 px-2 border border-1 border-light text-uppercase rounded"><?php echo ["attualità", "recensione", "monografia", "anteprima"][$template['data']['type']]; ?></small>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php
        }
        if (isset($template['elements']['metas'])) {
        ?>
            <div class="row g-0 small mb-2 lh-1">
                <div class="col">
                    <?php echo date("d/m/Y", strtotime($template['data']['date'])); ?>

                </div>
                <div class="col-auto">
                    <ul class="list-group list-group-horizontal" style="list-style:none;">
                        <li><i class="bi bi-chat"></i> <?php echo $template['data']['comments']; ?></li>
                    </ul>
                </div>
            </div>
        <?php
        }
        if (isset($template['elements']['title'])) {
        ?>
            <a href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$template['data']['type']]; ?>/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>" class="spa text-decoration-none text-black d-block">
                <h4 class="mb-2 fw-semibold m-0 <?php echo $template['elements']['title']['custom_classes']; ?> fst-italic"><?php echo $template['data']['title']; ?></h4>
            </a>
        <?php }
        if (isset($template['elements']['description'])) {
        ?>
            <p class="mb-2 <?php echo $template['elements']['description']['custom_classes']; ?>"><?php echo $template['data']['short_description']; ?></p>
        <?php } ?>
    </div>
    <div class="col-12 align-self-end">
        <?php if (isset($template['elements']['author'])) { ?>
            <div class="row align-items-center gx-2 gx-lg-3">
                <div class="col text-truncate text-end">
                    <span class="lh-1 fs-6">A cura di</span>
                    <a href="<?php echo "staff/{$template['data']['author_id']}/" . strtourl($template['data']['author_name']); ?>" class="spa text-decoration-none text-reset d-block">
                        <h6 class="m-0 text-truncate"><b><?php echo $template['data']['author_name']; ?></b></h6>
                    </a>
                </div>
                <div class="col-auto">
                    <img class="rounded-circle border border-2 border-light shadow-sm" src="img/authors/thumbs/<?php echo $template['data']['author_id']; ?>.webp" style="width:45px!important;filter: grayscale(1);">
                </div>
            </div>
        <?php }
        if (isset($template['elements']['hr'])) { ?>
            <hr class="d-xl-none my-3 bg-dark opacity-100 ms-n3 me-n3 mx-md-0">
        <?php } ?>
    </div>
</div>