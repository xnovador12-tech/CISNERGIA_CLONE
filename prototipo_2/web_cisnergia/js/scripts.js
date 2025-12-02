  // Animación de elementos al hacer scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, observerOptions);

  // Observar elementos que deben animarse
  document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    animatedElements.forEach(el => observer.observe(el));

    // Animación de contador para estadísticas (si existen)
    const counters = document.querySelectorAll('.counter-number');
    counters.forEach(counter => {
      const target = parseInt(counter.getAttribute('data-target'));
      const increment = target / 100;
      let current = 0;
      
      const updateCounter = () => {
        if (current < target) {
          current += increment;
          counter.textContent = Math.ceil(current);
          setTimeout(updateCounter, 20);
        } else {
          counter.textContent = target;
        }
      };
      
      // Iniciar animación cuando el elemento sea visible
      const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && current === 0) {
            updateCounter();
            counterObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });
      
      counterObserver.observe(counter.closest('.stats-card') || counter);
    });

    // Animación de brillo solar en iconos
    const solarIcons = document.querySelectorAll('.bi-sun, .bi-sun-fill, .bi-lightning-charge-fill');
    solarIcons.forEach(icon => {
      setInterval(() => {
        icon.style.animation = 'sunGlow 1.5s ease-in-out';
        setTimeout(() => {
          icon.style.animation = '';
        }, 1500);
      }, 5000);
    });

    // Efecto de onda en botones principales
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
      button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple-effect');
        
        this.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
      });
    });

    // Animación de estrellas en testimonios
    const starRatings = document.querySelectorAll('.testimonial-card .bi-star-fill');
    starRatings.forEach((star, index) => {
      setTimeout(() => {
        star.style.opacity = '0';
        star.style.animation = 'fadeIn 0.5s ease-out forwards';
      }, index * 100);
    });

    // Smooth scroll mejorado para enlaces internos
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Navbar con efecto al hacer scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        navbar.style.background = 'rgba(255,255,255,0.98)';
      } else {
        navbar.style.boxShadow = 'none';
        navbar.style.background = 'transparent';
      }
    });
  });

  // CSS adicional para efectos dinámicos
  const style = document.createElement('style');
  style.textContent = `
    .ripple-effect {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.6);
      transform: scale(0);
      animation: ripple 0.6s ease-out;
      pointer-events: none;
    }

    @keyframes ripple {
      to {
        transform: scale(4);
        opacity: 0;
      }
    }

    .btn {
      position: relative;
      overflow: hidden;
    }
  `;
  document.head.appendChild(style);