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
  var h = $("#hours"), r = $("#rate"), sh = $("#share"), pp = $("#people");
  var fmt = function (n) { return Math.round(n).toLocaleString("en-AU"); };
  function calc() {
    var hours = +h.value, rate = +r.value, share = +sh.value / 100, people = pp ? +pp.value : 1;
    var yearHours = people * hours * share * 48;     // 48 working weeks
    if (pp) $("#peopleOut").textContent = people;
    var yearDollars = yearHours * rate;
    $("#hoursOut").textContent = hours;
    $("#rateOut").textContent = "$" + rate;
    $("#shareOut").textContent = sh.value + "%";
    $("#resHours").textContent = fmt(yearHours);
    $("#resDollars").textContent = "$" + fmt(yearDollars);
    var estText = (people > 1 ? people + " people x " : "") + hours + " hrs/wk admin @ $" + rate + "/hr, " + sh.value + "% automatable = ~" + fmt(yearHours) + " hrs / $" + fmt(yearDollars) + " a year (estimate)";
    var est = $("#calcEstimate"); if (est) est.value = estText;
    var est2 = $("#calcEstimateReport"); if (est2) est2.value = estText;
  }
  if (h) { [h, r, sh, pp].filter(Boolean).forEach(function (el) { el.addEventListener("input", calc); }); calc(); }

  /* ---------- Reveal on scroll ---------- */
  var revealEls = $$(".section .h2, .problem, .step, .customer, .nots li, .person, .calc__result, .form, .h3x, .fix, .wcase, .founder, .auditb__h2, .calcb__result");
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

  /* ---------- Calculator report capture ---------- */
  var rform = $("#reportForm"), rstatus = $("#reportStatus");
  if (rform) rform.addEventListener("submit", function (e) {
    e.preventDefault();
    rstatus.className = "form__status form__status--dark";
    if (!rform.checkValidity()) { rstatus.textContent = "Add a valid email and tick the box."; rstatus.classList.add("is-err"); rform.reportValidity(); return; }
    var btn = rform.querySelector("button[type=submit]"); btn.disabled = true; rstatus.textContent = "Sending…";
    fetch(rform.getAttribute("action"), { method: "POST", body: new FormData(rform), headers: { "Accept": "application/json" } })
      .then(function (res) { return res.json().then(function (j) { return { ok: res.ok && j.ok, j: j }; }); })
      .then(function (out) {
        if (!out.ok) throw new Error(out.j && out.j.error);
        rform.reset(); calc();
        rstatus.textContent = "Done. Your estimate is on its way to your inbox.";
        rstatus.classList.add("is-ok");
        if (window.gtag) gtag("event", "generate_lead", { method: "calculator" });
        if (window.fbq) fbq("track", "Lead");
      })
      .catch(function (err) { rstatus.textContent = (err && err.message) || "Something went wrong. Try the form below instead."; rstatus.classList.add("is-err"); })
      .then(function () { btn.disabled = false; });
  });

  /* ---------- Home page (v2.2.0): ticker loop and "Email me this estimate" ---------- */
  var ticker = $("#ticker");
  if (ticker) { ticker.innerHTML += ticker.innerHTML; ticker.setAttribute("aria-hidden", "false"); }
  var tog = $("#estimateToggle");
  if (tog && rform) tog.addEventListener("click", function () {
    var open = rform.hidden; rform.hidden = !open; tog.setAttribute("aria-expanded", open);
    if (open) { var em = $("#reportEmail"); if (em) em.focus(); }
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
  Array.prototype.slice.call(document.querySelectorAll(".gallery__item img, .media img, .customer__img, .wcase__img, .hero__strip img")).forEach(function (img) {
    function miss() { var f = img.closest(".gallery__item, .media") || img; f.classList.add("is-missing"); if (f === img) img.style.display = "none"; }
    if (img.complete && img.naturalWidth === 0 && img.src) miss();
    img.addEventListener("error", miss);
  });
})();

/* ---------- Booking widget (/book/) ---------- */
(function () {
  var form = document.getElementById("bookWidget");
  if (!form) return;
  var S = window.SITE || {};
  var all = {}; try { all = JSON.parse(form.getAttribute("data-slots") || "{}"); } catch (e) {}
  var daysEl = document.getElementById("bookDays"), timesEl = document.getElementById("bookTimes");
  var dateIn = document.getElementById("bookDate"), timeIn = document.getElementById("bookTime");
  var summary = document.getElementById("bookSummary"), submit = document.getElementById("bookSubmit"), status = document.getElementById("bookStatus");
  var typeName = function () { var r = form.querySelector("input[name=call_type]:checked"); return r ? r.closest(".bookw__type").querySelector("strong").textContent : ""; };
  var type = function () { var r = form.querySelector("input[name=call_type]:checked"); return r ? r.value : "discovery"; };
  var picked = { date: "", time: "" };
  // Show times in the visitor's own time zone (slots carry the business time zone in their ISO offset)
  var vtz = ""; try { vtz = Intl.DateTimeFormat().resolvedOptions().timeZone || ""; } catch (e) {}
  var tzNote = form.querySelector(".bookw__tz"), sideNote = document.getElementById("bookTzNote");
  function localLabel(s) {
    if (!vtz || !s.iso) return s.label;
    try { return new Date(s.iso).toLocaleTimeString("en-AU", { hour: "numeric", minute: "2-digit", timeZone: vtz }).replace(/\s?(am|pm)/i, " $1"); } catch (e) { return s.label; }
  }
  function tzName() {
    if (!vtz) return "";
    try { var p = new Intl.DateTimeFormat("en-AU", { timeZone: vtz, timeZoneName: "short" }).formatToParts(new Date()); var z = p.filter(function (x) { return x.type === "timeZoneName"; })[0]; return (z ? z.value : "") + " (" + vtz.replace(/_/g, " ") + ")"; } catch (e) { return vtz; }
  }
  if (vtz && tzNote) { tzNote.textContent = "(your time, " + tzName() + ")"; }
  if (vtz && sideNote) { sideNote.textContent = "Times are shown in your time zone, " + tzName() + "."; }

  function renderDays() {
    var slots = all[type()] || {}, keys = Object.keys(slots);
    daysEl.innerHTML = "";
    if (!keys.length) { daysEl.innerHTML = "<p class=\"bookw__hint\">No times open right now. Email us and we'll find one.</p>"; return; }
    keys.forEach(function (k) {
      var b = document.createElement("button"); b.type = "button"; b.className = "bookw__day"; b.setAttribute("role", "option");
      b.innerHTML = "<span>" + slots[k].label.split(" ")[0] + "</span><small>" + slots[k].label.split(" ").slice(1).join(" ") + "</small>";
      b.addEventListener("click", function () { pickDay(k); });
      daysEl.appendChild(b);
    });
    if (picked.date && slots[picked.date]) pickDay(picked.date); else { picked.date = ""; picked.time = ""; timesEl.innerHTML = "<p class=\"bookw__hint\">Choose a day first.</p>"; update(); }
  }
  function pickDay(k) {
    picked.date = k; picked.time = "";
    var keys = Object.keys(all[type()]);
    Array.prototype.forEach.call(daysEl.children, function (b, i) { b.classList.toggle("is-on", keys[i] === k); b.setAttribute("aria-selected", keys[i] === k); });
    var day = all[type()][k];
    timesEl.innerHTML = "";
    day.slots.forEach(function (s) {
      var b = document.createElement("button"); b.type = "button"; b.className = "bookw__time"; b.textContent = localLabel(s); b.setAttribute("role", "option");
      b.addEventListener("click", function () {
        picked.time = s.t;
        Array.prototype.forEach.call(timesEl.children, function (x) { x.classList.toggle("is-on", x === b); x.setAttribute("aria-selected", x === b); });
        update();
        var d = form.querySelector("[data-step='4']"); if (d && window.innerWidth < 960) d.scrollIntoView({ behavior: "smooth", block: "start" });
      });
      timesEl.appendChild(b);
    });
    update();
  }
  function update() {
    dateIn.value = picked.date; timeIn.value = picked.time;
    var ok = picked.date && picked.time;
    submit.disabled = !ok;
    if (ok) {
      var day = all[type()][picked.date], slot = day.slots.filter(function (s) { return s.t === picked.time; })[0];
      summary.hidden = false; summary.textContent = typeName() + ": " + day.full + " at " + (slot ? localLabel(slot) : picked.time) + (vtz ? " (" + tzName() + ")" : "");
    } else { summary.hidden = true; }
  }
  Array.prototype.forEach.call(form.querySelectorAll("input[name=call_type]"), function (r) { r.addEventListener("change", renderDays); });
  renderDays();

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    status.className = "form__status";
    if (!picked.date || !picked.time) { status.textContent = "Pick a day and a time first."; status.classList.add("is-err"); return; }
    if (!form.checkValidity()) { status.textContent = "Please add your name, email, phone and tick the box."; status.classList.add("is-err"); form.reportValidity(); return; }
    submit.disabled = true; status.textContent = "Booking…";
    fetch(form.getAttribute("action"), { method: "POST", body: new FormData(form), headers: { "Accept": "application/json" } })
      .then(function (res) { return res.json().then(function (j) { return { ok: res.ok && j.ok, j: j, code: res.status }; }); })
      .then(function (out) {
        if (!out.ok) {
          if (out.code === 409) { // slot gone: drop it locally and re-render
            var d = all[type()][picked.date]; if (d) d.slots = d.slots.filter(function (s) { return s.t !== picked.time; });
            picked.time = ""; renderDays();
          }
          throw new Error(out.j && out.j.error);
        }
        form.hidden = true;
        var done = document.getElementById("bookDone"); done.hidden = false;
        document.getElementById("bookDoneText").textContent = out.j.type + ", " + out.j.label + ".";
        document.getElementById("bookDoneHow").textContent = out.j.how || "";
        var ics = document.getElementById("bookIcs"); ics.href = "data:text/calendar;charset=utf-8," + encodeURIComponent(out.j.ics || "");
        done.scrollIntoView({ behavior: "smooth", block: "start" });
        if (window.gtag) gtag("event", "generate_lead", { method: "booking" });
        if (window.fbq) fbq("track", "Schedule");
      })
      .catch(function (err) {
        status.innerHTML = (err && err.message ? err.message + " " : "Something went wrong. ") + "You can also email <a href=\"mailto:" + (S.email || "") + "\">" + (S.email || "") + "</a>.";
        status.classList.add("is-err");
      })
      .then(function () { submit.disabled = !(picked.date && picked.time); });
  });
})();
