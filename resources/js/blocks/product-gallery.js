/**
 * Single Product Gallery Slider Module (Vanilla JS + Infinite Loop)
 */

export function initProductGallerySlider() {
  const ol = document.querySelector('.flex-control-nav.flex-control-thumbs');
  
  if (!ol || ol.closest('.gallery-thumbs-wrapper')) return;

  // 1. Tworzymy wrapper
  const wrapper = document.createElement('div');
  wrapper.className = 'gallery-thumbs-wrapper';
  ol.parentNode.insertBefore(wrapper, ol);
  wrapper.appendChild(ol);

  // 2. Tworzymy i wstrzykujemy strzałki nawigacji
  const prevBtn = document.createElement('button');
  prevBtn.type = 'button';
  prevBtn.className = '__gallery-arrow prev';
  prevBtn.setAttribute('aria-label', 'Poprzedni');
  prevBtn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" fill="currentColor"/></svg>';

  const nextBtn = document.createElement('button');
  nextBtn.type = 'button';
  nextBtn.className = '__gallery-arrow next';
  nextBtn.setAttribute('aria-label', 'Następny');
  nextBtn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" fill="currentColor"/></svg>';

  wrapper.appendChild(prevBtn);
  wrapper.appendChild(nextBtn);

  // 3. Logika przewijania z zapętleniem (Loop)
  const scrollThumbs = (direction) => {
    const firstLi = ol.querySelector('li');
    if (!firstLi) return;

    const itemWidth = firstLi.getBoundingClientRect().width + 12; // szerokość miniatury + gap (12px)
    const maxScroll = ol.scrollWidth - ol.clientWidth;
    let targetScroll = ol.scrollLeft;

    if (direction === 'next') {
      if (ol.scrollLeft >= maxScroll - 5) {
        targetScroll = 0;
      } else {
        targetScroll += itemWidth * 2;
      }
    } else if (direction === 'prev') {
      if (ol.scrollLeft <= 5) {
        targetScroll = maxScroll;
      } else {
        targetScroll -= itemWidth * 2;
      }
    }

    ol.scrollTo({
      left: targetScroll,
      behavior: 'smooth'
    });
  };

  // Event listenery
  prevBtn.addEventListener('click', (e) => {
    e.preventDefault();
    scrollThumbs('prev');
  });

  nextBtn.addEventListener('click', (e) => {
    e.preventDefault();
    scrollThumbs('next');
  });
}

// Nasłuchiwanie na przybycie listy miniatur w DOM (odporność na asynchroniczny Flexslider)
const galleryObserver = new MutationObserver((mutations, obs) => {
  const ol = document.querySelector('.flex-control-nav.flex-control-thumbs');
  if (ol) {
    initProductGallerySlider();
    obs.disconnect();
  }
});

if (document.body) {
  galleryObserver.observe(document.body, { childList: true, subtree: true });
}