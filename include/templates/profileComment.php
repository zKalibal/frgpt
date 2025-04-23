<?php array_push($_SESSION['commentsLoaded'], $template['data']['id']); ?>
<div class="comment-<?php echo $template['data']['id']; ?> row gx-1 gx-lg-2 mt-3 position-relative">
    <div class="col-auto">
        <div class="mb-2 img user position-relative ratio ratio-1x1 rounded-circle bg-dark border border-2 border-light shadow-sm" style="width:45px; background-image: url('/img/thumb/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>.webp');"></div>
    </div>
    <div class="col text-truncate">
        <div class="bg-primary bg-opacity-10 rounded p-2 px-lg-3 message text-break">
            <a class="spa text-decoration-none text-black d-block text-truncate" href="<?php echo ["notizie", "recensioni", "monografie", "anteprime"][$template['data']['type']]; ?>/<?php echo $template['data']['id']; ?>/<?php echo strtourl($template['data']['title']); ?>" rel="nofollow">
                <h6 class="fw-bold fst-italic text-truncate mb-1"><?php echo $template['data']['title']; ?></h6>
            </a>
            <p class="text-wrap">
                <?php
                $clength = 200;
                if (strlen($template['data']['comment']) <= $clength) {
                ?>
                    <span class="message_text"><?php echo nl2br(htmlentities($template['data']['comment'])); ?></span>
                <?php
                } else {
                ?>
                    <span>
                        <?php echo nl2br(htmlentities(substr($template['data']['comment'], 0, $clength))); ?>
                        …<a href="javascript:void(0)" onclick="$(this).parent().next().removeClass('d-none').prev().remove();" class="text-decoration-none text-black fw-bold">Altro...</a>
                    </span>
                    <span class="message_text d-none">
                        <?php echo nl2br(htmlentities($template['data']['comment'])); ?>
                    </span>
                <?php
                }

                ?>
            </p>
        </div>
    </div>
</div>