document.addEventListener("DOMContentLoaded", function () {
  // 1. NAVBAR scroll efekti
  const navbar = document.querySelector(".navbar");
  if (navbar) {
    window.addEventListener("scroll", function () {
      if (window.scrollY > 50) {
        navbar.classList.add("shadow");
        navbar.style.padding = "6px 0";
      } else {
        navbar.classList.remove("shadow");
        navbar.style.padding = "12px 0";
      }
    });
  }

  // 2. Scroll animasyonu (fade-in)
  const fadeEls = document.querySelectorAll(".fade-in");
  if (fadeEls.length > 0) {
    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 },
    );
    fadeEls.forEach((el) => observer.observe(el));
  }

  // 3. Progress bar animasyonu
  const progressBars = document.querySelectorAll(".progress-bar");
  if (progressBars.length > 0) {
    const pObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const bar = entry.target;
            const hedef = bar.style.width;
            bar.style.width = "0%";
            setTimeout(function () {
              bar.style.transition = "width 1.5s ease-in-out";
              bar.style.width = hedef;
            }, 100);
            pObserver.unobserve(bar);
          }
        });
      },
      { threshold: 0.5 },
    );
    progressBars.forEach((bar) => pObserver.observe(bar));
  }

  // 4. Aktif nav linkini belirle
  const currentPage = window.location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".nav-link").forEach(function (link) {
    if (link.getAttribute("href") === currentPage) {
      document
        .querySelectorAll(".nav-link")
        .forEach((l) => l.classList.remove("active"));
      link.classList.add("active");
    }
  });

  // 5. Sayfa açılış animasyonu
  document.body.style.opacity = "0";
  document.body.style.transition = "opacity 0.4s ease";
  setTimeout(() => {
    document.body.style.opacity = "1";
  }, 50);

  console.log("✅ main.js yüklendi.");
});
