<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"
    href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback') }}" />
<link rel="icon" href="{{ asset($logo) }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('../../plugins/fontawesome-free/css/all.min.css') }}" />

<link rel="stylesheet" href="{{ asset('../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />

<link rel="stylesheet" href="{{ asset('../../dist/css/adminlte.min2167.css?v=3.2.0') }}" />


<script nonce="d4cfe204-cbf9-4890-8e13-ef8d0a90d985">
    (function(w, d) {
        !(function(j, k, l, m) {
            j[l] = j[l] || {};
            j[l].executed = [];
            j.zaraz = {
                deferred: [],
                listeners: []
            };
            j.zaraz.q = [];
            j.zaraz._f = function(n) {
                return async function() {
                    var o = Array.prototype.slice.call(arguments);
                    j.zaraz.q.push({
                        m: n,
                        a: o
                    });
                };
            };
            for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
            j.zaraz.init = () => {
                var q = k.getElementsByTagName(m)[0],
                    r = k.createElement(m),
                    s = k.getElementsByTagName("title")[0];
                s && (j[l].t = k.getElementsByTagName("title")[0].text);
                j[l].x = Math.random();
                j[l].w = j.screen.width;
                j[l].h = j.screen.height;
                j[l].j = j.innerHeight;
                j[l].e = j.innerWidth;
                j[l].l = j.location.href;
                j[l].r = k.referrer;
                j[l].k = j.screen.colorDepth;
                j[l].n = k.characterSet;
                j[l].o = new Date().getTimezoneOffset();
                if (j.dataLayer)
                    for (const w of Object.entries(
                            Object.entries(dataLayer).reduce(
                                (x, y) => ({
                                    ...x[1],
                                    ...y[1]
                                }), {}
                            )
                        ))
                        zaraz.set(w[0], w[1], {
                            scope: "page"
                        });
                j[l].q = [];
                for (; j.zaraz.q.length;) {
                    const z = j.zaraz.q.shift();
                    j[l].q.push(z);
                }
                r.defer = !0;
                for (const A of [localStorage, sessionStorage])
                    Object.keys(A || {})
                    .filter((C) => C.startsWith("_zaraz_"))
                    .forEach((B) => {
                        try {
                            j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B));
                        } catch {
                            j[l]["z_" + B.slice(7)] = A.getItem(B);
                        }
                    });
                r.referrerPolicy = "origin";
                r.src =
                    "../../../../cdn-cgi/zaraz/sd0d9.js?z=" +
                    btoa(encodeURIComponent(JSON.stringify(j[l])));
                q.parentNode.insertBefore(r, q);
            };
            ["complete", "interactive"].includes(k.readyState) ?
                zaraz.init() :
                j.addEventListener("DOMContentLoaded", zaraz.init);
        })(w, d, "zarazData", "script");
    })(window, document);
</script>


<link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback" />

<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css" />

<link rel="stylesheet" href="../../dist/css/adminlte.min2167.css?v=3.2.0" />

<link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css" />
<script nonce="04dddd38-65f7-47ad-9626-d032b155c991">
    (function(w, d) {
        !(function(j, k, l, m) {
            j[l] = j[l] || {};
            j[l].executed = [];
            j.zaraz = {
                deferred: [],
                listeners: []
            };
            j.zaraz.q = [];
            j.zaraz._f = function(n) {
                return async function() {
                    var o = Array.prototype.slice.call(arguments);
                    j.zaraz.q.push({
                        m: n,
                        a: o
                    });
                };
            };
            for (const p of ["track", "set", "debug"]) j.zaraz[p] = j.zaraz._f(p);
            j.zaraz.init = () => {
                var q = k.getElementsByTagName(m)[0],
                    r = k.createElement(m),
                    s = k.getElementsByTagName("title")[0];
                s && (j[l].t = k.getElementsByTagName("title")[0].text);
                j[l].x = Math.random();
                j[l].w = j.screen.width;
                j[l].h = j.screen.height;
                j[l].j = j.innerHeight;
                j[l].e = j.innerWidth;
                j[l].l = j.location.href;
                j[l].r = k.referrer;
                j[l].k = j.screen.colorDepth;
                j[l].n = k.characterSet;
                j[l].o = new Date().getTimezoneOffset();
                if (j.dataLayer)
                    for (const w of Object.entries(
                            Object.entries(dataLayer).reduce(
                                (x, y) => ({
                                    ...x[1],
                                    ...y[1]
                                }), {}
                            )
                        ))
                        zaraz.set(w[0], w[1], {
                            scope: "page"
                        });
                j[l].q = [];
                for (; j.zaraz.q.length;) {
                    const z = j.zaraz.q.shift();
                    j[l].q.push(z);
                }
                r.defer = !0;
                for (const A of [localStorage, sessionStorage])
                    Object.keys(A || {})
                    .filter((C) => C.startsWith("_zaraz_"))
                    .forEach((B) => {
                        try {
                            j[l]["z_" + B.slice(7)] = JSON.parse(A.getItem(B));
                        } catch {
                            j[l]["z_" + B.slice(7)] = A.getItem(B);
                        }
                    });
                r.referrerPolicy = "origin";
                r.src =
                    "../../../../cdn-cgi/zaraz/sd0d9.js?z=" +
                    btoa(encodeURIComponent(JSON.stringify(j[l])));
                q.parentNode.insertBefore(r, q);
            };
            ["complete", "interactive"].includes(k.readyState) ?
                zaraz.init() :
                j.addEventListener("DOMContentLoaded", zaraz.init);
        })(w, d, "zarazData", "script");
    })(window, document);
</script>

@if (request()->is('finance*') || request()->is('farm-module*'))
    <style>
        .select2,
        input,
        select {
            font-weight: 550 !important;
        }
    </style>
@endif
<style>
    /* FINANCE */

    /* // VALIDATE */
    input.invalid,
    textarea.invalid,
    select.invalid,
    .match_error,
    .match_error:focus {
        border-color: #b00 !important;
    }

    .validation_error {
        margin: .4em 0 1em;
        color: #b00 !important;
        font-size: .7em;
        text-transform: uppercase;
        letter-spacing: .15em;
    }











    /* FILE UPLOAD STYLES */
    .file-upload {
        max-width: 100%;
        margin: 0px auto 0 0px;
        padding: 20px;
    }

    .file-upload-btn {
        width: 100%;
        margin: 0;
        color: #fff;
        background: #1FB264;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #15824B;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .file-upload-btn:hover {
        background: #1AA059;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .file-upload-btn:active {
        border: 0;
        transition: all .2s ease;
    }

    .file-upload-content {
        display: none;
        text-align: center;
    }

    .file-upload-input {
        position: absolute;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        outline: none;
        opacity: 0;
        cursor: pointer;
    }

    .image-upload-wrap {
        margin-top: 20px;
        border: 4px dashed #1FB264;
        position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
        background-color: #1FB264;
        border: 4px dashed #ffffff;
    }

    .image-title-wrap {
        padding: 0 15px 15px 15px;
        color: #222;
    }

    .drag-text {
        text-align: center;
    }

    .drag-text h3 {
        font-weight: 100;
        text-transform: uppercase;
        color: #15824B;
        padding: 60px 0;
    }

    .file-upload-image {
        max-height: 100px;
        max-width: 100px;
        margin: auto;
        padding: 20px;
    }

    .remove-image {
        width: 200px;
        margin: 0;
        color: #fff;
        background: #cd4535;
        border: none;
        padding: 10px;
        border-radius: 4px;
        border-bottom: 4px solid #b02818;
        transition: all .2s ease;
        outline: none;
        text-transform: uppercase;
        font-weight: 700;
    }

    .remove-image:hover {
        background: #c13b2a;
        color: #ffffff;
        transition: all .2s ease;
        cursor: pointer;
    }

    .remove-image:active {
        border: 0;
        transition: all .2s ease;
    }


    .select2-container .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
        /* Matches Bootstrap's .form-control height */
        padding: 0.375rem 0.75rem;
        /* Matches Bootstrap's padding */
        font-size: 1rem;
        /* Matches Bootstrap's font size */
        line-height: 1.5;
        /* Matches Bootstrap's line height */
        border: 1px solid #ced4da;
        /* Matches Bootstrap's border */
        border-radius: 0.375rem;
        /* Matches Bootstrap's border-radius */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: calc(1.5em + 0.75rem + 2px) !important;
        /* Center the text */
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: calc(1.5em + 0.75rem + 2px) !important;
        /* Adjust the arrow height */
    }
</style>
