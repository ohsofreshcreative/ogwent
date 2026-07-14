import liquidGL from 'liquid-gl';

/**
 * Globalny monkeypatch uodparniający silnik html2canvas na Tailwind v4.
 * Podmienia wszystkie niezrozumiałe dla biblioteki formaty oklab/oklch na bezpieczne rgba(0,0,0,0).
 */
(function patchHtml2CanvasColors() {
  if (typeof window === 'undefined' || window.__html2canvasColorPatched__) return;
  window.__html2canvasColorPatched__ = true;

  try {
    // 1. Patchujemy pobieranie zmiennych przez getPropertyValue()
    const originalGetPropertyValue = CSSStyleDeclaration.prototype.getPropertyValue;
    CSSStyleDeclaration.prototype.getPropertyValue = function (propertyName) {
      const val = originalGetPropertyValue.call(this, propertyName);
      if (typeof val === 'string' && (val.includes('oklab') || val.includes('oklch'))) {
        return val.replace(/okl(ab|ch)\([^)]+\)/g, 'rgba(0,0,0,0)');
      }
      return val;
    };

    // 2. Patchujemy getComputedStyle() za pomocą Proxy, aby złapać bezpośrednie zapytania .style.color itp.
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

  const glassEffect = liquidGL({
    target: '.liquid-glass',
    snapshot: snapshotTarget,

    resolution: 1.5, 
    refraction: 0.04, // Eleganckie zagięcie tła imitujące grubą soczewkę szklaną

    bevelDepth: 0.09, // Zwiększone fazowanie krawędzi
    bevelWidth: 0.18,

    frost: 1.0, // Elegancki poziom zamglenia

    shadow: true,
    specular: true, // Lśniący odblask pod kątem światła

    reveal: 'fade',

    tilt: true,
    tiltFactor: 6, // Trójwymiarowe nachylenie w pozycjach kursora

    magnify: 1,

    on: {
      init(instance) {
        console.log('Liquid Glass WebGL uruchomiony pomyślnie!', instance);
        
        // Zmiana statusu na zielony "WebGL Active"
        const statusEl = document.getElementById('glass-status');
        if (statusEl) {
          statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> WebGL Active';
          statusEl.className = 'inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300';
        }
      },
    },
  });

  // Rejestrujemy nasłuchiwanie na przesuwanie kafelka
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
    
    // Zmuszamy renderer do natychmiastowego odświeżenia klatki WebGL
    const renderer = window.__liquidGLRenderer__;
    if (renderer && typeof renderer.render === 'function') {
      renderer.render();
    }
  });

  // Inteligentny Fallback w razie jakichkolwiek innych niespodziewanych problemów
  setTimeout(() => {
    targets.forEach((el) => {
      const computedStyle = window.getComputedStyle(el);
      // Jeśli WebGL nie zastąpił opacity, przywracamy styl CSS
      if (computedStyle.opacity === '0' || el.style.opacity === '0') {
        console.warn('Fallback: Przywracanie stylów CSS na wypadek problemów z WebGL.');
        el.style.opacity = '1';
        el.style.pointerEvents = 'auto';
        el.style.background = 'rgb(255 255 255 / 12%)';
        el.style.backdropFilter = 'blur(18px) saturate(140%)';
        el.style.webkitBackdropFilter = 'blur(18px) saturate(140%)';

        const statusEl = document.getElementById('glass-status');
        if (statusEl) {
          statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> CSS Fallback';
          statusEl.className = 'inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-xs font-bold bg-amber-500/20 text-amber-300';
        }
      }
    });
  }, 1500);

  return glassEffect;
}