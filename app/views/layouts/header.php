<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DrDigital - Taller de Reparación</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/assets/compiled/css/app.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/assets/extensions/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/drdigital.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



    <?php if (isset($_SESSION['recien_login']) && $_SESSION['recien_login']): ?>
        <style>
            #splash-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, #2263bf 0%, #2a86d9 100%);
                z-index: 99999;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                animation: splashFadeOut 0.6s ease 1.8s forwards;
            }

            @keyframes splashFadeOut {
                0% {
                    opacity: 1;
                    transform: scale(1);
                }

                100% {
                    opacity: 0;
                    transform: scale(1.05);
                    pointer-events: none;
                }
            }

            @keyframes logoEntrada {
                0% {
                    opacity: 0;
                    transform: scale(0.7) translateY(20px);
                }

                60% {
                    transform: scale(1.05) translateY(-5px);
                }

                100% {
                    opacity: 1;
                    transform: scale(1) translateY(0);
                }
            }

            @keyframes barraProgreso {
                0% {
                    width: 0%;
                }

                100% {
                    width: 100%;
                }
            }

            @keyframes puntosPulso {

                0%,
                80%,
                100% {
                    transform: scale(0);
                    opacity: 0.3;
                }

                40% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .splash-logo {
                animation: logoEntrada 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both;
                width: 220px;
                filter: brightness(0) invert(1);
            }

            .splash-barra-contenedor {
                width: 200px;
                height: 4px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                margin-top: 2rem;
                overflow: hidden;
            }

            .splash-barra {
                height: 100%;
                background: #ffffff;
                border-radius: 10px;
                animation: barraProgreso 1.6s ease 0.4s both;
            }

            .splash-puntos {
                display: flex;
                gap: 8px;
                margin-top: 1.2rem;
            }

            .splash-puntos span {
                width: 8px;
                height: 8px;
                background: rgba(255, 255, 255, 0.8);
                border-radius: 50%;
                animation: puntosPulso 1.2s ease-in-out infinite;
            }

            .splash-puntos span:nth-child(1) {
                animation-delay: 0s;
            }

            .splash-puntos span:nth-child(2) {
                animation-delay: 0.2s;
            }

            .splash-puntos span:nth-child(3) {
                animation-delay: 0.4s;
            }

            .splash-texto {
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.85rem;
                margin-top: 0.8rem;
                letter-spacing: 2px;
                text-transform: uppercase;
                animation: logoEntrada 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.5s both;
            }
        </style>

        <div id="splash-screen">
            <img src="<?= BASE_URL ?>assets/images/logo.png" alt="DrDigital" class="splash-logo">
            <div class="splash-barra-contenedor">
                <div class="splash-barra"></div>
            </div>
            <div class="splash-puntos">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <script>
            setTimeout(function() {
                const splash = document.getElementById('splash-screen');
                if (splash) splash.remove();
            }, 2500);
        </script>

        <?php unset($_SESSION['recien_login']); ?>
    <?php endif; ?>


</head>

<body>
    <div id="app">


        <?php if (isset($_GET['acceso']) && $_GET['acceso'] === 'denegado'): ?>
            <script>
                window.addEventListener('load', function() {
                    alert('No tienes permisos para acceder a ese módulo');
                });
            </script>
        <?php endif; ?>