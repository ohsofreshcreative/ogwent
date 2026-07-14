import liquidGL from 'liquid-gl';

export default function initLiquidGlass() {
  const targets = document.querySelectorAll('.liquid-glass');

  if (!targets.length) {
    return;
  }

  // Szukamy sekcji hero jako tła do rozmycia. Jeśli jej nie ma, bierzemy ciało dokumentu.
  const hasHero = document.querySelector('.b-hero');
  const snapshotTarget = hasHero ? '.b-hero' : 'body';

  const glassEffect = liquidGL({
    target: '.liquid-glass',
    snapshot: snapshotTarget,

    resolution: 1.5, // 1.5 jest lżejsze dla procesora niż domyślne 2.0 i eliminuje crashe
    refraction: 0.02,

    bevelDepth: 0.08,
    bevelWidth: 0.18,

    frost: 1,

    shadow: true,
    specular: true,

    reveal: 'fade',

    tilt: true,
    tiltFactor: 5,

    magnify: 1,

    on: {
      init(instance) {
        console.log('Liquid Glass uruchomiony pomyślnie!', instance);
      },
    },
  });

  // Inteligentny fallback: Jeżeli w ciągu 1.5s WebGL się nie zainicjalizuje i element nadal
  // ma opacity = 0 (np. z powodu blokady CORS obrazka na localhost), przywracamy styl CSS
  setTimeout(() => {
    targets.forEach((el) => {
      const computedStyle = window.getComputedStyle(el);
      if (computedStyle.opacity === '0' || el.style.opacity === '0') {
        console.warn('Liquid Glass fallback: Wykryto błąd ładowania WebGL, przywracanie stylu CSS.');
        el.style.opacity = '1';
        el.style.pointerEvents = 'auto';
        el.style.background = 'rgb(255 255 255 / 12%)';
        el.style.backdropFilter = 'blur(18px) saturate(140%)';
        el.style.webkitBackdropFilter = 'blur(18px) saturate(140%)';
      }
    });
  }, 1500);

  return glassEffect;
}