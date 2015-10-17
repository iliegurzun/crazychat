var proton = {}, verboseBuild = !0, screenXs = 480, screenMd = 992, ltIE9 = !1;
!$("html").is(".lt-ie9") || (ltIE9 = !0), ltIE9 && (verboseBuild = !1), Modernizr.addTest("ipad", function() {
    return!!navigator.userAgent.match(/iPad/i)
}), Modernizr.addTest("iphone", function() {
    return!!navigator.userAgent.match(/iPhone/i)
}), Modernizr.addTest("ipod", function() {
    return!!navigator.userAgent.match(/iPod/i)
}), Modernizr.addTest("appleios", function() {
    return Modernizr.ipad || Modernizr.ipod || Modernizr.iphone
}), Modernizr.appleios && $("html").addClass("ios-device"), !verboseBuild || $(document).ready(function() {
    !verboseBuild || proton.common.build()
}), proton.common = {build: function() {
        proton.common.events(), proton.common.enableTooltips(), proton.common.enableScrollSpy();
        var a, b = 50;
        $(window).resize(function() {
            clearTimeout(a), a = setTimeout(function() {
                proton.common.onResizeEnd()
            }, b)
        }), ltIE9 || Modernizr.mq("(min-width:" + screenXs + "px)") ? (setTimeout(function() {
            $(".sidebar").addClass("animated fadeInLeft"), setTimeout(function() {
                $(".sidebar").removeClass("animated fadeInLeft").css("opacity", "1")
            }, 1050)
        }, 50), setTimeout(function() {
            $(".wrapper").addClass("animated fadeInRight"), setTimeout(function() {
                $(".wrapper").removeClass("animated fadeInRight").css("opacity", "1")
            }, 1050)
        }, 150)) : setTimeout(function() {
            $(".sidebar, .wrapper").addClass("animated fadeInUp"), setTimeout(function() {
                $(".sidebar, .wrapper").removeClass("animated fadeInUp").css("opacity", "1")
            }, 1050)
        }, 50), !verboseBuild
    }, events: function() {
        !verboseBuild , $(document).on("touchmove", function(a) {
            a.preventDefault()
        }), $("body").on("touchmove", ".scrollable, nav", function(a) {
            a.stopPropagation()
        }), $("body").on("touchstart", ".scrollable", function(a) {
            0 === a.currentTarget.scrollTop ? a.currentTarget.scrollTop = 1 : a.currentTarget.scrollHeight === a.currentTarget.scrollTop + a.currentTarget.offsetHeight && (a.currentTarget.scrollTop -= 1)
        })
    }, onResizeEnd: function() {
        !verboseBuild, !verboseBuild, !proton.userNav || proton.userNav.shuffleUserNav(), !proton.dashboard || proton.dashboard.setBlankWidgets(), setTimeout(function() {
            !(proton.graphsStats && proton.graphsStats.redrawCharts) || proton.graphsStats.redrawCharts(), !(proton.userProfile && proton.userProfile.redrawCharts) || proton.userProfile.redrawCharts()
        }, 1e3), !proton.sidebar || proton.sidebar.retractOnResize(), !proton.sidebar || proton.sidebar.setSidebarMobHeight()
    }, enableTooltips: function() {
        !verboseBuild || $(".uses-tooltip").tooltip({container: "body"}), $(".progress-bar").each(function() {
            var a = Math.round(100 * (parseInt($(this).css("width")) / parseInt($(this).parent().css("width")))) + "%";
            $(this).tooltip({container: "body", title: a})
        })
    }, enableScrollSpy: function() {
    }}, $(document).ready(function() {
    !verboseBuild, proton.mainNav.build()
}), proton.mainNav = {build: function() {
        proton.mainNav.events(), !verboseBuild
    }, events: function() {
        !verboseBuild, $(".touch nav.main-menu").on("mouseover", function() {
            return $(this).addClass("expanded"), !1
        }), $(".main-menu-access").on("click", function() {
            return $("nav.user-menu > section .active").removeClass("active"), $(".nav-view").fadeOut(30), $(this).is(".active") ? ($(this).removeClass("active"), $("nav.main-menu").removeClass("expanded")) : ($("nav.main-menu").addClass("expanded"), $(this).addClass("active")), !1
        }), $(".touch body").on("mouseout touchstart", function() {
            $(".touch nav.main-menu").is(".expanded") && ($(".main-menu-access").removeClass("active"), $("nav.main-menu").find(".active").removeClass("active"), $(".touch nav.main-menu").removeClass("expanded"), $("html, body").animate({scrollTop: 0}, 300, "swing")), $("nav.user-menu > section .active").removeClass("active"), $(".nav-view").fadeOut(30)
        }), $(".touch nav.main-menu, .touch nav.user-menu").on("touchstart", function(a) {
            a.stopPropagation()
        }), $(".touch nav.main-menu ul").on("click", "li", function(a) {
            return $(this).is(".active") ? ($(this).removeClass("active"), a.stopPropagation(), void 0) : ($("nav.main-menu").find("li").removeClass("active"), $(this).addClass("active"), void 0)
        })
    }}, $(document).ready(function() {
    !verboseBuild || proton.userNav.build()
}), proton.userNav = {build: function() {
        proton.userNav.events(), proton.userNav.shuffleUserNav(), setTimeout(function() {
            proton.userNav.bounceCounter()
        }, 3e3), !verboseBuild
    }, events: function() {
        !verboseBuild, $(document).on("click", ".user-menu-wrapper a", function() {
            var a = $(this).attr("data-expand");
            return $(this).is(".unread") && ($(this).removeClass("unread"), $(this).find(".menu-counter").fadeOut("100", function() {
                $(this).remove()
            })), $("nav.main-menu").removeClass("expanded"), $(".main-menu-access").removeClass("active"), $("nav.user-menu > section .active").not(this).removeClass("active"), $(this).toggleClass("active"), $(".nav-view").not(a).fadeOut(60), setTimeout(function() {
                $(a).fadeToggle(60)
            }, 60), !1
        }), $(document).on("click", ".close-user-menu", function() {
            $("nav.user-menu > section .active").removeClass("active"), $(".nav-view").fadeOut(30)
        }), $(document).on("click", ".theme-view li", function() {
            var a = $(this).attr("data-theme");
            $("body").removeClass(function(a, b) {
                return(b.match(/\btheme-\S+/g) || []).join(" ")
            }), $.cookie("protonTheme", a, {expires: 7, path: "/"}), "default" !== a && $("body").addClass(a)
        })
    }, shuffleUserNav: function() {
        !verboseBuild , ltIE9 || Modernizr.mq("(min-width:" + screenXs + "px)") ? $("body > .user-menu").prependTo(".wrapper") : $(".wrapper .user-menu").prependTo("body")
    }, bounceCounter: function() {
        $(".menu-counter").length && ($(".menu-counter").toggleClass("animated bounce"), setTimeout(function() {
            $(".menu-counter").toggleClass("animated bounce")
        }, 1e3), setTimeout(function() {
            proton.userNav.bounceCounter()
        }, 5e3))
    }};