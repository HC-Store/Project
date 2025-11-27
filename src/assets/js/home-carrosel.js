// =================== BANNER PRINCIPAL (CARROSSEL) ===================
(() => {
  const track = document.querySelector('#bannerCarousel .carousel-track');
  if (!track) return;

  const slides = Array.from(track.children);
  const total = slides.length;

  let index = 0;
  const INTERVAL = Number(track.dataset.interval) || 4000;
  const DURATION = 600;

  function goTo(i) {
    index = (i + total) % total;
    track.style.transform = `translateX(-${index * 100}%)`;
    slides.forEach((s, k) => s.classList.toggle('active', k === index));
  }

  let timer = setInterval(() => goTo(index + 1), INTERVAL);

  track.addEventListener('mouseenter', () => clearInterval(timer));
  track.addEventListener('mouseleave', () => {
    timer = setInterval(() => goTo(index + 1), INTERVAL);
  });

  window.addEventListener('resize', () => {
    requestAnimationFrame(() => goTo(index));
  });

  setTimeout(() => goTo(0), DURATION);
})();


// =================== CARROSSEL DE MARCAS ===================
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector("#marcasCarousel");
  const track = container?.querySelector(".carousel-track nav");
  if (!container || !track) return;

  const imgs = Array.from(track.querySelectorAll("img"));

  Promise.all(
    imgs.map(img =>
      img.complete
        ? Promise.resolve()
        : new Promise(res => { img.onload = img.onerror = res; })
    )
  ).then(() => {
    track.innerHTML += track.innerHTML; // duplica conteúdo para loop infinito

    let x = 0;
    const SPEED = 3;
    let raf;
    const half = () => track.scrollWidth / 2;

    const step = () => {
      x += SPEED;
      if (x >= half()) x = 0;
      track.style.transform = `translateX(${-x}px)`;
      raf = requestAnimationFrame(step);
    };

    container.addEventListener("mouseenter", () => cancelAnimationFrame(raf));
    container.addEventListener("mouseleave", () => requestAnimationFrame(step));

    requestAnimationFrame(step);
  });
});


// =================== CARROSSEL BEST SELLERS ===================
document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector("#bestSellersCarousel .product-list");
  if (!track) return;

  const cards = Array.from(track.children);
  const total = cards.length;
  const visible = 5;      // 5 produtos por "página"
  let index = 0;
  const intervalTime = 5000;

  // Duplica lista pra criar carrossel infinito
  track.innerHTML += track.innerHTML;
  const cardWidth = track.scrollWidth / (total * 2);

  function slide() {
    index += visible;
    track.style.transition = "transform 1s ease-in-out";
    track.style.transform = `translateX(-${index * cardWidth}px)`;

    if (index >= total) {
      setTimeout(() => {
        track.style.transition = "none";
        index = 0;
        track.style.transform = "translateX(0)";
      }, 1000);
    }
  }

  setInterval(slide, intervalTime);
});







