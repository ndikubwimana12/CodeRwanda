// CodeRwanda UI — ui.js

(function () {
    const root = document.documentElement;

    // Track mouse for background hover shimmer + button highlights
    window.addEventListener('mousemove', (e) => {
        const mx = (e.clientX / window.innerWidth) * 100 + '%';
        const my = (e.clientY / window.innerHeight) * 100 + '%';
        root.style.setProperty('--mx', mx);
        root.style.setProperty('--my', my);
        // Update any hovered .cr-btn for spotlight effect
        document.querySelectorAll('.cr-btn:hover').forEach(btn => {
            const rect = btn.getBoundingClientRect();
            const bx = ((e.clientX - rect.left) / rect.width) * 100 + '%';
            const by = ((e.clientY - rect.top) / rect.height) * 100 + '%';
            btn.style.setProperty('--mx', bx);
            btn.style.setProperty('--my', by);
        });
    });

    // Custom cursor
    const dot = document.createElement('div');
    dot.className = 'cr-cursor-dot';
    const outline = document.createElement('div');
    outline.className = 'cr-cursor-outline';
    document.body.append(dot, outline);

    let mouseX = window.innerWidth / 2, mouseY = window.innerHeight / 2;
    let outlineX = mouseX, outlineY = mouseY;

    window.addEventListener('mousemove', (e) => {
        mouseX = e.clientX; mouseY = e.clientY;
        dot.style.left = mouseX + 'px'; dot.style.top = mouseY + 'px';
    });

    function render() {
        // Smooth follow for outline
        outlineX += (mouseX - outlineX) * 0.15;
        outlineY += (mouseY - outlineY) * 0.15;
        outline.style.left = outlineX + 'px';
        outline.style.top = outlineY + 'px';
        requestAnimationFrame(render);
    }
    render();

    // Grow outline on interactive elements
    const growSelectors = 'a, button, .cr-btn, .cr-card';
    document.addEventListener('mouseover', (e) => {
        if (e.target.closest(growSelectors)) {
            outline.style.width = '44px';
            outline.style.height = '44px';
            outline.style.borderColor = 'rgba(255,255,255,1)';
        }
    });
    document.addEventListener('mouseout', (e) => {
        if (e.target.closest(growSelectors)) {
            outline.style.width = '28px';
            outline.style.height = '28px';
            outline.style.borderColor = 'rgba(255,255,255,0.8)';
        }
    });

    // Parallax: elements with [data-depth]
    const parallaxLayers = Array.from(document.querySelectorAll('.cr-parallax-layer[data-depth]'));
    window.addEventListener('mousemove', (e) => {
        const cx = window.innerWidth / 2;
        const cy = window.innerHeight / 2;
        const dx = (e.clientX - cx) / cx;
        const dy = (e.clientY - cy) / cy;
        parallaxLayers.forEach(el => {
            const depth = parseFloat(el.getAttribute('data-depth')) || 0.05;
            el.style.transform = `translate(${dx * depth * 30}px, ${dy * depth * 30}px)`;
        });
    });

    // Intersection fade-up for .cr-appear
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('is-inview');
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.cr-appear').forEach(el => observer.observe(el));
})();