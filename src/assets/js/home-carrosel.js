//
(() => {
  const track = document.querySelector('#bannerCarousel .carousel-track');
  const slides = Array.from(track.children);
  const total = slides.length;

  let index = 0;
  const INTERVAL = Number(track.dataset.interval) || 4000; // ms
  const DURATION = 600; // deve bater com o CSS

  function goTo(i) {
    index = (i + total) % total; // loop infinito
    track.style.transform = `translateX(-${index * 100}%)`;
    slides.forEach((s, k) => s.classList.toggle('active', k === index));
  }

  // autoplay
  let timer = setInterval(() => goTo(index + 1), INTERVAL);

  // pausa quando o mouse fica por cima
  track.addEventListener('mouseenter', () => clearInterval(timer));
  track.addEventListener('mouseleave', () => {
    timer = setInterval(() => goTo(index + 1), INTERVAL);
  });

  // ajuste em resize
  window.addEventListener('resize', () => {
    requestAnimationFrame(() => goTo(index));
  });

  // iniciar
  setTimeout(() => goTo(0), DURATION);
})();

// Carrossel Marcas 
document.addEventListener("DOMContentLoaded", () => {
 const container = document.querySelector("#marcasCarousel");
 const track = document.querySelector("#marcasCarousel .carousel-track");
 const nav = document.querySelector("#marcasCarousel .carousel-track nav");

 if (!container || !track || !nav) {
 console.error("Carrossel de marcas: seletor não encontrado.");
 return;
 }

 // 1) Espera as imagens carregarem
 const imgs = Array.from(nav.querySelectorAll("img"));
 const waitImgs = Promise.all(
 imgs.map(img =>
 img.complete ? Promise.resolve() :
 new Promise(res => { img.onload = img.onerror = res; })
 )
 );

 waitImgs.then(start);

 function start() {
 // 2) Duplica o conteúdo para efeito infinito
 nav.innerHTML += nav.innerHTML;

 let x = 0;
 const SPEED = 3; // ajuste a velocidade (px/frame)
 let rafId;

 // 3) Largura do conteúdo original = metade do nav (porque duplicamos)
 function getHalfWidth() {
 return nav.scrollWidth / 2;
 }
 let halfWidth = getHalfWidth();

 function step() {
 x += SPEED;
 if (x >= halfWidth) x = 0; // reseta suave sem "pulo"
 nav.style.transform = `translateX(${-x}px)`;
 rafId = requestAnimationFrame(step);
 }

 function pause() { cancelAnimationFrame(rafId); }
 function resume() { rafId = requestAnimationFrame(step); }

 // 4) Pausa/retoma no hover
 container.addEventListener("mouseenter", pause);
 container.addEventListener("mouseleave", resume);

// inicia
 resume();

 // Recalcula em resize (layout responsivo)
 window.addEventListener("resize", () => {
 pause();
 halfWidth = getHalfWidth();
 x = x % halfWidth;
 nav.style.transform = `translateX(${-x}px)`;
 resume();
 }, { passive: true });
 }
});

//Carrossel Best Sellers 
document.addEventListener("DOMContentLoaded", () => {
  const track = document.querySelector("#bestSellersCarousel .product-list");
  const prevBtn = document.querySelector("#bestSellersCarousel .prev");
  const nextBtn = document.querySelector("#bestSellersCarousel .next");
  const favBtns = document.querySelectorAll("#bestSellersCarousel .fav");

  const cardWidth = 260 + 24; // largura do card + gap

  nextBtn.addEventListener("click", () => {
    track.scrollBy({ left: cardWidth, behavior: "smooth" });
  });
  prevBtn.addEventListener("click", () => {
    track.scrollBy({ left: -cardWidth, behavior: "smooth" });
  });

  // Favorito (coração)
  favBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      btn.classList.toggle("active");
    });
  });
}); 

// ultimo carrossel
const track1 = document.querySelector(".carrossel-track1");
const items = document.querySelectorAll(".item");


// duplicar conteúdo para criar efeito infinito
 track1.innerHTML += items;

let index = 0;
const itemWidth = items[0].offsetWidth + 20; // largura + margin
const visibleItems = 5; // quantidade de itens visíveis de uma vez

function updateCarousel() {
  track1.style.transform = `translateX(${-index * itemWidth}px)`;
}
