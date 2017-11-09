(function e(t, n, r) {
    function s(o, u) {
        if (!n[o]) {
            if (!t[o]) {
                var a = typeof require == "function" && require;
                if (!u && a) return a(o, !0);
                if (i) return i(o, !0);
                var f = new Error("Cannot find module '" + o + "'");
                throw f.code = "MODULE_NOT_FOUND", f
            }
            var l = n[o] = {
                exports: {}
            };
            t[o][0].call(l.exports, function(e) {
                var n = t[o][1][e];
                return s(n ? n : e)
            }, l, l.exports, e, t, n, r)
        }
        return n[o].exports
    }
    var i = typeof require == "function" && require;
    for (var o = 0; o < r.length; o++) s(r[o]);
    return s
})({
    1: [function(require, module, exports) {
        ! function(name, definition) {
            if (typeof module != "undefined") module.exports = definition();
            else if (typeof define == "function" && typeof define.amd == "object") define(definition);
            else this[name] = definition()
        }("domready", function(ready) {
            var fns = [],
                fn, f = false,
                doc = document,
                testEl = doc.documentElement,
                hack = testEl.doScroll,
                domContentLoaded = "DOMContentLoaded",
                addEventListener = "addEventListener",
                onreadystatechange = "onreadystatechange",
                readyState = "readyState",
                loadedRgx = hack ? /^loaded|^c/ : /^loaded|c/,
                loaded = loadedRgx.test(doc[readyState]);

            function flush(f) {
                loaded = 1;
                while (f = fns.shift()) f()
            }
            doc[addEventListener] && doc[addEventListener](domContentLoaded, fn = function() {
                doc.removeEventListener(domContentLoaded, fn, f);
                flush()
            }, f);
            hack && doc.attachEvent(onreadystatechange, fn = function() {
                if (/^c/.test(doc[readyState])) {
                    doc.detachEvent(onreadystatechange, fn);
                    flush()
                }
            });
            return ready = hack ? function(fn) {
                self != top ? loaded ? fn() : fns.push(fn) : function() {
                    try {
                        testEl.doScroll("left")
                    } catch (e) {
                        return setTimeout(function() {
                            ready(fn)
                        }, 50)
                    }
                    fn()
                }()
            } : function(fn) {
                loaded ? fn() : fns.push(fn)
            }
        })
    }, {}],
    2: [function(require, module, exports) {}, {}],
    3: [function(require, module, exports) {}, {
        "../../common/util": 17
    }],
    4: [function(require, module, exports) {}, {
        "../../common/util": 17
    }],
    5: [function(require, module, exports) {}, {}],
    6: [function(require, module, exports) {}, {
        "../formatting/format-post-ajax": 3
    }],
    7: [function(require, module, exports) {}, {
        "./infinite-scroll": 6,
        "./next-post": 8,
        "./recent-post": 9,
        "./refresh-theme": 10
    }],
    8: [function(require, module, exports) {}, {
        "../../common/util": 17
    }],
    9: [function(require, module, exports) {}, {}],
    10: [function(require, module, exports) {
        (function() {}).call(this)
    }, {}],
    11: [function(require, module, exports) {
        (function() {
            var audio, formatting, formattingAjax, init, paceOptions, pagination, sfApp, themeRefreshIntro, trackIndex, util, widgets;
            util = require("../common/util");
            pagination = require("./pagination/main");
            widgets = require("./widgets/main");
            formatting = require("./formatting/format-post");
            formattingAjax = require("./formatting/format-post-ajax");
            audio = require("./media/audio");
            paceOptions = {
                elements: true
            };
            trackIndex = 0;
            sfApp = {
                scrollTimer: null,
                nextPost: function() {
                    return pagination.nextPost()
                },
                formatBlogAjax: function($newElements) {
                    return formattingAjax.formatBlogAjax($newElements)
                },
                formatBlog: function() {
                    return formatting.formatBlog()
                },
                audioPlayback: function() {
                    return audio.audioPlayback()
                },
                videoPlayback: function() {
                    $(document).on("click", ".video-playback:not(.vimeo)", function(event) {
                        var $postHeader, $this, $video;
                        $this = $(this);
                        $postHeader = $this.closest(".post-header");
                        $video = $postHeader.find(".video");
                        if (!$this.is(".playing")) {
                            $(".video-playback.playing").removeClass("playing");
                            $this.addClass("playing");
                            $(".post-header.video-post.playing .mb_YTVPlayer").each(function() {
                                $(this).pauseYTP()
                            });
                            $video.playYTP()
                        } else {
                            $this.removeClass("playing");
                            $video.pauseYTP()
                        }

                        return false
                    })
                },
                getRecentPosts: function() {
                    return pagination.getRecentPosts(SF_THEME_OPTIONS)
                },
                infiniteScrollHandler: function() {
                    return pagination.infiniteScrollHandler(SF_THEME_OPTIONS)
                },
                getFlickr: function() {
                    var count;
                    if ($(".flickr-feed").length) {
                        count = 1;
                        $(".flickr-feed").each(function() {
                            var feedTemplate, isPopupPreview, size;
                            if (flickr_id === "" || flickr_id === "YOUR_FLICKR_ID_HERE") {
                                $(this).html("<li><strong>Please change Flickr user id before use this widget</strong></li>")
                            } else {
                                feedTemplate = '<li><a href="{{image_b}}" target="_blank"><img src="{{image_m}}" alt="{{title}}" /></a></li>';
                                size = 15;
                                if ($(this).data("size")) {
                                    size = $(this).data("size")
                                }
                                isPopupPreview = false;
                                if ($(this).data("popup-preview")) {
                                    isPopupPreview = $(this).data("popup-preview")
                                }
                                if (isPopupPreview) {
                                    feedTemplate = '<li><a href="{{image_b}}"><img src="{{image_m}}" alt="{{title}}" /></a></li>';
                                    count++
                                }
                                $(this).jflickrfeed({
                                    limit: size,
                                    qstrings: {
                                        id: flickr_id
                                    },
                                    itemTemplate: feedTemplate
                                }, function(data) {
                                    if (isPopupPreview) {
                                        $(this).magnificPopup({
                                            delegate: "a",
                                            type: "image",
                                            closeOnContentClick: false,
                                            closeBtnInside: false,
                                            mainClass: "mfp-with-zoom mfp-img-mobile",
                                            gallery: {
                                                enabled: true,
                                                navigateByImgClick: true,
                                                preload: [0, 1]
                                            },
                                            image: {
                                                verticalFit: true,
                                                tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                                            },
                                            zoom: {
                                                enabled: true,
                                                duration: 300,
                                                opener: function(element) {
                                                    return element.find("img")
                                                }
                                            }
                                        })
                                    }
                                })
                            }
                        })
                    }
                },
                getInstagram: function() {
                    if ($(".instagram-feed").length) {
                        if (instagram_accessToken !== "" || instagram_accessToken !== "your-instagram-access-token") {
                            $.fn.spectragram.accessData = {
                                accessToken: instagram_accessToken,
                                clientID: instagram_clientID
                            }
                        }
                        $(".instagram-feed").each(function() {
                            var display, wrapEachWithStr;
                            if (instagram_accessToken === "" || instagram_accessToken === "your-instagram-access-token") {
                                $(this).html("<li><strong>Please change instagram api access info before use this widget</strong></li>")
                            } else {
                                display = 15;
                                wrapEachWithStr = "<li></li>";
                                if ($(this).data("display")) {
                                    display = $(this).data("display")
                                }
                                $(this).spectragram("getUserFeed", {
                                    query: "adrianengine",
                                    max: display
                                })
                            }
                        })
                    }
                },
                getDribbble: function() {
                    var count;
                    if ($(".dribbble-feed").length) {
                        count = 1;
                        $(".dribbble-feed").each(function() {
                            var $this, display, isPopupPreview;
                            $this = $(this);
                            display = 15;
                            if ($this.data("display")) {
                                display = $this.data("display")
                            }
                            isPopupPreview = false;
                            if ($this.data("popup-preview")) {
                                isPopupPreview = $this.data("popup-preview")
                            }
                            $.jribbble.getShotsByList("popular", function(listDetails) {
                                var html;
                                html = [];
                                $.each(listDetails.shots, function(i, shot) {
                                    if (isPopupPreview) {
                                        html.push('<li><a href="' + shot.image_url + '">')
                                    } else {
                                        html.push('<li><a href="' + shot.url + '">')
                                    }
                                    html.push('<img src="' + shot.image_teaser_url + '" ');
                                    html.push('alt="' + shot.title + '"></a></li>')
                                });
                                $this.html(html.join(""));
                                if (isPopupPreview) {
                                    $this.magnificPopup({
                                        delegate: "a",
                                        type: "image",
                                        tLoading: "Loading image #%curr%...",
                                        mainClass: "mfp-img-mobile",
                                        gallery: {
                                            enabled: true,
                                            navigateByImgClick: true,
                                            preload: [0, 1]
                                        },
                                        image: {
                                            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
                                        }
                                    })
                                }
                            }, {
                                page: 1,
                                per_page: display
                            })
                        })
                    }
                },
                fitVids: function() {
                    $(".post-content").find('iframe[src^="//www.youtube.com"]').wrap('<div class="video-wrap"></div>');
                    $(".post-content").find('iframe[src^="//player.vimeo.com"]').wrap('<div class="video-wrap"></div>');
                    if ($(".post-content").find(">:first-child").is(".video-wrap")) {
                        $(".post-content").find(">:first-child").removeClass("video-wrap")
                    }
                    $(".post-content .video-wrap").fitVids()
                },
                timeToRead: function() {
                    return widgets.readShareWidget(sfApp)
                },
                mailchimpHandler: function() {
                    if ($("#mc-form").length) {
                        $("#mc-form input").not("[type=submit]").jqBootstrapValidation({
                            submitSuccess: function($form, event) {
                                var data, dataArray, url;
                                event.preventDefault();
                                url = $form.attr("action");
                                if (url === "" || url === "YOUR_WEB_FORM_URL_HERE") {
                                    alert("Please config your mailchimp form url for this widget");
                                    return false
                                } else {
                                    url = url.replace("/post?", "/post-json?").concat("&c=?");
                                    data = {};
                                    dataArray = $form.serializeArray();
                                    $.each(dataArray, function(index, item) {
                                        data[item.name] = item.value
                                    });
                                    $.ajax({
                                        url: url,
                                        data: data,
                                        success: function(resp) {
                                            if (resp.result === "success") {
                                                alert("Got it, you've been added to our newsletter. Thanks for subscribe!")
                                            } else {
                                                alert(resp.result)
                                            }
                                        },
                                        dataType: "jsonp",
                                        error: function(resp, text) {
                                            console.log("mailchimp ajax submit error: " + text)
                                        }
                                    });
                                    return false
                                }
                            }
                        })
                    }
                },
                scrollEvent: function() {
                    $(window).scroll(function() {
                        "use strict";
                        var curPos;
                        if ($(".header").attr("data-sticky") === "true") {
                            curPos = $(window).scrollTop();
                            if (curPos >= $(".header").height()) {
                                $(".header").addClass("fixed-top");
                                if ($(".logo-container .logo img").length && !$(".logo-container .logo img").is(".apply-sticked") && $(".logo-container .logo img").attr("data-sticked-src") !== "") {
                                    $(".logo-container .logo img").attr("data-normal-src", $(".logo-container .logo img").attr("src"));
                                    $(".logo-container .logo img").attr("src", $(".logo-container .logo img").attr("data-sticked-src"));
                                    $(".logo-container .logo img").addClass("apply-sticked")
                                }
                            } else {
                                $(".header").removeClass("fixed-top");
                                if ($(".logo-container .logo img").length && $(".logo-container .logo img").is(".apply-sticked") && $(".logo-container .logo img").attr("data-normal-src") !== "") {
                                    $(".logo-container .logo img").attr("data-sticked-src", $(".logo-container .logo img").attr("src"));
                                    $(".logo-container .logo img").attr("src", $(".logo-container .logo img").attr("data-normal-src"));
                                    $(".logo-container .logo img").removeClass("apply-sticked")
                                }
                            }
                        }
                        if ($("body").is(".post-template") && !$("body").is(".page") && $(".post-content").length) {
                            sfApp.timeToRead()
                        }
                    })
                },
                menuEvent: function() {
                    if ($(".mini-nav-button").length) {
                        $(".mini-nav-button").click(function() {
                            var $menu;
                            $menu = $(".full-screen-nav");
                            if (!$menu.length) {
                                $menu = $(".mini-nav");
                                if (!$menu.length) {
                                    $menu = $(".standard-nav")
                                }
                            }
                            if (!$(this).is(".active")) {
                                $("body").addClass("open-menu");
                                $menu.addClass("open");
                                $(this).addClass("active")
                            } else {
                                $("body").removeClass("open-menu");
                                $menu.removeClass("open");
                                $(this).removeClass("active")
                            }
                        })
                    }
                    if ($(".search-button").length) {
                        $(".search-button").click(function() {
                            var $search;
                            $("#search-keyword").val("");
                            $search = $(".search-container");
                            if (!$(this).is(".active")) {
                                $("body").addClass("open-search");
                                $search.addClass("open");
                                $(this).addClass("active");
                                $("#search-keyword").focus()
                            } else {
                                $("body").removeClass("open-search");
                                $search.removeClass("open");
                                $(this).removeClass("active");
                                $(".search-result").removeClass("searching")
                            }
                        })
                    }
                },
                gmapInitialize: function() {
                    var mainColor, map, mapOptions, marker, markerIcon, myLatlng, your_latitude, your_longitude;
                    if ($(".gmap").length) {
                        your_latitude = $(".gmap").data("latitude");
                        your_longitude = $(".gmap").data("longitude");
                        mainColor = sfApp.hexColor($(".gmap-container").css("backgroundColor"));
                        myLatlng = new google.maps.LatLng(your_latitude, your_longitude);
                        mapOptions = {
                            zoom: 17,
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: false,
                            panControl: false,
                            zoomControl: false,
                            scaleControl: false,
                            streetViewControl: false,
                            scrollwheel: false,
                            center: myLatlng,
                            styles: [{
                                stylers: [{
                                    hue: mainColor,
                                    lightness: 100
                                }]
                            }]
                        };
                        map = new google.maps.Map(document.getElementById("gmap"), mapOptions);
                        markerIcon = new google.maps.MarkerImage(SF_THEME_OPTIONS.global.rootUrl + "/assets/img/map-marker.png", null, null, new google.maps.Point(32, 32), new google.maps.Size(64, 64));
                        marker = new google.maps.Marker({
                            position: myLatlng,
                            flat: true,
                            icon: markerIcon,
                            map: map,
                            optimized: false,
                            title: "i-am-here",
                            visible: true
                        })
                    }
                },
                hexColor: function(colorval) {
                    var i, parts;
                    parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
                    delete parts[0];
                    i = 1;
                    while (i <= 3) {
                        parts[i] = parseInt(parts[i]).toString(16);
                        if (parts[i].length === 1) {
                            parts[i] = "0" + parts[i]
                        }++i
                    }
                    return "#" + parts.join("")
                },
                setCookie: function(key, value) {
                    var expires;
                    expires = new Date;
                    expires.setTime(expires.getTime() + 1 * 24 * 60 * 60 * 1e3);
                    document.cookie = key + "=" + value + ";path=/;expires=" + expires.toUTCString()
                },
                getCookie: function(key) {
                    var keyValue;
                    keyValue = document.cookie.match("(^|;) ?" + key + "=([^;]*)(;|$)");
                    if (keyValue) {
                        return keyValue[2]
                    } else {
                        return null
                    }
                },
                searchHandler: function() {
                    $("#search-keyword").keypress(function(event) {
                        if (event.which === 13) {
                            if ($("#search-keyword").val() !== "" && $("#search-keyword").val().length >= 3) {
                                $(".search-result").html('<li class="loading-text">Searching ...</li>');
                                $(".search-result").addClass("searching");
                                sfApp.search($("#search-keyword").val())
                            } else {
                                $(".search-result").html('<li class="loading-text">Please enter at least 3 characters!</li>');
                                $(".search-result").addClass("searching")
                            }
                        }
                    })
                },
                search: function(keyword) {
                    var hasResult, maxPage, page;
                    hasResult = false;
                    page = 0;
                    maxPage = 0;
                    if (keyword !== "") {
                        $.ajax({
                            type: "GET",
                            url: SF_THEME_OPTIONS.global.rootUrl,
                            success: function(response) {
                                var $response, postPerPage, timeout, totalPage;
                                $response = $(response);
                                postPerPage = $response.find("section.post").length;
                                totalPage = parseInt($response.find(".total-page").html());
                                maxPage = Math.floor(postPerPage * totalPage / 15) + 1;
                                timeout = setInterval(function() {
                                    var ajaxUrl;
                                    page = page + 1;
                                    ajaxUrl = SF_THEME_OPTIONS.global.rootUrl + "/rss/" + page + "/";
                                    if (page === 1) {
                                        ajaxUrl = SF_THEME_OPTIONS.global.rootUrl + "/rss/"
                                    }
                                    if (page > maxPage) {
                                        clearInterval(timeout);
                                        if (!hasResult) {
                                            $(".search-result .loading-text").html("Apologies, but no results were found. Please try another keyword!")
                                        }
                                    } else {
                                        $.ajax({
                                            type: "GET",
                                            url: ajaxUrl,
                                            dataType: "xml",
                                            success: function(xml) {
                                                if ($(xml).length) {
                                                    $("item", xml).each(function() {
                                                        if ($(this).find("title").eq(0).text().toLowerCase().indexOf(keyword.toLowerCase()) >= 0 || $(this).find("description").eq(0).text().toLowerCase().indexOf(keyword.toLowerCase()) >= 0) {
                                                            hasResult = true;
                                                            if ($(".search-result .loading-text").length) {
                                                                $(".search-result .loading-text").remove()
                                                            }
                                                            $(".search-result").append('<li><a href="' + $(this).find("link").eq(0).text() + '">' + $(this).find("title").eq(0).text() + "</a></li>")
                                                        }
                                                    })
                                                }
                                            }
                                        })
                                    }
                                }, 1e3)
                            }
                        })
                    }
                },
                refreshIntro: function() {
                    return pagination.refreshTheme()
                },
                misc: function() {
                    var $currentMenu, $imgList, $menu, currentUrl;
                    $(".more-detail .scrollDown").click(function() {
                        $("html, body").animate({
                            scrollTop: $("#start").offset().top - $(".header").outerHeight() + 20
                        }, 500);
                        return false
                    });
                    $(".more-detail .start").click(function() {
                        $("html, body").animate({
                            scrollTop: $("#start").offset().top - $(".header").outerHeight() + 20
                        }, 500);
                        return false
                    });
                    $(".action-list .go-to-blog").click(function() {
                        $("html, body").animate({
                            scrollTop: $("#start").offset().top - $(".header").outerHeight() + 20
                        }, 500);
                        return false
                    });
                    if ($(".totop-btn").length) {
                        $(".totop-btn").click(function() {
                            $("html, body").animate({
                                scrollTop: 0
                            }, 800);
                            return false
                        })
                    }
                    if ($(".go-to-comment").length) {
                        $(".go-to-comment").click(function(event) {
                            $("html, body").stop().animate({
                                scrollTop: $(".comment-wrap").offset().top
                            }, 500)
                        })
                    }
                    if ($("body").is(".post-template") || $("body").is(".page-template")) {
                        $imgList = $(".post-content").find("img");
                        if ($imgList.length) {
                            $imgList.each(function(index, el) {
                                var $fullscreenImgWrap, $wrap, alt;
                                alt = $(this).attr("alt");
                                $(this).addClass("img-responsive");
                                $(this).addClass(alt);
                                if (!alt) {
                                    return
                                }
                                if (alt.indexOf("no-responsive") >= 0) {
                                    $(this).removeClass("img-responsive")
                                }
                                if (alt.indexOf("fullscreen-img") >= 0) {
                                    $(this).wrap('<span class="fullscreen-img-wrap"></span>');
                                    $fullscreenImgWrap = $(this).closest(".fullscreen-img-wrap");
                                    $(this).on("load", function() {
                                        $fullscreenImgWrap.css({
                                            height: $(this).outerHeight()
                                        })
                                    })
                                } else if (alt.indexOf("popup-preview") >= 0 || $("body").data("auto-image-popup-preview")) {
                                    $(this).wrap('<a class="popup-preview" href="' + $(this).attr("src") + '"></a>');
                                    $wrap = $(this).parent();
                                    if (alt.indexOf("alignright") >= 0) {
                                        $wrap.addClass("alignright")
                                    }
                                    if (alt.indexOf("alignleft") >= 0) {
                                        $wrap.addClass("alignleft")
                                    }
                                    if (alt.indexOf("aligncenter") >= 0) {
                                        $wrap.addClass("aligncenter")
                                    }
                                    $(".popup-preview").magnificPopup({
                                        type: "image",
                                        closeOnContentClick: true,
                                        closeBtnInside: false,
                                        fixedContentPos: true,
                                        mainClass: "mfp-no-margins mfp-with-zoom",
                                        image: {
                                            verticalFit: true
                                        },
                                        gallery: {
                                            enabled: true
                                        },
                                        zoom: {
                                            enabled: true,
                                            duration: 300
                                        }
                                    })
                                }
                            })
                        }
                    }
                    if ($(".gmap").length) {
                        sfApp.gmapInitialize();
                        google.maps.event.addDomListener(window, "load", sfApp.gmapInitialize);
                        google.maps.event.addDomListener(window, "resize", sfApp.gmapInitialize)
                    }
                    $menu = $(".full-screen-nav");
                    if (!$menu.length) {
                        $menu = $(".mini-nav");
                        if (!$menu.length) {
                            $menu = $(".standard-nav")
                        }
                    }
                    currentUrl = window.location.href;
                    $currentMenu = $menu.find('a[href="' + currentUrl + '"]');
                    if ($currentMenu.length) {
                        $("li.active", $menu).removeClass("active");
                        $currentMenu.parent().addClass("active")
                    }
                    $("input, textarea").placeholder()
                },
                setup: function() {
                    sfApp.refreshIntro();
                    sfApp.formatBlog();
                    sfApp.nextPost();
                    sfApp.infiniteScrollHandler();
                    sfApp.fitVids();
                    sfApp.audioPlayback();
                    sfApp.videoPlayback();
                    sfApp.scrollEvent();
                    sfApp.menuEvent();
                    sfApp.searchHandler();
                    sfApp.mailchimpHandler();
                    sfApp.misc()
                }
            };
            themeRefreshIntro = function() {
                return util.debounce(function() {
                    return sfApp.refreshIntro()
                }, 500)
            };
            init = function() {
                sfApp.setup();
                return util.addEvent(window, "resize", function(event) {
                    return themeRefreshIntro()
                })
            };
            module.exports = {
                init: init
            }
        }).call(this)
    }, {
        "../common/util": 17,
        "./formatting/format-post": 4,
        "./formatting/format-post-ajax": 3,
        "./media/audio": 5,
        "./pagination/main": 7,
        "./widgets/main": 12
    }],
    12: [function(require, module, exports) {
        (function() {
            var readShareWidget;
            readShareWidget = require("./time-to-read/minutes-left-to-read");
            module.exports = {
                readShareWidget: readShareWidget.minutesLeftToReadThanksForSharingWidget
            }
        }).call(this)
    }, {
        "./time-to-read/minutes-left-to-read": 13
    }],
    13: [function(require, module, exports) {
        (function() {
            var minutesLeftToReadThanksForSharingWidget;
            minutesLeftToReadThanksForSharingWidget = function(app) {
                var $postContent, $shareBox, $timeToReadNofify, correctScrollToTopBottom, distance, otherPos, progress, scrollbarHeight, time, winHeight;
                $shareBox = $(".share-box");
                if (!$("#time-to-read-nofify").length) {
                    $('<div id="time-to-read-nofify"></div>').appendTo("body");
                    if ($(window).width() > 1023) {
                        $shareBox.appendTo("body")
                    } else if ($(window).width() < 1023) {
                        $shareBox.insertBefore(".comment-box")
                    }
                }
                $timeToReadNofify = $("#time-to-read-nofify");
                $postContent = $(".post-content");
                if (!$postContent.data("time-to-read")) {
                    time = Math.round($postContent.text().split(" ").length / 200);
                    $postContent.data("time-to-read", time)
                }
                winHeight = $(window).height();
                scrollbarHeight = winHeight / $(document).height() * winHeight;
                progress = $(window).scrollTop() / ($(document).height() - winHeight);
                distance = progress * (winHeight - scrollbarHeight) + scrollbarHeight / 2 - $timeToReadNofify.height() / 2;
                correctScrollToTopBottom = $(window).scrollTop() + screen.height;
                otherPos = document.getElementsByClassName("comment-box")[0].offsetTop - 500;
                if (correctScrollToTopBottom < otherPos) {
                    if ($(window).width() > 1023) {
                        $shareBox.fadeOut(100)
                    } else {
                        $shareBox.css("top", 0).fadeIn(100)
                    }
                } else {
                    $timeToReadNofify.fadeOut(100);
                    if ($(window).width() > 1023) {
                        $shareBox.css("top", distance - 150).fadeIn(100)
                    } else {
                        $shareBox.css("top", 0).fadeIn(100)
                    }
                }
                if (app.scrollTimer !== null) {
                    clearTimeout(app.scrollTimer)
                }
                app.scrollTimer = setTimeout(function() {
                    $timeToReadNofify.fadeOut()
                }, 1e3)
            };
            module.exports = {
                minutesLeftToReadThanksForSharingWidget: minutesLeftToReadThanksForSharingWidget
            }
        }).call(this)
    }, {}],
    14: [function(require, module, exports) {
        (function() {
            var loadScript;
            loadScript = function(url, async, element, callback) {
                var head, script;
                script = document.createElement("script");
                script.type = "text/javascript";
                script.src = url;
                script.onreadystatechange = callback;
                script.onload = callback;
                script.async = async;
                script.charset = "utf-8";
                if (element != null) {
                    element = document.getElementById(element);
                    element.innerHTML += script.outerHTML
                } else {
                    head = document.getElementsByTagName("head")[0];
                    head.appendChild(script)
                }
            };
            module.exports = {
                loadScript: loadScript
            }
        }).call(this)
    }, {}],
    15: [function(require, module, exports) {
        (function() {
            var debounce;
            debounce = function(func, wait, immediate) {
                var timeout;
                timeout = void 0;
                return function() {
                    var args, callNow, context, later;
                    context = this;
                    args = arguments;
                    later = function() {
                        timeout = null;
                        if (!immediate) {
                            func.apply(context, args)
                        }
                    };
                    callNow = immediate && !timeout;
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                    if (callNow) {
                        func.apply(context, args)
                    }
                }
            };
            module.exports = {
                debounce: debounce
            }
        }).call(this)
    }, {}],
    16: [function(require, module, exports) {
        (function() {
            var addEvent, debounce, removeEvent;
            debounce = require("./debouncing");
            addEvent = function(obj, type, fn) {
                if (obj.attachEvent) {
                    obj["e" + type + fn] = fn;
                    obj[type + fn] = function() {
                        obj["e" + type + fn](window.event)
                    };
                    obj.attachEvent("on" + type, obj[type + fn])
                } else {
                    obj.addEventListener(type, fn, false)
                }
            };
            removeEvent = function(obj, type, fn) {
                if (obj.detachEvent) {
                    obj.detachEvent("on" + type, obj[type + fn]);
                    obj[type + fn] = null
                } else {
                    obj.removeEventListener(type, fn, false)
                }
            };
            module.exports = {
                addEvent: addEvent,
                removeEvent: removeEvent,
                debounce: debounce.debounce
            }
        }).call(this)
    }, {
        "./debouncing": 15
    }],
    17: [function(require, module, exports) {
        (function() {
            var dom, event, formatDate, getDocumentHeight, isMobile, moment, slugify;
            moment = require("moment/moment");
            event = require("./events/main");
            dom = require("./dom-manipulation/main");
            isMobile = function() {
                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                    return true
                } else {
                    return false
                }
            };
            formatDate = function(date) {
                return moment(date).fromNow()
            };
            slugify = function(text) {
                return text.toString().toLowerCase().replace(/\s+/g, "-").replace(/[^\w\-]+/g, "").replace(/\-\-+/g, "-").replace(/^-+/, "").replace(/-+$/, "")
            };
            getDocumentHeight = function() {
                var body, height, html;
                body = document.body;
                html = document.documentElement;
                height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
                return height
            };
            module.exports = {
                isMobile: isMobile,
                formatDate: formatDate,
                addEvent: event.addEvent,
                removeEvent: event.removeEvent,
                debounce: event.debounce,
                loadScript: dom.loadScript,
                slugify: slugify,
                getDocumentHeight: getDocumentHeight
            }
        }).call(this)
    }, {
        "./dom-manipulation/main": 14,
        "./events/main": 16,
        "moment/moment": 2
    }],
    18: [function(require, module, exports) {
        (function() {
            var contentsTOC, util;
            util = require("../../common/util");
            contentsTOC = {
                init: function() {
                    this.setTitle();
                    return this.setContent()
                },
                setTitle: function() {
                    var navigationTitle, postTitle;
                    postTitle = document.getElementsByClassName("post-title")[0];
                    navigationTitle = document.getElementsByClassName("mdl-layout-title")[0];
                    if (navigationTitle.innerText) {
                        return navigationTitle.innerText = postTitle.innerText
                    } else if (navigationTitle.innerHTML) {
                        return navigationTitle.innerHTML = postTitle.innerHTML
                    }
                },
                setContent: function() {
                    var aLink, childNode, i, len, navigationLinks, results;
                    results = document.querySelectorAll("h2,h3,h4,h5,h6");
                    navigationLinks = document.getElementsByClassName("mdl-navigation")[0];
                    for (i = 0, len = results.length; i < len; i++) {
                        childNode = results[i];
                        aLink = this.processDomChildTag(navigationLinks, childNode);
                        if (aLink) {
                            navigationLinks.appendChild(aLink)
                        }
                    }
                },
                processDomChildTag: function(navigationLinks, childNode) {
                    var aLink, childNodeStr, slugifiedText, tagName, textToSlugify;
                    childNodeStr = childNode ? childNode.className ? childNode.className.toString() : void 0 : null;
                    tagName = childNode.tagName;
                    if (childNode && childNodeStr !== "search-label" && childNodeStr !== "box-title") {
                        if (tagName === "H2" || tagName === "H3" || tagName === "H4" || tagName === "H5" || tagName === "H6") {
                            textToSlugify = childNode.innerText ? childNode.innerText : childNode.innerHTML ? childNode.innerHTML : childNode.textContent;
                            slugifiedText = util.slugify(textToSlugify);
                            childNode.outerHTML += this.createAnchor(slugifiedText).outerHTML;
                            aLink = this.createLinkToAnchor(slugifiedText, textToSlugify, tagName);
                            return aLink
                        }
                    }
                    return null
                },
                createAnchor: function(slugifiedText) {
                    var aTag;
                    aTag = document.createElement("a");
                    aTag.setAttribute("name", slugifiedText);
                    return aTag
                },
                closeDrawer: function() {
                    var className, drawer;
                    className = "mdl-layout__drawer";
                    drawer = document.getElementsByClassName(className)[0];
                    if (/is-visible/.test(drawer.className)) {
                        return drawer.className = className
                    }
                },
                createLinkToAnchor: function(slugifiedText, Text, tagName) {
                    var linkToTag;
                    linkToTag = document.createElement("a");
                    linkToTag.innerHTML = Text;
                    linkToTag.className = "mdl-navigation__link toc" + tagName;
                    linkToTag.href = "#" + slugifiedText;
                    linkToTag.onclick = this.closeDrawer.bind(this);
                    return linkToTag
                }
            };
            module.exports = {
                contentsTOC: contentsTOC
            }
        }).call(this)
    }, {
        "../../common/util": 17
    }],
    19: [function(require, module, exports) {
        (function() {
            var contents, createTOC, init, touch;
            touch = require("./touch-events");
            contents = require("./contents");
            createTOC = {
                init: function() {
                    contents.contentsTOC.init();
                    return touch.touchTOC.init()
                }
            };
            init = function() {
                return createTOC.init()
            };
            module.exports = {
                init: init
            }
        }).call(this)
    }, {
        "./contents": 18,
        "./touch-events": 20
    }],
    20: [function(require, module, exports) {
        (function() {
            var touchTOC;
            touchTOC = {
                init: function() {
                    return this.setupTOCSwipe()
                },
                getOffsetToTopToPostContent: function() {
                    var drawerContainingContainer, extraOffset, postHeader, stickyHeader;
                    postHeader = document.getElementsByClassName("post-header")[0];
                    drawerContainingContainer = document.getElementsByClassName("mdl-layout__container")[0];
                    stickyHeader = document.getElementsByClassName("header header-standard fixed-top")[0];
                    extraOffset = stickyHeader ? Math.max(stickyHeader.clientHeight, stickyHeader.offsetHeight, stickyHeader.scrollHeight) : 0;
                    return {
                        shouldWeAddTopOffset: postHeader.getBoundingClientRect().bottom <= extraOffset,
                        offsetToTopPixels: extraOffset.toString(),
                        newTOCHeightPixels: drawerContainingContainer.getBoundingClientRect().bottom.toString() + "px"
                    }
                },
                handleTOCSwipeOpen: function(ev) {
                    var calculatedDimensions, className, drawer, positionSwitch, topOffset;
                    className = "mdl-layout__drawer";
                    drawer = document.getElementsByClassName(className)[0];
                    if (!/is-visible/.test(drawer.className)) {
                        calculatedDimensions = this.getOffsetToTopToPostContent();
                        topOffset = calculatedDimensions.shouldWeAddTopOffset ? +calculatedDimensions.offsetToTopPixels + "px" : "0";
                        positionSwitch = calculatedDimensions.shouldWeAddTopOffset ? " position: fixed;" : "position: absolute;";
                        drawer.style.cssText += positionSwitch + " top: " + topOffset + ";";
                        drawer.style.cssText += "height: " + calculatedDimensions.newTOCHeightPixels + ";";
                        drawer.className += " is-visible"
                    }
                },
                setupTOCSwipe: function() {
                    var mcShowDrawerSwipe, showDrawer;
                    showDrawer = document.getElementsByClassName("page-content")[0];
                    mcShowDrawerSwipe = new Hammer(showDrawer, {
                        cssProps: {
                            userSelect: true
                        }
                    });
                    return mcShowDrawerSwipe.on("swiperight", this.handleTOCSwipeOpen.bind(this))
                }
            };
            module.exports = {
                touchTOC: touchTOC
            }
        }).call(this)
    }, {}],
    21: [function(require, module, exports) {
        (function() {
            var adsLoaded, domready, scriptLoading, setupHandler, socialSharing, theme, toc;
            theme = require("../blog/theme");
            toc = require("./TOC/main");
            scriptLoading = require("../common/dom-manipulation/main");
            domready = require("domready");
            socialSharing = require("./social_sharing/main");
            adsLoaded = function() {};
            setupHandler = function(event) {
                var asyncJS, twitter;
                theme.init();
                toc.init();
                twitter = socialSharing.twitter();
                asyncJS = [{
                    src: "//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js",
                    asynchronous: true,
                    element: null
                }];
                if (twitter) {
                    asyncJS.push(twitter)
                }
                asyncJS.map(function(script) {
                    scriptLoading.loadScript(script.src, script.asynchronous, script.element, adsLoaded)
                });
                window.removeEventListener("mdl-componentupgraded", setupHandler, false)
            };
            domready(function() {
                return window.addEventListener("mdl-componentupgraded", setupHandler, false)
            })
        }).call(this)
    }, {
        "../blog/theme": 11,
        "../common/dom-manipulation/main": 14,
        "./TOC/main": 19,
        "./social_sharing/main": 23,
        domready: 1
    }],
    22: [function(require, module, exports) {
        (function() {
            var getStyle;
            getStyle = function(x, styleProp) {
                var y;
                if (x.currentStyle) {
                    y = x.currentStyle[styleProp]
                } else if (window.getComputedStyle) {
                    y = document.defaultView.getComputedStyle(x, null).getPropertyValue(styleProp)
                }
                return y
            };
            window.feedDialog = function(id, caption, picture) {
                var cap, childNode, description, div, i, pic, title;
                title = void 0;
                description = void 0;
                div = document.getElementById(id);
                pic = void 0;
                cap = caption ? caption : "";
                i = 0;
                childNode = void 0;
                while (i <= div.childNodes.length) {
                    childNode = div.childNodes[i];
                    if (childNode) {
                        if (/mdl-card__supporting-text/.test(childNode.className)) {
                            description = childNode.textContent
                        } else if (/mdl-card__title/.test(childNode.className)) {
                            title = childNode.innerText;
                            pic = !picture ? getStyle(childNode, "background-image") : picture;
                            pic = pic.replace(/^url\(["']?/, "").replace(/["']?\)$/, "")
                        }
                    }
                    i++
                }
                FB.ui({
                    method: "feed",
                    name: title,
                    link: window.location.href,
                    description: description,
                    caption: cap,
                    picture: pic,
                    display: "popup"
                }, function(response, show_error) {
                    if (response && response.post_id) {
                        console.log("Post was published.")
                    } else {
                        console.log("Post was not published.")
                    }
                })
            };
            window.fbAsyncInit = function() {
                FB.init({
                    appId: "108283983076134",
                    xfbml: true,
                    version: "v2.4"
                })
            };
            (function(d, s, id) {
                var fjs, js;
                js = void 0;
                fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs)
            })(document, "script", "facebook-jssdk")
        }).call(this)
    }, {}],
    23: [function(require, module, exports) {
        (function() {
            var fb, twitter;
            fb = require("./facebook-sdk");
            twitter = require("./twitter");
            module.exports = {
                twitter: twitter.init
            }
        }).call(this)
    }, {
        "./facebook-sdk": 22,
        "./twitter": 24
    }],
    24: [function(require, module, exports) {
        (function() {
            var TwitterElements, init;
            TwitterElements = {
                init: function() {
                    var twitterCards;
                    twitterCards = document.getElementsByClassName("twitter-tweet")[0];
                    if (twitterCards) {
                        return {
                            src: "//platform.twitter.com/widgets.js",
                            asynchronous: true,
                            element: null
                        }
                    } else {
                        return null
                    }
                }
            };
            init = function() {
                return TwitterElements.init()
            };
            module.exports = {
                init: init
            }
        }).call(this)
    }, {}]
}, {}, [21]);