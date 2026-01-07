/**
 * ===============================================
 * VIKINGOS INVERSIONES - Main JavaScript
 * ===============================================
 * 
 * Este archivo contiene toda la funcionalidad JavaScript
 * del sitio web de Vikingos Inversiones.
 * 
 * Funcionalidades:
 * - Navbar sticky con cambio de estilo al scroll
 * - Scroll suave a secciones
 * - Filtros de productos por categoría
 * - Validación de formularios
 * - Animaciones en scroll
 * - Preloader
 */

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    
    // ===============================================
    // INICIALIZACIÓN
    // ===============================================
    initPreloader();
    initNavbar();
    initSmoothScroll();
    initScrollAnimations();
    initProductFilters();
    initFormValidation();
    initMobileMenu();
    
    console.log('Vikingos Inversiones - JavaScript cargado correctamente');
});

// ===============================================
// PRELOADER
// ===============================================
function initPreloader() {
    const preloader = document.querySelector('.preloader');
    
    if (preloader) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                preloader.classList.add('hidden');
            }, 500);
        });
    }
}

// ===============================================
// NAVBAR - Cambio de estilo al hacer scroll
// ===============================================
function initNavbar() {
    const navbar = document.querySelector('.navbar-viking');
    
    if (!navbar) return;
    
    const scrollThreshold = 50;
    
    function handleScroll() {
        if (window.scrollY > scrollThreshold) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
    
    // Ejecutar al cargar la página
    handleScroll();
    
    // Ejecutar al hacer scroll
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // Marcar enlace activo según la sección visible
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.navbar-viking .nav-link');
    
    if (sections.length > 0 && navLinks.length > 0) {
        window.addEventListener('scroll', function() {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.clientHeight;
                
                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href');
                if (href && href.includes('#' + current)) {
                    link.classList.add('active');
                }
            });
        }, { passive: true });
    }
}

// ===============================================
// SCROLL SUAVE
// ===============================================
function initSmoothScroll() {
    // Seleccionar todos los enlaces que apuntan a anclas
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                
                // Cerrar menú mobile si está abierto
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
                
                // Calcular offset del navbar
                const navbar = document.querySelector('.navbar-viking');
                const navbarHeight = navbar ? navbar.offsetHeight : 0;
                
                // Scroll suave
                const targetPosition = targetElement.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// ===============================================
// ANIMACIONES EN SCROLL
// ===============================================
function initScrollAnimations() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    if (animatedElements.length === 0) return;
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver(function(entries, observer) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Opcional: dejar de observar después de animar
                // observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

// ===============================================
// FILTROS DE PRODUCTOS
// ===============================================
function initProductFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card-wrapper');
    
    if (filterButtons.length === 0 || productCards.length === 0) return;
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover clase active de todos los botones
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Agregar clase active al botón clickeado
            this.classList.add('active');
            
            // Obtener la categoría a filtrar
            const filterValue = this.getAttribute('data-filter');
            
            // Filtrar productos
            productCards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filterValue === 'all' || category === filterValue) {
                    card.style.display = 'block';
                    // Añadir animación
                    card.style.animation = 'fadeIn 0.5s ease';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

// ===============================================
// VALIDACIÓN DE FORMULARIOS
// ===============================================
function initFormValidation() {
    const forms = document.querySelectorAll('.form-viking');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            // Limpiar errores previos
            form.querySelectorAll('.is-invalid').forEach(field => {
                field.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.remove();
            });
            
            // Validar cada campo requerido
            requiredFields.forEach(field => {
                const value = field.value.trim();
                let fieldValid = true;
                let errorMessage = '';
                
                // Campo vacío
                if (value === '') {
                    fieldValid = false;
                    errorMessage = 'Este campo es obligatorio';
                }
                
                // Validación de email
                if (field.type === 'email' && value !== '') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(value)) {
                        fieldValid = false;
                        errorMessage = 'Por favor, ingresa un email válido';
                    }
                }
                
                // Validación de teléfono
                if (field.type === 'tel' && value !== '') {
                    const phoneRegex = /^[\d\s\+\-\(\)]{7,20}$/;
                    if (!phoneRegex.test(value)) {
                        fieldValid = false;
                        errorMessage = 'Por favor, ingresa un teléfono válido';
                    }
                }
                
                if (!fieldValid) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // Crear mensaje de error
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = errorMessage;
                    field.parentNode.appendChild(feedback);
                }
            });
            
            // Si el formulario es válido
            if (isValid) {
                // Mostrar mensaje de éxito
                showFormMessage(form, 'success', '¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.');
                
                // Resetear formulario
                form.reset();
                
                // NOTA: Aquí se puede agregar la lógica para enviar los datos al servidor
                // usando fetch() o XMLHttpRequest
                
                /*
                // Ejemplo de envío con fetch:
                const formData = new FormData(form);
                
                fetch('/api/contact', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    showFormMessage(form, 'success', data.message);
                    form.reset();
                })
                .catch(error => {
                    showFormMessage(form, 'error', 'Hubo un error al enviar el mensaje. Por favor, intenta de nuevo.');
                });
                */
            }
        });
        
        // Validación en tiempo real
        form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('blur', function() {
                validateField(this);
            });
            
            field.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    validateField(this);
                }
            });
        });
    });
}

// Función auxiliar para validar un campo individual
function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    
    // Remover error previo
    field.classList.remove('is-invalid');
    const existingFeedback = field.parentNode.querySelector('.invalid-feedback');
    if (existingFeedback) {
        existingFeedback.remove();
    }
    
    if (field.hasAttribute('required') && value === '') {
        isValid = false;
    }
    
    if (field.type === 'email' && value !== '') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        field.classList.add('is-invalid');
    }
    
    return isValid;
}

// Función para mostrar mensajes del formulario
function showFormMessage(form, type, message) {
    // Remover mensajes previos
    const existingAlert = form.parentNode.querySelector('.alert-viking');
    if (existingAlert) {
        existingAlert.remove();
    }
    
    // Crear nuevo mensaje
    const alert = document.createElement('div');
    alert.className = `alert-viking alert-viking-${type}`;
    alert.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Insertar antes del formulario
    form.parentNode.insertBefore(alert, form);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// ===============================================
// MENÚ MOBILE
// ===============================================
function initMobileMenu() {
    // Bootstrap maneja la mayor parte, pero agregamos funcionalidad extra
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (!navbarToggler || !navbarCollapse) return;
    
    // Cerrar menú al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (navbarCollapse.classList.contains('show')) {
            if (!navbarCollapse.contains(e.target) && !navbarToggler.contains(e.target)) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        }
    });
    
    // Cerrar menú al hacer clic en un enlace
    const navLinks = navbarCollapse.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navbarCollapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });
}

// ===============================================
// UTILIDADES
// ===============================================

// Función para debounce (evitar múltiples llamadas)
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Función para throttle (limitar llamadas por tiempo)
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ===============================================
// CARRUSEL DE TESTIMONIOS (Opcional)
// ===============================================
function initTestimonialCarousel() {
    // Si decides usar un carrusel personalizado en lugar del de Bootstrap
    const carousel = document.querySelector('.testimonial-carousel');
    if (!carousel) return;
    
    // Lógica del carrusel aquí si es necesario
}

// ===============================================
// CONTADOR ANIMADO (Opcional)
// ===============================================
function initCounters() {
    const counters = document.querySelectorAll('.counter');
    
    if (counters.length === 0) return;
    
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.5
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000; // ms
                const step = target / (duration / 16);
                let current = 0;
                
                const updateCounter = () => {
                    current += step;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };
                
                updateCounter();
                observer.unobserve(counter);
            }
        });
    }, observerOptions);
    
    counters.forEach(counter => observer.observe(counter));
}

// ===============================================
// LAZY LOADING DE IMÁGENES (Opcional)
// ===============================================
function initLazyLoading() {
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    if (lazyImages.length === 0) return;
    
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback para navegadores antiguos
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
        });
    }
}

// ===============================================
// BACK TO TOP BUTTON (Opcional)
// ===============================================
function initBackToTop() {
    const backToTop = document.querySelector('.back-to-top');
    
    if (!backToTop) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTop.classList.add('visible');
        } else {
            backToTop.classList.remove('visible');
        }
    }, { passive: true });
    
    backToTop.addEventListener('click', function(e) {
        e.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}
