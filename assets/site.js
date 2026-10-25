(function () {
  var S = window.SITE || {};
  var $ = function (s, r) { return (r || document).querySelector(s); };
  var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

  /* ---------- Apply settings from config.js ---------- */
  if (S.brand) {
    $$("[data-brand]").forEach(function (el) { el.textContent = S.brand; });
    document.title = document.title.replace(/Better Yet/g, S.brand);
  }
  if (S.tagline) $$("[data-tagline]").forEach(function (el) { el.textContent = S.tagline; });
  if (S.email) $$("[data-email]").forEach(function (el) { el.textContent = S.email; el.href = "mailto:" + S.email; });
  if (S.phone) {
    $$("[data-phone]").forEach(function (el) { el.textContent = S.phone; el.href = "tel:" + S.phone.replace(/\s+/g, ""); });
    $$("[data-phone-wrap]").forEach(function (el) { el.hidden = false; });
  }
  if (S.abn) $$("[data-abn]").forEach(function (el) { el.textContent = S.abn; });
  [["instagram", "[data-instagram]"], ["linkedin", "[data-linkedin]"]].forEach(function (p) {
    if (S[p[0]]) $$(p[1]).forEach(function (el) { el.href = S[p[0]]; el.target = "_blank"; el.rel = "noopener"; el.hidden = false; });
  });
  var y = $("#year"); if (y) y.textContent = new Date().getFullYear();

  /* ---------- Booking links ---------- */
  if (S.bookingUrl) {
    $$(".js-book").forEach(function (el) { el.href = S.bookingUrl; el.target = "_blank"; el.rel = "noopener"; });
    $$(".js-book-direct").forEach(function (el) { el.hidden = false; });
  }

  /* ---------- Nav ---------- */
  var nav = $(".nav"), toggle = $("#navToggle"), links = $("#navLinks");
  window.addEventListener("scroll", function () { nav.classList.toggle("is-scrolled", window.scrollY > 8); }, { passive: true });
  toggle.addEventListener("click", function () {
    var open = links.classList.toggle("is-open");
    toggle.setAttribute("aria-expanded", open);
  });
  $$("a", links).forEach(function (a) { a.addEventListener("click", function () { links.classList.remove("is-open"); toggle.setAttribute("aria-expanded", "false"); }); });

  /* ---------- Hero flow animation ---------- */
  var rows = $$(".flow__row"), stat = $(".hero__stat-num");
  var reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  function runFlow() {
    rows.forEach(function (r) { r.classList.remove("is-on"); });
    rows.forEach(function (r, i) { setTimeout(function () { r.classList.add("is-on"); }, reduce ? 0 : 500 + i * 700); });
  }
  if (rows.length) { runFlow(); if (!reduce) setInterval(runFlow, 7000); }
  if (stat) stat.textContent = "0";

  /* ---------- Time-back calculator ---------- */
  var h = $("#hours"), r = $("#rate"), sh = $("#share");
  var fmt = function (n) { return Math.round(n).toLocaleString("en-AU"); };
  function calc() {
    var hours = +h.value, rate = +r.value, share = +sh.value / 100;
    var yearHours = hours * share * 48;              // 48 working weeks
    var yearDollars = yearHours * rate;
    $("#hoursOut").textContent = hours;
    $("#rateOut").textContent = "$" + rate;
    $("#shareOut").textContent = sh.value + "%";
    $("#resHours").textContent = fmt(yearHours);
    $("#resDollars").textContent = "$" + fmt(yearDollars);
    var est = $("#calcEstimate");
    if (est) est.value = hours + " hrs/wk admin @ $" + rate + "/hr, " + sh.value + "% automatable = ~" + fmt(yearHours) + " hrs / $" + fmt(yearDollars) + " a year";
  }
  if (h) { [h, r, sh].forEach(function (el) { el.addEventListener("input", calc); }); calc(); }

  /* ---------- Reveal on scroll ---------- */
  var revealEls = $$(".section .h2, .problem, .step, .customer, .nots li, .person, .calc__result, .form");
  if ("IntersectionObserver" in window && !reduce) {
    revealEls.forEach(function (el) { el.classList.add("reveal"); });
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add("is-in"); io.unobserve(e.target); } });
    }, { rootMargin: "0px 0px -60px 0px" });
    revealEls.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Enquiry form ---------- */
  var form = $("#enquiryForm"), status = $("#formStatus");
  if (form) form.addEventListener("submit", function (e) {
    e.preventDefault();
    status.className = "form__status";
    if (!form.checkValidity()) {
      status.textContent = "Please add your name, a valid email and tick the consent box.";
      status.classList.add("is-err");
      form.reportValidity();
      return;
    }
    var btn = form.querySelector("button[type=submit]");
    btn.disabled = true; status.textContent = "Sending…";
    fetch(form.getAttribute("action"), { method: "POST", body: new FormData(form), headers: { "Accept": "application/json" } })
      .then(function (res) { return res.json().then(function (j) { return { ok: res.ok && j.ok, j: j }; }); })
      .then(function (out) {
        if (!out.ok) throw new Error(out.j && out.j.error);
        form.reset(); calc && h && calc();
        status.textContent = "Thanks! We'll be in touch within one business day.";
        status.classList.add("is-ok");
        if (window.gtag) gtag("event", "generate_lead");
        if (window.fbq) fbq("track", "Lead");
      })
      .catch(function (err) {
        status.innerHTML = (err && err.message ? err.message + " " : "Something went wrong. ") +
          "You can also email us at <a href=\"mailto:" + (S.email || "") + "\">" + (S.email || "") + "</a>.";
        status.classList.add("is-err");
      })
      .then(function () { btn.disabled = false; });
  });

  /* ---------- Optional analytics ---------- */
  function loadScript(src) { var s = document.createElement("script"); s.async = true; s.src = src; document.head.appendChild(s); }
  if (S.ga4Id) {
    loadScript("https://www.googletagmanager.com/gtag/js?id=" + S.ga4Id);
    window.dataLayer = window.dataLayer || [];
    window.gtag = function () { dataLayer.push(arguments); };
    gtag("js", new Date()); gtag("config", S.ga4Id);
  }
  if (S.metaPixelId) {
    !function (f, b, e, v, n, t, s) { if (f.fbq) return; n = f.fbq = function () { n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments); };
      if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = "2.0"; n.queue = []; t = b.createElement(e); t.async = !0; t.src = v;
      s = b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t, s); }(window, document, "script", "https://connect.facebook.net/en_US/fbevents.js");
    fbq("init", S.metaPixelId); fbq("track", "PageView");
  }
})();

/* ---------- Click-to-load embeds (Our work page) ---------- */
(function () {
  var embeds = Array.prototype.slice.call(document.querySelectorAll(".embed[data-embed]"));
  if (!embeds.length) return;
  function load(box) {
    if (box.classList.contains("is-loaded")) return;
    var f = document.createElement("iframe");
    f.src = box.getAttribute("data-embed");
    f.title = box.getAttribute("data-embed-title") || "Embedded site";
    f.loading = "lazy";
    f.setAttribute("allow", "fullscreen; xr-spatial-tracking");
    f.setAttribute("referrerpolicy", "strict-origin-when-cross-origin");
    box.appendChild(f);
    box.classList.add("is-loaded");
  }
  embeds.forEach(function (box) {
    var btn = box.querySelector(".embed__load");
    if (btn) btn.addEventListener("click", function () { load(box); });
  });
  /* The featured app embed loads itself on large screens once it scrolls into view. */
  var wide = window.matchMedia("(min-width: 961px)").matches;
  var saveData = navigator.connection && navigator.connection.saveData;
  if (wide && !saveData && "IntersectionObserver" in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { load(e.target); io.unobserve(e.target); } });
    }, { rootMargin: "200px 0px" });
    embeds.filter(function (b) { return b.getAttribute("data-embed-auto") === "1"; }).forEach(function (b) { io.observe(b); });
  }
})();

/* ---------- Hide any hotlinked picture that fails to load ---------- */
(function () {
  Array.prototype.slice.call(document.querySelectorAll(".gallery__item img, .media img, .customer__img, .hero__strip img")).forEach(function (img) {
    function miss() { var f = img.closest(".gallery__item, .media") || img; f.classList.add("is-missing"); if (f === img) img.style.display = "none"; }
    if (img.complete && img.naturalWidth === 0 && img.src) miss();
    img.addEventListener("error", miss);
  });
})();
