import liquidGL from 'liquid-gl';

/**
 * Globalny monkeypatch uodparniający silnik html2canvas na Tailwind v4.
 * Podmienia wszystkie niezrozumiałe dla biblioteki formaty oklab/oklch na bezpieczne rgba(0,0,0,0).
 */
(function patchHtml2CanvasColors() {
  if (typeof window === 'undefined' || window.__html2canvasColorPatched__) return;
  window.__html2canvasColorPatched__ = true;

  try {
    const originalGetPropertyValue = CSSStyleDeclaration.prototype.getPropertyValue;
    CSSStyleDeclaration.prototype.getPropertyValue = function (propertyName) {
      const val = originalGetPropertyValue.call(this, propertyName);
      if (typeof val === 'string' && (val.includes('oklab') || val.includes('oklch'))) {
        return val.replace(/okl(ab|ch)\([^)]+\)/g, 'rgba(0,0,0,0)');
      }
      return val;
    };

    const originalGetComputedStyle = window.getComputedStyle;
    window.getComputedStyle = function (el, pseudoElt) {
      const style = originalGetComputedStyle.call(this, el, pseudoElt);
      return new Proxy(style, {
        get(target, prop) {
          if (prop === 'getPropertyValue') {
            return function (propertyName) {
              const val = target.getPropertyValue(propertyName);
              if (typeof val === 'string' && (val.includes('oklab') || val.includes('oklch'))) {
                return val.replace(/okl(ab|ch)\([^)]+\)/g, 'rgba(0,0,0,0)');
              }
              return val;
            };
          }
          const val = Reflect.get(target, prop);
          if (typeof val === 'string' && (val.includes('oklab') || val.includes('oklch'))) {
            return val.replace(/okl(ab|ch)\([^)]+\)/g, 'rgba(0,0,0,0)');
          }
          if (typeof val === 'function') {
            return val.bind(target);
          }
          return val;
        }
      });
    };
  } catch (e) {
    console.warn('Nie udało się zaaplikować patcha oklab/oklch dla html2canvas', e);
  }
})();

export default function initLiquidGlass() {
  const targets = document.querySelectorAll('.liquid-glass');

  if (!targets.length) {
    return;
  }

  // Cel zrzutu tła - sekcja hero dla znakomitej prędkości działania
  const hasHero = document.querySelector('.b-hero');
  const snapshotTarget = hasHero ? '.b-hero' : 'body';

  // Kasujemy flagę inicjalizacyjną przy nowym uruchomieniu
  window.__liquidGLActive__ = false;

  const glassEffect = liquidGL({
    target: '.liquid-glass',
    snapshot: snapshotTarget,

    resolution: 1.5, 
    refraction: 0.12, // Wyraźne załamanie światła jak w grubej soczewce szklanej

    bevelDepth: 0.12, // Głębokie zagięcie szklanych krawędzi
    bevelWidth: 0.22, // Chromowana flara na krawędzi szklanej

    frost: 0.85, // Elegancki poziom zamglenia tła

    shadow: true,
    specular: true, // Lśnienie pod kątem światła

    reveal: 'fade',

    tilt: true,
    tiltFactor: 12, // Nachylenie pod kątem przy ruchach myszki

    magnify: 1.05, // Delikatnie powiększa to co z tyłu, dając niesamowity efekt rzeczywistej lupy

    on: {
      init(instance) {
        console.log('Liquid Glass WebGL uruchomiony pomyślnie!', instance);
        // Oznaczamy WebGL jako udanie załadowany
        window.__liquidGLActive__ = true;
      },
    },
  });

  // Rejestrujemy nasłuchiwanie na ruchy myszką / odświeżanie
  window.addEventListener('liquid-refresh', () => {
    if (Array.isArray(glassEffect)) {
      glassEffect.forEach(inst => {
        if (inst && typeof inst.updateMetrics === 'function') {
          inst.updateMetrics();
        }
      });
    } else if (glassEffect && typeof glassEffect.updateMetrics === 'function') {
      glassEffect.updateMetrics();
    }
    
    const renderer = window.__liquidGLRenderer__;
    if (renderer && typeof renderer.render === 'function') {
      renderer.render();
    }
  });

  // Inteligentny Fallback po 4 sekundach (tylko jeżeli WebGL faktycznie zawiódł)
  setTimeout(() => {
    // Jeżeli WebGL został zainicjalizowany pomyślnie, nie robimy absolutnie nic
    if (window.__liquidGLActive__) {
      return;
    }

    targets.forEach((el) => {
      console.warn('Fallback: Wykryto błąd ładowania WebGL, przywracanie stylu CSS.');
      el.style.opacity = '1';
      el.style.pointerEvents = 'auto';
      el.style.background = 'rgb(255 255 255 / 12%)';
      el.style.backdropFilter = 'blur(18px) saturate(140%)';
      el.style.webkitBackdropFilter = 'blur(18px) saturate(140%)';
    });
  }, 4000);

  return glassEffect;
}