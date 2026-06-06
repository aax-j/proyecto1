/**
 * Script Principal - Statistical Solutions Club (ESPOCH)
 * Maneja animaciones del canvas, filtros de actividades, lightbox y efectos visuales.
 */

document.addEventListener('DOMContentLoaded', () => {
    // ---------------------------------------------------------
    // 1. CANVAS HERO INTERACTIVO (Efecto de Red de Datos)
    // ---------------------------------------------------------
    const canvas = document.getElementById('heroCanvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        let particles = [];
        const particleCount = 45;
        const connectionDistance = 100;
        
        // Ajustar tamaño del canvas
        const resizeCanvas = () => {
            const rect = canvas.parentElement.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
        };
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        // Clase Partícula
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.8;
                this.vy = (Math.random() - 0.5) * 0.8;
                this.radius = Math.random() * 2.5 + 1;
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                // Rebotar en bordes
                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(6, 182, 212, 0.4)'; // Color cyan traslúcido
                ctx.fill();
            }
        }

        // Inicializar partículas
        for (let i = 0; i < particleCount; i++) {
            particles.push(new Particle());
        }

        // Bucle de animación
        const animate = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Actualizar y dibujar partículas
            particles.forEach(p => {
                p.update();
                p.draw();
            });

            // Dibujar líneas de conexión (Red de datos)
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    const dx = particles[i].x - particles[j].x;
                    const dy = particles[i].y - particles[j].y;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < connectionDistance) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        // Mayor cercanía = línea más opaca
                        const alpha = (1 - dist / connectionDistance) * 0.15;
                        ctx.strokeStyle = `rgba(59, 130, 246, ${alpha})`; 
                        ctx.lineWidth = 0.8;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        };
        animate();
    }

    // ---------------------------------------------------------
    // 2. FILTRADO DINÁMICO DE ACTIVIDADES (Cliente Reactivo)
    // ---------------------------------------------------------
    const yearFilters = document.querySelectorAll('#year-filters .btn-filter');
    const statusFilters = document.querySelectorAll('#status-filters .btn-filter');
    const cards = document.querySelectorAll('.activity-card');
    const anioSections = document.querySelectorAll('.anio-section');

    if (cards.length > 0) {
        let activeYear = 'all';
        let activeStatus = 'all';

        const applyFilters = () => {
            anioSections.forEach(section => {
                const sectionYear = section.getAttribute('data-anio-section');
                let visibleCardsInSection = 0;

                const sectionCards = section.querySelectorAll('.activity-card');
                sectionCards.forEach(card => {
                    const cardYear = card.getAttribute('data-card-anio');
                    const cardStatus = card.getAttribute('data-card-estado');

                    const matchesYear = (activeYear === 'all' || cardYear === activeYear);
                    const matchesStatus = (activeStatus === 'all' || cardStatus === activeStatus);

                    if (matchesYear && matchesStatus) {
                        card.style.display = 'flex';
                        visibleCardsInSection++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Si no hay tarjetas visibles en este año, ocultar la sección completa del año
                if (visibleCardsInSection > 0) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        };

        // Eventos filtros de Año
        yearFilters.forEach(btn => {
            btn.addEventListener('click', () => {
                yearFilters.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeYear = btn.getAttribute('data-value');
                applyFilters();
            });
        });

        // Eventos filtros de Estado
        statusFilters.forEach(btn => {
            btn.addEventListener('click', () => {
                statusFilters.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeStatus = btn.getAttribute('data-value');
                applyFilters();
            });
        });
    }

    // ---------------------------------------------------------
    // 3. EFECTO REVEAL ON SCROLL (Animaciones al Deslizarse)
    // ---------------------------------------------------------
    const revealElements = document.querySelectorAll('.card, .stat-card, .mv-item, .skill-item');
    if (revealElements.length > 0) {
        const revealCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        };

        const revealObserver = new IntersectionObserver(revealCallback, {
            root: null,
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(25px)';
            el.style.transition = 'opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), transform 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            revealObserver.observe(el);
        });
    }
});

// ---------------------------------------------------------
// 4. FUNCIONES GLOBALES DEL LIGHTBOX (GALERÍA ZOOM)
// ---------------------------------------------------------
function openLightbox(src, captionText) {
    const lightbox = document.getElementById('imageLightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCaption = document.getElementById('lightbox-caption');

    if (lightbox && lightboxImg && lightboxCaption) {
        lightboxImg.src = src;
        lightboxCaption.textContent = captionText;
        lightbox.style.display = 'flex';
        // Delay mínimo para permitir la animación CSS
        setTimeout(() => {
            lightbox.classList.add('active');
        }, 10);
        document.body.style.overflow = 'hidden'; // Evitar scroll
    }
}

function closeLightbox() {
    const lightbox = document.getElementById('imageLightbox');
    if (lightbox) {
        lightbox.classList.remove('active');
        setTimeout(() => {
            lightbox.style.display = 'none';
        }, 300);
        document.body.style.overflow = ''; // Devolver scroll
    }
}
