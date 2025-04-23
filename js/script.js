$(document).ready(function () {
    new WOW().init();
    hscroll();
});
var clickOrTouch = (('ontouchend' in window)) ? 'tap' : 'click';

/* MODALS */
var open_modal;
function modal(title, body, get = "", size = "", history = true) {
    var modals = $('.modal:visible').length;
    /*
     <div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content">
     <div class="modal-header bg-light">
     <h5 class="modal-title fw-bold"></h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
     </div>
     <div class="modal-body p-4"></div>
     </div>
     </div>
     </div>
     */

    if (/\.(jpg|jpeg|png|webp|avif|gif|svg)$/.test(body.split('?t')[0])) {
        body = '<img src="'+body+'" class="img-fluid" style="width:100%!important;">';
        $("body").append('<div class="modal fade" id="modal-' + modals + '" z="' + modals + '" tabindex="-1" aria-hidden="true"> <div class="modal-dialog modal-dialog-centered"> <div class="modal-content" style="border: none; background: transparent;"> <div class="modal-header" style="border: none!important; background: transparent!important;"><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body p-0"></div> </div> </div> </div>');
    }
    else {
        $("body").append('<div class="modal fade" id="modal-' + modals + '" z="' + modals + '" tabindex="-1" aria-hidden="true"> <div class="modal-dialog modal-dialog-centered"> <div class="modal-content"> <div class="modal-header bg-light"> <h5 class="modal-title fw-bold"></h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body p-4"></div> </div> </div> </div>');
    }

    $(document).on("hidden.bs.modal", "#modal-" + modals, function () {
        /*QUANDO UN MODAL VIENE CHIUSO LO ELIMINA DALLA PAGINA*/
        $("#modal-" + modals).remove();
    });
    $(document).on("hide.bs.modal", "#modal-" + modals, function () {
        $.ajax
            (
                {
                    type: "GET",
                    url: "../php/session_modal.php",
                    data: "",
                    async: true
                }
            );
        /*QUANDO UN MODAL VIENE CHIUSO MOSTRA EVENTUALI MODAL PRECEDENTI NASCOSTI*/
        $(".modal").filter(function () {
            return parseInt($(this).attr("z")) < modals;
        }).show();
    });

    //get --> 1: id element | 2: url 
    $('#modal-' + modals + ' .modal-title').html(title);
    if (size != "")
        $('#modal-' + modals + ' .modal-dialog').removeClass("modal-sm modal-lg modal-xl").addClass(size);
    if (get == "") {
        $('#modal-' + modals + ' .modal-body').html(body);
    } else if (get == 1) {
        $('#modal-' + modals + ' .modal-body').html($("#" + body).html());
    } else if (get == 2) {
        $.ajax
            (
                {
                    type: "GET",
                    url: body,
                    data: "",
                    async: true,
                    success: function (data) {
                        $('#modal-' + modals + ' .modal-body').html(data);
                        $("#modal-" + modals + " .modal-body textarea.simditor").each(function () {
                            new Simditor({
                                textarea: $(this),
                                cleanPaste: true,
                                allowedTags: ['br', 'span', 'a', 'b', 'strong', 'i', 'strike', 'u', 'p', 'ul', 'ol', 'li'],
                                toolbar: ['bold', 'italic', 'underline', 'strikethrough', 'ol', 'ul', 'link', 'alignment']
                            });
                        });
                    }
                }
            );
    }
    if (history) {
        $.ajax
            (
                {
                    type: "POST",
                    url: "../php/session_modal.php?title=" + title + "&get=" + get + "&size=" + size,
                    data: {
                        body: body
                    },
                    async: true
                }
            );
    }
    /*NASCONDI EVENTUALI MODAL PRECEDENTI*/
    $(".modal").filter(function () {
        return parseInt($(this).attr("z")) < modals;
    }).hide();

    open_modal = new bootstrap.Modal($('#modal-' + modals), { keyboard: false });
    open_modal.show();
}
$(document).on("hide.bs.modal hide.bs.offcanvas", ".modal,.offcanvas", function () {
    if (($(".offcanvas-backdrop").length + $(".modal-backdrop").length) == 1)
        $(".blur-backdrop").attr("style", "");
});
$(document).on("show.bs.modal show.bs.offcanvas", ".modal,.offcanvas", function () {
    $(".blur-backdrop").attr("style", "filter:blur(10px);");
});
/* MODALS */

/* TOASTS */
function toast(message) {
    /*
    <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
     */
    $(".toast-container").append('<div class="toast align-items-center bg-black shadow" role="alert" aria-live="assertive" aria-atomic="true"> <div class="d-flex"> <div class="toast-body text-white"><b>' + message + '</b></div> <button type="button" class="btn-close btn-close-white me-2 m-auto text-white" data-bs-dismiss="toast" aria-label="Close"></button> </div> </div>');
    $(document).on("hidden.bs.toast", ".toast", function () {
        $(this).remove();
    });
    new bootstrap.Toast($('.toast-container>.toast:last-of-type')).show();
}
/* TOASTS */

$(document).on(clickOrTouch, "[data-img-modal]", function () {
    modal(0, $(this).attr('data-img-modal'), 0, 'modal-xl');
});

function hscroll() {
    $(".hscroll").each(function () { $(this).css("height", $(this).children().children().css("height")).children().css("padding-bottom", "100px"); });
}
$(window).resize(function () {
    hscroll();
});

$(document).on("show.bs.dropdown", ".dropdown.user-nav", function () {
    $(".dropdown.user-nav .notifications").html('<center><div class="spinner-border spinner-border-sm" role="status"></div></center>');
    $(".dropdown.user-nav .new_notifications").remove();
    $.ajax
    (
        {
            type: "GET",
            url: "../php/get_notifications.php",
            async: true,
            success: function (data) {
                $(".dropdown.user-nav .notifications").html(data);
            }
        }
    );
});