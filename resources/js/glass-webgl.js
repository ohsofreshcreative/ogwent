document.querySelectorAll('canvas.glass').forEach(initGlass);

function initGlass(canvas) {
  let source = canvas._bgSource || null;

  if (!source) {
    source = document.querySelector('video.bg')
          || document.querySelector('img.bg');
  }

  if (!source && canvas.dataset.bg) {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.src = canvas.dataset.bg;
    img.onload = () => { canvas._bgSource = img; setupGL(canvas, img); };
    return;
  }

  if (source instanceof HTMLVideoElement) {
    const ready = () => setupGL(canvas, source);
    source.readyState >= 2 ? ready() : source.addEventListener('canplay', ready, { once: true });
    return;
  }

  // POPRAWA: Czekamy, aż obrazek tła zostanie w 100% załadowany przez przeglądarkę
  if (source instanceof HTMLImageElement) {
    const ready = () => setupGL(canvas, source);
    if (source.complete && source.naturalWidth !== 0) {
      ready();
    } else {
      source.addEventListener('load', ready, { once: true });
    }
    return;
  }

  setupGL(canvas, source || null);
}

function setupGL(canvas, source) {
  const gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: false });
  if (!gl) return;

  gl.enable(gl.BLEND);
  gl.blendFunc(gl.SRC_ALPHA, gl.ONE_MINUS_SRC_ALPHA);

  const vertex = `
    attribute vec2 position;
    varying vec2 vUv;
    void main() {
      vUv = position * 0.5 + 0.5;
      gl_Position = vec4(position, 0.0, 1.0);
    }
  `;

  const fragmentWithTexture = `
    precision mediump float;
    uniform sampler2D uTexture;
    uniform vec2 uResolution;
    uniform vec2 uCanvasPos;
    uniform vec2 uViewport;
    varying vec2 vUv;
    void main() {
      vec2 uv = vUv;
      vec2 center = uv - 0.5;
      float lens = dot(center, center);
      
      // Zniekształcenie optyczne szkła 3D
      vec2 distortion = center * (0.08 - lens * 0.12);
      vec2 screenUv = (uCanvasPos + uv * uResolution) / uViewport;
      screenUv.y = 1.0 - screenUv.y;
      
      vec4 bg = texture2D(uTexture, screenUv + distortion);
      
      // 1. Filtrujemy surowy obrazek granatowym kolorem głównym projektu (#01003D, 56% krycia) 
      // tak samo, jak robi to warstwa tła w sekcji Hero!
      vec3 primaryTint = vec3(0.004, 0.0, 0.239);
      vec3 tintedBg = mix(bg.rgb, primaryTint, 0.56);
      
      // 2. Nakładamy mroźną, chłodno-niebieską poświatę (Frosted Glass iOS look)
      vec3 color = mix(tintedBg, vec3(0.95, 0.97, 1.0), 0.16);
      
      // Chłodny boczny refleks światła nadający trójwymiarowości (Highlight)
      float highlight = smoothstep(0.85, 0.0, length(uv - vec2(0.20, 0.15))) * 0.22;
      
      // Ultra-precyzyjna, jasna i luksusowa krawędź boczna (Apple Edge Border)
      float edgeX = smoothstep(0.0, 0.015, uv.x) * smoothstep(1.0, 0.985, uv.x);
      float edgeY = smoothstep(0.0, 0.015, uv.y) * smoothstep(1.0, 0.985, uv.y);
      float border = (1.0 - edgeX * edgeY) * 0.28;
      
      color += highlight + border;
      gl_FragColor = vec4(color, 0.95);
    }
  `;

  const fragmentSurface = `
    precision mediump float;
    varying vec2 vUv;
    void main() {
      vec2 uv = vUv;
      float highlight = smoothstep(0.85, 0.0, length(uv - vec2(0.22, 0.18))) * 0.55;
      float edgeX = smoothstep(0.0, 0.03, uv.x) * smoothstep(1.0, 0.97, uv.x);
      float edgeY = smoothstep(0.0, 0.03, uv.y) * smoothstep(1.0, 0.97, uv.y);
      float border = (1.0 - edgeX * edgeY) * 0.40;
      float alpha = clamp(highlight + border, 0.0, 1.0);
      gl_FragColor = vec4(1.0, 1.0, 1.0, alpha);
    }
  `;

  const fragment = source ? fragmentWithTexture : fragmentSurface;
  const program = createProgram(gl, vertex, fragment);
  gl.useProgram(program);

  const buffer = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
  gl.bufferData(
    gl.ARRAY_BUFFER,
    new Float32Array([-1,-1, 1,-1, -1,1, -1,1, 1,-1, 1,1]),
    gl.STATIC_DRAW
  );

  const posLoc = gl.getAttribLocation(program, 'position');
  gl.enableVertexAttribArray(posLoc);
  gl.vertexAttribPointer(posLoc, 2, gl.FLOAT, false, 0, 0);

  const isVideo = source instanceof HTMLVideoElement;

  let texture = null;
  if (source) {
    texture = gl.createTexture();
    gl.bindTexture(gl.TEXTURE_2D, texture);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, source);
  }

  const uniforms = {
    uTexture:    gl.getUniformLocation(program, 'uTexture'),
    uResolution: gl.getUniformLocation(program, 'uResolution'),
    uCanvasPos:  gl.getUniformLocation(program, 'uCanvasPos'),
    uViewport:   gl.getUniformLocation(program, 'uViewport'),
  };

  function render() {
    const rect = canvas.getBoundingClientRect();

    canvas.width  = rect.width  * devicePixelRatio;
    canvas.height = rect.height * devicePixelRatio;

    gl.viewport(0, 0, canvas.width, canvas.height);
    gl.clearColor(0, 0, 0, 0);
    gl.clear(gl.COLOR_BUFFER_BIT);

    if (source) {
      gl.bindTexture(gl.TEXTURE_2D, texture);
      if (isVideo && source.readyState >= 2) {
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, source);
      }
      gl.uniform1i(uniforms.uTexture, 0);
      gl.uniform2f(uniforms.uResolution, canvas.width, canvas.height);
      gl.uniform2f(uniforms.uCanvasPos,
        rect.left * devicePixelRatio,
        rect.top  * devicePixelRatio
      );
      gl.uniform2f(uniforms.uViewport,
        window.innerWidth  * devicePixelRatio,
        window.innerHeight * devicePixelRatio
      );
    }

    gl.drawArrays(gl.TRIANGLES, 0, 6);
    requestAnimationFrame(render);
  }

  requestAnimationFrame(render);
}

function createProgram(gl, vertexSource, fragmentSource) {
  const program = gl.createProgram();
  gl.attachShader(program, createShader(gl, gl.VERTEX_SHADER,   vertexSource));
  gl.attachShader(program, createShader(gl, gl.FRAGMENT_SHADER, fragmentSource));
  gl.linkProgram(program);
  return program;
}

function createShader(gl, type, source) {
  const shader = gl.createShader(type);
  gl.shaderSource(shader, source);
  gl.compileShader(shader);
  return shader;
}