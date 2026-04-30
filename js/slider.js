document.addEventListener("DOMContentLoaded", function () {
  const sliderEl = document.getElementById("sehirSlider");
  if (!sliderEl) return;

  const carousel = bootstrap.Carousel.getOrCreateInstance(sliderEl, {
    interval: 3500,
    wrap: true,
    touch: true,
  });

  // Thumbnail tıklama
  window.goToSlide = function (index) {
    carousel.to(index);
    updateThumbs(index);
  };

  function updateThumbs(index) {
    document.querySelectorAll(".slider-thumb").forEach(function (t, i) {
      t.classList.toggle("active", i === index);
    });
  }

  sliderEl.addEventListener("slid.bs.carousel", function (e) {
    updateThumbs(e.to);
  });

  // Klavye navigasyonu
  document.addEventListener("keydown", function (e) {
    if (e.key === "ArrowLeft") carousel.prev();
    else if (e.key === "ArrowRight") carousel.next();
  });

  console.log("✅ slider.js yüklendi.");
});
