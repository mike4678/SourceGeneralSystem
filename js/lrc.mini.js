function lcz() {
    var _this = this;
    this.lrc_object,
    this.lrc_lines,
    this.upkp,
    this.classV1,
    this.classV2,
    this.initTop,
    this.center,
    this.empty,
    this.isDropLrc,
    this.width,
    this.height,
    this.align,
    this.oneline,
    this.luminous,
    this.change,
    this.staue = !0,
    this.tag = {},
    this.mould = '<ul style="height: 300px;list-style: none;position: relative;line-height: 20px;padding: 0;overflow-y: hidden;display:none;"></ul>',
    this.getlrc = "Value";
    var errmsg = "程序发生异常，无法继续了！";
    this.toTimer = function(e) {
        var t, n;
        return t = Math.floor(e / 60),
        t = isNaN(t) ? "--": t >= 10 ? t: "0" + t,
        n = Math.floor(e % 60),
        n = isNaN(n) ? "--": n >= 10 ? n: "0" + n,
        t + ":" + n
    },
    this.addLrc = function(e, t, n) {
        var r = document.createElement("li");
        r.innerHTML = t ? t: "",
        r.className = e ? e: "",
        r.lang = n ? n: "",
        this.lrc_object.appendChild(r),
        this.lrc_lines.push(r)
    },
    this.getLrcByValue = function(e) {
        le = this.lrc_lines.length,
        e = "^" + e + ".*";
        for (var t = 0; t < le; t++) if (this.lrc_lines[t].lang.search(e) == 0) return this.lrc_lines[t];
        return null
    },
    this.getLrcByValueInd = function(e) {
        le = this.lrc_lines.length - 1;
        for (var t = le; t >= 0; t--) {
            p = this.lrc_lines[t].lang;
            if (p && p < e) return this.lrc_lines[t]
        }
        return null
    },
    this.setClassName = function(e, t) {
        e && (e.className = t)
    },
    this.upTop = function(e) {
        var t = e.offsetTop,
        n = this.lrc_object.scrollTop,
        r = t - this.center;
        this.myf(this.lrc_object, n, r)
    },
    this.remove = function() {
        if (this.lrc_lines != null) for (var e = 0; e < this.lrc_lines.length; e++) this.lrc_object.removeChild(this.lrc_lines[e]);
        this.lrc_lines = new Array,
        !this.empty && this.empty != 0 && alert("empty 属性有误! 该值必须>=零"),
        this.setNbsp()
    },
    this.setNbsp = function() {
        for (var e = 0; e < this.empty; e++) this.addLrc("", "&nbsp;", "")
    },
    this.load = function(json, fun) {
        lrcs = json.lrcs,
        end = json[this.tag.end];
        with(this) remove(),
        _addLrc(json[this.tag.sname]),
        _addLrc(json[this.tag.cname]),
        _addLrc(json[this.tag.qname]),
        _addLrc(json[this.tag.bname]),
        _addLrc(json[this.tag.sgname]),
        _addLrc(json[this.tag.special]),
        _addLrc(json[this.tag.kname]);
        if (lrcs) for (var index in lrcs) this.addLrc(this.classV1, lrcs[index].name, lrcs[index].time);
        end && (end.time ? this.addLrc(this.classV1, end.end, end.time) : this.addLrc(this.classV1, end)),
        this.setNbsp(),
        typeof fun == "function" && fun.call(null, null)
    },
    this._addLrc = function(e) {
        e && (e.time ? this.addLrc(this.classV1, e.name, e.time) : this.addLrc(this.classV1, e))
    },
    this.Read = function(e, t) {
        if (t != null && typeof t == "function") return t.call(this, e);
        var n = {};
        n.lrcs = new Array;
        var r = e.split("["),
        i = r.length;
        for (var s = 0; s < i; s++) {
            var o = r[s],
            u = o.split("]");
            if (u.length == 2) if (u[0].search("^[0-9]{2}:[0-9]{2}.[0-9]{2}$") < 0) title = u[0].split(":"),
            n = tagswitch(title, n);
            else {
                var a = {
                    time: u[0],
                    name: u[1]
                };
                n.lrcs.push(a)
            }
        }
        return n
    },
    this.vls1 = function(e) {
        var n = {};
        n.lrcs = new Array;
        var r = e.length,
        i = 0,
        s = 0,
        o = new Array;
        for (var u = 0; u < r; u++) e[u] == "[" && u > 8 && (e.slice(u - 9, u - 1) + "").search("^[0-9]{2}:[0-9]{2}.[0-9]{2}$") < 0 && (o.push(e.substring(i, u)), i = u);
        o.push(e.substring(i, r));
        var a = {},
        f = [];
        for (var u = 0; u < o.length; u++) {
            var l = o[u],
            c = l.split("]");
            if (c.length === 2)(c[0] + "").search("^\\[[0-9]{2}:[0-9]{2}.[0-9]{2}$") < 0 ? (c[0] = c[0].slice(1), title = c[0].split(":"), n = tagswitch(title, n)) : (h = c[0].slice(1) + "", a[h] = c[1], f.push(h));
            else if (c.length > 2) {
                var h, e;
                e = c[c.length - 1];
                for (var p in c) c[p].search("^\\[[0-9]{2}:[0-9]{2}.[0-9]{2}$") == 0 && (h = c[p].slice(1) + "", a[h] = e, f.push(h))
            }
        }
        f = f.sort();
        for (var p in f) {
            t = f[p];
            var d = {
                time: t,
                name: a[t]
            };
            n.lrcs.push(d)
        }
        return n
    };
    var tagswitch = function(e, t) {
        e.length === 2 && (tp = e[1]),
        tag = _this.tag;
        switch (e[0]) {
        case tag.sname:
            t[tag.sname] = tp;
            break;
        case tag.cname:
            t[tag.cname] = tp;
            break;
        case tag.qname:
            t[tag.qname] = tp;
            break;
        case tag.bname:
            t[tag.bname] = tp;
            break;
        case tag.sgname:
            t[tag.sgname] = tp;
            break;
        case tag.special:
            t[tag.special] = tp;
            break;
        case tag.kname:
            t[tag.kname] = tp;
            break;
        case tag.end:
            t[tag.end] = tp
        }
        return t
    };
    this.myf_Init = function() {
        this.lrc_object.innerHTML = this.mould,
        asc = this.lrc_object = this.lrc_object.firstChild,
        asc.style.width = this.width,
        asc.style.height = this.height,
        asc.style.textAlign = this.align,
        this.oneline ? (this.empty = 0, this.center = 10) : (this.empty = 10, this.center = this.lrc_object.style.height / 2 | 100),
        this.isDropLrc && this.logon(!1)
    },
    this.setoccupy = function(e, t) {
        e.style.display = "block",
        this.setClassName(e, this.classV2),
        this.upTop(e),
        this.upkp && this.unoccupy(this.upkp),
        this.upkp = e,
        t && t(e)
    },
    this.unoccupy = function(e, t) {
        this.setClassName(e, this.classV1),
        this.oneline && (e.style.display = "none"),
        t && t(e)
    },
    this.torun = function(time) {
        if (!this.staue) return ! 1;
        var time = this.toTimer(Math.round((time | event.srcElement.currentTime) * 100) / 100),
        line = eval("this.getLrcBy" + this.getlrc + "(time)");
        line && this.upkp != line && this.setoccupy(line)
    },
    this.logon = function(e) {
        if (window.FileReader) {
            var t = this.lrc_object;
            e && (t = document.getElementById(e));
            function n(e) {
                e.stopPropagation(),
                e.preventDefault();
                var t = e.dataTransfer.files;
                for (var n = 0,
                r; r = t[n]; n++) {
                    var i = new FileReader;
                    i.onloadend = function(e) {
                        return function(e) {
                            img = e.target.result,
                            img && _this.load(_this.Read(img))
                        }
                    } (r),
                    i.readAsText(r)
                }
            }
            function r(e) {}
            function i(e) {}
            function s(e) {
                e.stopPropagation(),
                e.preventDefault()
            }
            t.addEventListener("dragenter", r, !1),
            t.addEventListener("dragover", s, !1),
            t.addEventListener("drop", n, !1),
            t.addEventListener("dragleave", i, !1),
            t.addEventListener("ondragend", i, !1)
        } else alert("你的浏览器不支持啊，同学")
    };
    var timer = null;
    this.myf = function(e, t, n) {
        timer != null && clearTimeout(timer),
        this.isUpOrDown(e, t, n)
    },
    getUpValue = function(e, t) {
        return t - e > 100 ? e += 30 : t - e > 50 ? e += 10 : t - e > 20 ? e += 5 : t - e > 1 && e++,
        e
    },
    getDowmValue = function(e, t) {
        return e - t > 100 ? e -= 30 : e - t > 50 ? e -= 10 : e - t > 20 ? e -= 5 : e - t > 1 && e--,
        e
    },
    this.isUpOrDown = function(e, t, n) {
        t < n ? this.toUp(e, t, n) : this.toDown(e, t, n)
    },
    this.toUp = function(e, t, n) {
        timer = setInterval(function() {
            t >= n && (clearTimeout(timer), timer = null, e.scrollTop = n),
            e.scrollTop = t,
            t = getUpValue(t, n)
        },
        10)
    },
    this.toDown = function(e, t, n) {
        timer = setInterval(function() {
            t <= n && (clearTimeout(timer), timer = null, e.scrollTop = n),
            e.scrollTop = t,
            t = getDowmValue(t, n)
        },
        30)
    },
    this.destory = function() {}
}
lrc = {
    msg: {
        ms1: "元素位置没有给出！ error : 103",
        ms2: "请给出歌词的链接地址，或文本内容！ error : 105"
    },
    tag: {
        sname: "ti",
        cname: "cl",
        qname: "cs",
        bname: "ps",
        sgname: "ar",
        special: "al",
        kname: "by",
        end: "end"
    },
    build: function(e, t) {
        var n = new lcz;
        return n.tag = lrc.tag,
        e.object ? n.lrc_object = document.getElementById(e.object) : alert(lrc.msg.ms1),
        n.initTop = e["initTop"] != null ? e.initTop: 0,
        n.center = e["center"] != null ? e.center: 0,
        n.empty = e["empty"] != null ? e.empty: 0,
        n.isDropLrc = e["isDropLrc"] != null ? e.isDropLrc: !0,
        n.getlrc = e["seekMark"] != null ? e.seekMark: "Value",
        t && (n.classV1 = t["notoccupy"] != null ? t.notoccupy: "lrc_moonlight", n.classV2 = t["occupy"] != null ? t.occupy: "lrc_attention", n.width = t["width"], n.height = t["height"] != null ? t.height: "200px", n.align = t["align"] != null ? t.align: "center", n.oneline = t["oneline"] != null ? t.oneline: !1),
        n.myf_Init(),
        lrc.readlrc(n, e.readType, {
            url: e.lrcUrl ? e.lrcUrl: null,
            text: e.lrcText ? e.lrcText: null
        },
        function() {
            n.lrc_object.scrollTop = n.initTop,
            n.oneline && (n.lrc_object.className += " lrc_hide"),
            e.syntony && e.syntony(n)
        }) && e.open && lrc.open(n),
        e.media && (mp = document.getElementById(e.media), window.attachEvent ? mp.attachEvent("ontimeupdate",
        function() {
            n.torun()
        }) : mp.addEventListener("timeupdate",
        function() {
            n.torun()
        },
        !1)),
        n
    },
    readlrc: function(e, t, n, r) {
        var i = "";
        if (n.text) i = n.text;
        else {
            if (!n.url) return alert(lrc.msg.ms2),
            !1;
            xmlhttp = null,
            window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest: window.ActiveXObject && (xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")),
            xmlhttp != null && (xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4) {
                    if (xmlhttp.status == 200) return i = xmlhttp.responseText,
                    i = i.replace(/<\/?.+?>/g, "").replace(/[\r\n]/g, ""),
                    e.load(e.Read(i, t), r),
                    !0;
                    alert("在获取url 歌词的时候发生了错误:" + xmlhttp.statusText)
                }
            },
            xmlhttp.open("GET", n.url, !0), xmlhttp.send(null))
        }
        return e.load(e.Read(i, t), r),
        !0
    },
    open: function(e) {
        e.lrc_object && (e.lrc_object.style.display = "block"),
        e.staue = !0
    },
    close: function(e) {
        e.lrc_object && (e.lrc_object.style.display = "none"),

        e.staue = !1
    },
    suspend: function(e) {
        e.lrc_object && (e.staue = !1)
    },
    destroy: function(e) {
        lrc.close(e),
        e.remove(e.lrc_object)
    },
    setProgress: function(e, t) {
        e.torun(t)
    }
}