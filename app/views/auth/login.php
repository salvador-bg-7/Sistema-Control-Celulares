<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DrDigital — Iniciar Sesión</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/drdigital.css">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #2263bf 10%, #2a86d9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #circuitCanvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }



        /* ── Card ── */
        .login-card {
            width: 420px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 1;
        }

        /* ── Header ── */
        .login-header {
            background: linear-gradient(135deg, #2a86d9 10%, #2263bf 100%);
            padding: 2.2rem 2.5rem;
            text-align: center;
            cursor: pointer;
            position: relative;
            border-radius: 24px;
            transition:
                border-radius 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                box-shadow 0.4s ease;
            user-select: none;
        }

        .login-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
            pointer-events: none;
            border-radius: inherit;
        }

        .login-header:hover {
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(42, 134, 217, 0.4);
        }

        .login-card.open .login-header {
            border-radius: 24px 24px 0 0;
        }

        /* Shimmer sutil */
        .shimmer {
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.07), transparent);
            animation: shimmer 3s ease-in-out infinite;
            pointer-events: none;
            border-radius: inherit;
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 200%;
            }
        }

        .login-header img {
            width: 320px;
            filter: brightness(0) invert(1);
            display: block;
            margin: 0 auto 0.5rem;
            transition: transform 0.4s ease;
        }

        .login-header:hover img {
            transform: scale(1.07);
        }

        /* Hint de clic */
        .hint {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 0.8rem;
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .hint-arrow {
            width: 18px;
            height: 18px;
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 1.6s ease-in-out infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .login-card.open .hint {
            opacity: 0;
            transform: translateY(-5px);
            pointer-events: none;
        }

        /* ── Body ── */
        .login-body {
            background: #ffffff;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-12px);
            transition:
                max-height 0.65s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.45s ease 0.15s,
                transform 0.5s cubic-bezier(0.4, 0, 0.2, 1) 0.1s;
        }

        .login-card.open .login-body {
            max-height: 520px;
            opacity: 1;
            transform: translateY(0);
        }

        .login-body-inner {
            padding: 2.2rem 2.5rem 2rem;
        }

        .login-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2a86d9;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* ── Inputs ── */
        .field-group {
            margin-bottom: 1.2rem;
        }

        .field-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #2a86d9;
            margin-bottom: 0.4rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            border: 2px solid #c9dafa;
            border-radius: 12px;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: #f3f6fa;
        }

        .input-wrap:focus-within {
            border-color: #2263bf;
            box-shadow: 0 0 0 3px rgba(42, 134, 217, 0.15);
            background: #fff;
        }

        .input-icon {
            padding: 0 0.75rem;
            color: #2a86d9;
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        .input-wrap input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 0.72rem 0.5rem;
            font-family: 'Outfit', sans-serif;
            font-size: 0.9rem;
            color: #2263bf;
            outline: none;
        }

        .input-wrap input::placeholder {
            color: #aac3e8;
        }

        .eye-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0 0.75rem;
            color: #aac3e8;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }

        .eye-btn:hover {
            color: #2a86d9;
        }

        /* Alerts */
        .alert-danger {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-warning {
            background: #fef9c3;
            color: #92400e;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 0.6rem 0.9rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Botón ── */
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #2263bf 0%, #2a86d9 100%);
            border: none;
            border-radius: 13px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .btn-login:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 4px 5px rgba(4, 12, 24, 0.45);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .btn-login .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple-anim 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-anim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .footer-text {
            text-align: center;
            font-size: 0.72rem;
            color: #7eb4e8;
            margin-top: 1.4rem;
        }
    </style>
</head>

<body>

    <!-- Partículas de fondo -->
    <canvas id="circuitCanvas"></canvas>

    <div class="login-card" id="loginCard">

        <!-- HEADER — clic para desplegar -->
        <div class="login-header" id="loginHeader">
            <div class="shimmer"></div>
            <img src="<?= BASE_URL ?>assets/images/logo.png" alt="DrDigital">
        </div>

        <!-- BODY — oculto por defecto, se despliega al clic -->
        <div class="login-body" id="loginBody">
            <div class="login-body-inner">
                <h4 class="login-title">Iniciar Sesión</h4>

                <?php if (isset($error)): ?>
                    <div class="alert-danger">
                        <i class="bi bi-exclamation-circle"></i>
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['expired'])): ?>
                    <div class="alert-warning">
                        <i class="bi bi-clock"></i>
                        Tu sesión expiró. Inicia sesión nuevamente.
                    </div>
                <?php endif; ?>

                <form action="<?= BASE_URL ?>auth/autenticar" method="POST">

                    <div class="field-group">
                        <label class="field-label">Usuario</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </span>
                            <input type="text" name="usuario"
                                placeholder="Ingresa tu usuario"
                                value="chava13"
                                autocomplete="username" required>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Contraseña</label>
                        <div class="input-wrap">
                            <span class="input-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input type="password" id="passInput" name="password"
                                value="123698745"
                                placeholder="Ingresa tu contraseña"
                                autocomplete="current-password" required>
                            <button class="eye-btn" type="button" id="togglePass">
                                <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-login" id="loginBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            style="margin-right:8px;vertical-align:-2px;">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Entrar
                    </button>

                </form>

                <p class="footer-text">
                    DrDigital &copy; <?= date('Y') ?> — Todos los derechos reservados
                </p>
            </div>
        </div>

    </div><!-- /login-card -->


    <script src="<?= BASE_URL ?>assets/assets/compiled/js/app.js"></script>
    <script>
        // ── Toggle del card ──
        const card = document.getElementById('loginCard');
        const header = document.getElementById('loginHeader');
        let isOpen = false;
        header.addEventListener('click', () => {
            isOpen = !isOpen;
            card.classList.toggle('open', isOpen);
        });

        // ── Toggle mostrar/ocultar contraseña ──
        document.getElementById('togglePass').addEventListener('click', function() {
            const input = document.getElementById('passInput');
            const icon = document.getElementById('eyeIcon');
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            icon.innerHTML = isPass ?
                `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8
                       a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4
                       c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19
                       m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
               <line x1="1" y1="1" x2="23" y2="23"/>` :
                `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
               <circle cx="12" cy="12" r="3"/>`;
        });

        // ── Ripple en botón ──
        document.getElementById('loginBtn').addEventListener('click', function(e) {
            const btn = this;
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            const rect = btn.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.cssText = `
            width:${size}px;height:${size}px;
            left:${e.clientX-rect.left-size/2}px;
            top:${e.clientY-rect.top-size/2}px;`;
            btn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 700);
        });

        // ── Auto-open si hay error ──
        <?php if (isset($error) || isset($_GET['expired'])): ?>
            card.classList.add('open');
            isOpen = true;
        <?php endif; ?>

            // ── Animación de circuito eléctrico ──
            (function() {
                const canvas = document.getElementById('circuitCanvas');
                const ctx = canvas.getContext('2d');

                const CELL = 45;
                const WIRE_COUNT = 50;
                const SPARK_COUNT = 15;

                let wires = [],
                    sparks = [],
                    raf;

                /* Construye un cable de trazos H/V sobre la rejilla */
                function buildWire() {
                    const W = canvas.width,
                        H = canvas.height;
                    const maxX = Math.floor(W / CELL);
                    const maxY = Math.floor(H / CELL);
                    let cx = Math.floor(Math.random() * maxX);
                    let cy = Math.floor(Math.random() * maxY);
                    const pts = [{
                        x: cx * CELL,
                        y: cy * CELL
                    }];
                    const turns = 3 + Math.floor(Math.random() * 6);
                    let horiz = Math.random() < 0.5;

                    for (let i = 0; i < turns; i++) {
                        const steps = 2 + Math.floor(Math.random() * 4);
                        if (horiz) cx = Math.max(0, Math.min(maxX, cx + (Math.random() < 0.5 ? steps : -steps)));
                        else cy = Math.max(0, Math.min(maxY, cy + (Math.random() < 0.5 ? steps : -steps)));
                        horiz = !horiz;
                        pts.push({
                            x: cx * CELL,
                            y: cy * CELL
                        });
                    }

                    const cum = [0];
                    for (let i = 1; i < pts.length; i++) {
                        const dx = pts[i].x - pts[i - 1].x,
                            dy = pts[i].y - pts[i - 1].y;
                        cum.push(cum[i - 1] + Math.hypot(dx, dy));
                    }
                    return {
                        pts,
                        cum,
                        total: cum[cum.length - 1]
                    };
                }

                /* Traza el segmento [d0, d1] de un wire */
                function drawRange(wire, d0, d1) {
                    d0 = Math.max(0, d0);
                    d1 = Math.min(wire.total, d1);
                    if (d0 >= d1) return;
                    let started = false,
                        prevX = 0,
                        prevY = 0;
                    for (let i = 1; i < wire.pts.length; i++) {
                        const sS = wire.cum[i - 1],
                            sE = wire.cum[i];
                        if (sE <= d0 || sS >= d1) continue;
                        const t0 = (Math.max(d0, sS) - sS) / (sE - sS);
                        const t1 = (Math.min(d1, sE) - sS) / (sE - sS);
                        const p = wire.pts;
                        const x1 = p[i - 1].x + t0 * (p[i].x - p[i - 1].x);
                        const y1 = p[i - 1].y + t0 * (p[i].y - p[i - 1].y);
                        const x2 = p[i - 1].x + t1 * (p[i].x - p[i - 1].x);
                        const y2 = p[i - 1].y + t1 * (p[i].y - p[i - 1].y);
                        if (!started) {
                            ctx.moveTo(x1, y1);
                            started = true;
                        } else if (Math.hypot(x1 - prevX, y1 - prevY) > 0.5) ctx.moveTo(x1, y1);
                        ctx.lineTo(x2, y2);
                        prevX = x2;
                        prevY = y2;
                    }
                }

                /* Posición {x,y} a distancia d sobre el wire */
                function posAt(wire, d) {
                    d = Math.max(0, Math.min(wire.total, d));
                    for (let i = 1; i < wire.cum.length; i++) {
                        if (d <= wire.cum[i]) {
                            const t = (d - wire.cum[i - 1]) / ((wire.cum[i] - wire.cum[i - 1]) || 1);
                            return {
                                x: wire.pts[i - 1].x + t * (wire.pts[i].x - wire.pts[i - 1].x),
                                y: wire.pts[i - 1].y + t * (wire.pts[i].y - wire.pts[i - 1].y)
                            };
                        }
                    }
                    return {
                        ...wire.pts[wire.pts.length - 1]
                    };
                }

                /* Paleta de azules claros */
                const PALETTE = [
                    [125, 211, 252],
                    [56, 189, 248],
                    [147, 197, 253],
                    [103, 232, 249],
                    [186, 230, 253]
                ];

                function spawnSpark() {
                    if (!wires.length) return;
                    const wire = wires[Math.floor(Math.random() * wires.length)];
                    const [r, g, b] = PALETTE[Math.floor(Math.random() * PALETTE.length)];
                    sparks.push({
                        wire,
                        d: 0,
                        speed: 90 + Math.random() * 120,
                        trail: 70 + Math.random() * 110,
                        r,
                        g,
                        b
                    });
                }

                function build() {
                    wires = [];
                    for (let i = 0; i < WIRE_COUNT; i++) {
                        const w = buildWire();
                        if (w.total > CELL * 2) wires.push(w);
                    }
                    sparks = [];
                    for (let i = 0; i < SPARK_COUNT; i++) spawnSpark();
                }

                function resize() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                    build();
                }

                let last = 0;

                function frame(ts) {
                    const dt = Math.min((ts - last) / 1000, 0.05);
                    last = ts;
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.lineCap = 'round';
                    ctx.lineJoin = 'round';

                    for (let i = sparks.length - 1; i >= 0; i--) {
                        const s = sparks[i];
                        s.d += s.speed * dt;
                        const ts0 = Math.max(0, s.d - s.trail);
                        const {
                            r,
                            g,
                            b
                        } = s;

                        /* Capa 1: aureola ancha */
                        ctx.beginPath();
                        drawRange(s.wire, ts0, s.d);
                        ctx.strokeStyle = `rgba(${r},${g},${b},0.10)`;
                        ctx.lineWidth = 10;
                        ctx.stroke();

                        /* Capa 2: brillo medio (últimos 65 % del rastro) */
                        ctx.beginPath();
                        drawRange(s.wire, ts0 + s.trail * 0.35, s.d);
                        ctx.strokeStyle = `rgba(${r},${g},${b},0.38)`;
                        ctx.lineWidth = 2.5;
                        ctx.stroke();

                        /* Capa 3: núcleo brillante (últimos 30 %) */
                        ctx.beginPath();
                        drawRange(s.wire, ts0 + s.trail * 0.70, s.d);
                        ctx.strokeStyle = `rgba(${r},${g},${b},0.85)`;
                        ctx.lineWidth = 1.5;
                        ctx.stroke();

                        /* Cabeza: punto luminoso */
                        const head = posAt(s.wire, s.d);

                        ctx.shadowBlur = 20;
                        ctx.shadowColor = `rgb(${r},${g},${b})`;
                        ctx.fillStyle = `rgb(${r},${g},${b})`;
                        ctx.beginPath();
                        ctx.arc(head.x, head.y, 3.2, 0, Math.PI * 2);
                        ctx.fill();

                        ctx.shadowBlur = 28;
                        ctx.shadowColor = '#ffffff';
                        ctx.fillStyle = '#ffffff';
                        ctx.beginPath();
                        ctx.arc(head.x, head.y, 1.8, 0, Math.PI * 2);
                        ctx.fill();
                        ctx.shadowBlur = 0;

                        /* Nodo en cada vértice cercano al frente */
                        for (let v = 1; v < s.wire.pts.length - 1; v++) {
                            const dist = Math.abs(s.wire.cum[v] - s.d);
                            if (dist < 6) {
                                const glow = 1 - dist / 6;
                                ctx.shadowBlur = 12 * glow;
                                ctx.shadowColor = `rgba(${r},${g},${b},${glow})`;
                                ctx.fillStyle = `rgba(${r},${g},${b},${glow * 0.8})`;
                                ctx.beginPath();
                                ctx.arc(s.wire.pts[v].x, s.wire.pts[v].y, 3.5, 0, Math.PI * 2);
                                ctx.fill();
                                ctx.shadowBlur = 0;
                            }
                        }

                        if (s.d >= s.wire.total) {
                            sparks.splice(i, 1);
                            spawnSpark();
                        }
                    }

                    raf = requestAnimationFrame(frame);
                }

                window.addEventListener('resize', () => {
                    cancelAnimationFrame(raf);
                    resize();
                    last = performance.now();
                    requestAnimationFrame(frame);
                });

                resize();
                last = performance.now();
                requestAnimationFrame(frame);
            })();
    </script>




</body>

</html>