!function() {
    "use strict";
    var t = React
      , e = ReactDOM
      , a = function(t) {
        var e = t.attributes
          , a = t.clientId
          , n = t.custom
          , c = n.activeIndex
          , o = n.carousel
          , r = void 0 === o ? null : o
          , l = n.setCarousel
          , s = t.react
          , i = s.useEffect
          , u = s.useRef
          , d = e.sliders
          , b = e.options
          , m = e.arrow
          , v = e.indicator
          , g = e.animation
          , h = u();
        return i((function() {
            null == r || r.to(c || 0)
        }
        ), [c]),
        i((function() {
            if (null != h && h.current) {
                r && r.dispose();
                var t = new bootstrap.Carousel(h.current,{
                    interval: b.interval,
                    ride: !0 === b.ride && "carousel",
                    pause: !0 === b.pause && "hover"
                });
                l && l(t)
            }
        }
        ), [b]),
        React.createElement("div", {
            className: "bsbCarousel slide carousel ".concat(g),
            ref: h
        }, v.visibility && React.createElement(React.Fragment, null, React.createElement("div", {
            className: "carousel-indicators"
        }, d.map((function(t, e) {
            return React.createElement("button", {
                key: e,
                type: "button",
                "data-bs-target": "#bsbCarousel-".concat(a, " .carousel"),
                "data-bs-slide-to": e,
                className: "".concat(0 === e ? "active" : ""),
                "aria-current": "true",
                "aria-label": "Slide 1"
            })
        }
        )))), React.createElement("div", {
            className: "carousel-inner"
        }, d.map((function(t, e) {
            var a = t || {}
              , n = a.img
              , c = a.title
              , o = a.desc;
            return React.createElement("div", {
                key: e,
                className: "carousel-item ".concat(0 === e ? "active" : "")
            }, (null == n ? void 0 : n.url) && React.createElement("img", {
                src: n.url,
                className: "d-block w-100",
                alt: (null == n ? void 0 : n.alt) || (null == n ? void 0 : n.title)
            }), React.createElement("div", {
                className: "carousel-caption bsbContentMiddle"
            }, React.createElement("h5", null, c), React.createElement("p", null, o)))
        }
        ))), m.visibility && React.createElement(React.Fragment, null, React.createElement("div", {
            className: "bsbButtonDesign"
        }, React.createElement("button", {
            className: "carousel-control-prev",
            type: "button",
            "data-bs-target": "#bsbCarousel-".concat(a, " .carousel"),
            "data-bs-slide": "prev",
            "aria-label": "Carousel left arrow"
        }, React.createElement("div", {
            className: "bsbArrowButton"
        }, React.createElement("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            height: m.size,
            width: m.size,
            viewBox: "0 0 48 48"
        }, React.createElement("path", {
            d: "m33 44l-20-20 20-20 2.8 2.8-17.2 17.2 17.2 17.1z"
        })))), React.createElement("button", {
            className: "carousel-control-next",
            type: "button",
            "data-bs-target": "#bsbCarousel-".concat(a, " .carousel"),
            "data-bs-slide": "next",
            "aria-label": "Carousel right arrow"
        }, React.createElement("div", {
            className: "bsbArrowButton"
        }, React.createElement("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            height: m.size,
            width: m.size,
            viewBox: "0 0 48 48"
        }, React.createElement("path", {
            d: "m15.2 43.9-2.8-2.85L29.55 23.9 12.4 6.75l2.8-2.85 20 20Z"
        })))))))
    }
      , n = function(t) {
        return Object.values(t).join(" ")
    }
      , c = function(t) {
        var e = t.attributes
          , a = t.clientId
          , c = e.titleTypo
          , o = e.titleColor
          , r = e.descTypo
          , l = e.descColor
          , s = e.titleMargin
          , i = e.descMargin
          , u = e.arrow
          , d = e.indicator
          , b = e.SliderOverly
          , m = e.height
          , v = e.borderRadius
          , g = e.position
          , h = e.arrowWidth
          , p = e.arrowHeight
          , R = e.arrowRadius;
        return React.createElement("style", {
            dangerouslySetInnerHTML: {
                __html: "\n\t\t#bsbCarousel-".concat(a, " h5{\n\t\t\t").concat((null == c ? void 0 : c.styles) || "font-size: 25px;font-weight:700;line-height:135%;", "\n\t\t\tcolor: ").concat(o, ";\n\t\t\tmargin: ").concat(n(s), ";\n\t\t}\n\t\t#bsbCarousel-").concat(a, " p {\n\t\t\t").concat((null == r ? void 0 : r.styles) || "font-size: 20px;line-height:135%;", "\n\t\t\tcolor: ").concat(l, ";\n\t\t\tmargin: ").concat(n(i), ";\n\t\t\t \n\t\t} \n\t\t#bsbCarousel-").concat(a, " .carousel-item {\n\t\t\theight: ").concat(m, ";\n\t\t\tborder-radius: ").concat(n(v), ";\n    \t\tbox-sizing: border-box;\n    \t\toverflow: hidden;\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .bsbButtonDesign .bsbArrowButton {\n\t\t\tfont-size:").concat(null == u ? void 0 : u.size, "px;\n\t\t\t").concat((null == u ? void 0 : u.styles) || "color: #333; background: #transparent;", ";\n\t\t\twidth:").concat(h, ";\n\t\t\theight:").concat(p, ";\n\t\t\tborder-radius:").concat(n(R), ";\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .bsbButtonDesign .bsbArrowButton svg{\n\t\t\tfill:").concat(u.color, ";\n\t\t}\n \n\t\t#bsbCarousel-").concat(a, " .carousel-item{\n\t\t\tposition:relative;\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .carousel-item:after{\n\t\t\tcontent: '';\n\t\t\twidth: 100%;\n\t\t\theight: 100%;\n\t\t\ttop: 0;\n\t\t\tposition: absolute;\n\t\t\tleft: 0;\n\t\t\tbackground: ").concat(b, ";\n\t\t}\n\t\t#bsbCarousel-").concat(a, " .carousel-indicators button {\n\t\t\twidth: ").concat(null == d ? void 0 : d.width, " !important;\n\t\t\theight: ").concat(null == d ? void 0 : d.height, " !important;\n\t\t\tborder-radius: ").concat(null == d ? void 0 : d.radius, ";\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .carousel-indicators button{\n\t\t\tbackground-color:").concat(d.color, "\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .carousel-indicators button.active{\n\t\t\tbackground-color:").concat(d.activeColor, ";\n\t\t}\n\n\t\t#bsbCarousel-").concat(a, " .carousel-caption.bsbContentMiddle{\n\t\t\ttop: ").concat(null == g ? void 0 : g.top, "\n\t\t}\n\t\t\n\t\t").replace(/\s+/g, " ")
            }
        })
    };
    document.addEventListener("DOMContentLoaded", (function() {
        document.querySelectorAll(".wp-block-bsb-slider").forEach((function(n) {
            var o = JSON.parse(n.dataset.attributes);
            (0,
            e.render)(React.createElement(React.Fragment, null, React.createElement(c, {
                attributes: o,
                clientId: o.cId
            }), React.createElement(a, {
                attributes: o,
                clientId: o.cId,
                custom: {},
                react: {
                    useEffect: t.useEffect,
                    useRef: t.useRef
                }
            })), n),
            null == n || n.removeAttribute("data-attributes")
        }
        ))
    }
    ))
}();
