function loadpage(url, target, type, history, element) {

    var page = "";
    if (url.indexOf(".php") === -1) //se NON è un link col nome file esplicito, dunque un url rewrite
    {

        /* GESTORE NAV COMBO PIATTAFORMA-TIPOLOGIA*/
        if ($(element).hasClass("platform") && url == "*") {
            $("nav a.spa.platform").removeClass("active");
            if ($(".spa.active.type").attr("href") != undefined)
                url = $(".spa.active.type").attr("href");
            else url = "/";
        }
        else
            if (($(element).hasClass("type") && $(".spa.active").hasClass("platform")) || ($(element).hasClass("platform") && $(".spa.active").hasClass("type"))) {
                page = url;
                if ($(element).hasClass("type") && $(".spa.active").hasClass("platform")) {
                    url = url + "/" + $(".spa.active.platform").attr("href");
                    $("nav a.spa.type").removeClass("active");

                } else {
                    url = $(".spa.active.type").attr("href") + "/" + url;
                    $("nav a.spa.platform").removeClass("active");
                }
            } else
                $("nav a.spa").removeClass("active");
        /* GESTORE NAV COMBO PIATTAFORMA-TIPOLOGIA*/

        urlrewrite = url;
        $.ajax
            (
                {
                    type: "POST",
                    url: url,
                    data: { 'urlrewrite': true },
                    async: false,
                    success: function (data) {
                        if (data == "") data = "posts.php"; //se non trova nulla, rimanda alla homepage
                        url = "../pages/" + data;
                    }
                }
            )
    } else if (target == "#container") {
        $("nav a.spa").removeClass("active");
        urlrewrite = "";
        url = "../pages/" + url.replace("?page=", "");
    }

    $.ajax
        (
            {
                type: "POST",
                url: url,
                data: { 'spa': true, 'urlrewrite': urlrewrite },
                async: true,
                success: function (data, textStatus, request) {
                    if (!!request.getResponseHeader('redirect'))
                        window.location.replace(request.getResponseHeader('redirect'));
                    else {
                        $(element).find(".loader").remove();

                        // SET METAS
                        $("title").html(request.getResponseHeader('meta-title'));
                        $("meta[property='og:title'],meta[name='twitter:title']").attr("content", request.getResponseHeader('meta-title'));
                        $("meta[name='description'],meta[property='og:description'],meta[name='twitter:description']").attr("content", request.getResponseHeader('meta-description'));
                        $("meta[name='url'],meta[property='og:url']").attr("content", request.getResponseHeader('meta-url'));
                        $("meta[name='image'],meta[property='og:image']").attr("content", request.getResponseHeader('meta-image'));
                        // SET METAS
                        
                        switch (type) {
                            case 'prepend':
                                $(target).prepend(data);
                                break;

                            case 'append':
                                $(target).append(data);
                                break;

                            default:
                                $(target).html(data);

                        }

                        if (target == "#container") {

                            if (urlrewrite == "") {
                                page = url.split("pages/").pop();
                                urlrewrite = '?page=' + page;
                                $("nav a.spa[href*='" + urlrewrite + "']").addClass("active");
                            } else {

                                if (page != "")
                                    $("nav a.spa[href*='" + (page == "/" ? '/' : page.split("/")[0]) + "']").addClass("active");
                                else {
                                    page = urlrewrite;

                                    if (page != "/") {
                                        page.split("/").forEach(function (item) {
                                            $("nav a.spa[href*='" + item + "']").addClass("active");
                                        });
                                    }
                                    else
                                        $("nav a.spa[href='/']").addClass("active");
                                }
                                page = urlrewrite;

                            }

                            if(page.split("#")[1] != undefined) //se c'è un ancora, scrolla alla sezione
                            {
                                //wait for the page to load before scrolling to avoid scrolling to the wrong position
                                setTimeout(function () {
                                    window.scrollTo(0, document.getElementById(page.split("#")[1]).offsetTop);
                                }, 1000);
                            }
                            else //altrimenti scrolla in cima
                                window.scrollTo(0, 0);

                            $("body").removeClass(function (index, css) {
                                return (css.match(/\bpage-\S+/g) || []).join(' ');
                            }).addClass("page-" + page.split(".")[0]);

                            switch (history) {
                                case 'push':
                                    window.history.pushState({ page: page }, '', urlrewrite);
                                    break;
                                case 'replace':
                                    window.history.replaceState({ page: page }, '', urlrewrite);
                                    break;
                            }

                        }
                        hscroll();
                    }
                }
            }
        );
}
$(document).on(clickOrTouch, "a.spa, a.loader", function (event) {
    var elem = this;
    if ($(elem).attr("href") != "" && !$(elem).find(".loader").length) {
        $(elem).append('<div class="loader position-absolute w-100 h-100 top-0 start-0 bg-body bg-opacity-75"><span class="top-50 start-50 translate-middle position-absolute"><div class="spinner-border spinner-border-sm" role="status"></div></span></div>');
        if ($(elem).hasClass("spa")) {
            //il timout serve per triggerare il loader istantaneamente, altrimenti il loadpage sincrono blocca la GUI e il loader viene mostrato solo dopo
            setTimeout(function () {
                loadpage($(elem).attr("href"), "#container", '', 'push', elem);
            }, 200);
        }
        else
            window.location = $(elem).attr("href");
    }
    event.stopPropagation();
    event.preventDefault();
    return false;
});

window.addEventListener('popstate', function (e) {
    loadpage(e.state.page, "#container");
});