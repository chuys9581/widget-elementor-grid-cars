document.addEventListener('DOMContentLoaded', function() {
    const iframes = document.querySelectorAll('.car-360-iframe');
    
    function hideControls(iframe) {
        try {
            // Intentar acceder al documento del iframe
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            
            // Crear y añadir CSS para ocultar controles
            const style = document.createElement('style');
            style.textContent = `
                [class*="zoom"],
                [class*="fullscreen"],
                [class*="control"],
                [class*="button"],
                [class*="controls"],
                img[alt*="zoom"],
                img[src*="zoom"],
                div:has(> img[alt*="zoom"]),
                div:has(> img[src*="zoom"]),
                div[class*="button"],
                div[class*="controls"],
                div[class*="zoom"],
                div[class*="fullscreen"],
                .autorotate-text,
                *[class*="360-view-container"] > *:not(img) {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                    pointer-events: none !important;
                }
            `;
            iframeDoc.head.appendChild(style);
            
            // Iniciar rotación automática
            const rotationScript = document.createElement('script');
            rotationScript.textContent = `
                (function() {
                    let rotation = 0;
                    function autoRotate() {
                        rotation = (rotation + 1) % 360;
                        // Intentar diferentes métodos para rotar
                        if (typeof window.set360Rotation === 'function') {
                            window.set360Rotation(rotation);
                        }
                        if (typeof window.rotate360 === 'function') {
                            window.rotate360(rotation);
                        }
                        if (typeof window.setRotation === 'function') {
                            window.setRotation(rotation);
                        }
                        requestAnimationFrame(autoRotate);
                    }
                    autoRotate();
                })();
            `;
            iframeDoc.body.appendChild(rotationScript);
        } catch (error) {
            console.error('Error al configurar el visor 360:', error);
        }
    }

    iframes.forEach(iframe => {
        // Intentar ocultar controles cuando el iframe se carga
        iframe.addEventListener('load', () => hideControls(iframe));
        
        // También intentar periódicamente por si el contenido se carga dinámicamente
        let attempts = 0;
        const maxAttempts = 10;
        const checkInterval = setInterval(() => {
            if (attempts >= maxAttempts) {
                clearInterval(checkInterval);
                return;
            }
            hideControls(iframe);
            attempts++;
        }, 1000);
    });
});