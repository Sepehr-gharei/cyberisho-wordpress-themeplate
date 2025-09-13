<?php
/*
Template Name: landing
*/
get_header();
get_template_part('partials/landing/spinning-wheel-section', 'spinning-wheel-section');
get_template_part('partials/landing/project-brand-landing-section', 'project-brand-landing-section');
get_template_part('partials/landing/specifications-item-section', 'specifications-item-section');
get_template_part('partials/landing/portfolio-landing-item-section', 'portfolio-landing-item-section');
get_template_part('partials/landing/implementation-steps-section', 'implementation-steps-section');
get_template_part('partials/landing/price-plans-section', 'price-plans-section');
get_template_part('partials/landing/comment-review-landing-section', 'comment-review-landing-section');
get_template_part('partials/landing/accordion-fag-section', 'accordion-fag-section');
get_template_part('partials/landing/call-request-landing-section', 'call-request-landing-section');
get_template_part('partials/landing/website-information-section', 'website-information-section');
get_template_part('partials/landing/cyberisho-slogan-section', 'cyberisho-slogan-section');
get_footer();
?>


<script>
    const wheelContainer = document.querySelector(
        ".spinning-wheel-section .wheel-container"
    );
    const canvas = wheelContainer.querySelector("#wheel");
    const ctx = canvas.getContext("2d");
    const W = canvas.width;
    const H = canvas.height;
    const cx = W / 2;
    const cy = H / 2;
    const radius = Math.min(W, H) / 2 - 8;
    <?php
    // این کد PHP برای دریافت داده‌های متاباکس و تولید آرایه segments است
    global $post;

    // فرض می‌کنیم پست فعلی همان صفحه لندینگ است
    if ($post && $post->post_type === 'page' && $post->post_name === 'landing') {
        $carousel_items = get_post_meta($post->ID, '_landing_carousel_items', true);
        $carousel_items_data = !empty($carousel_items) ? json_decode($carousel_items, true) : array_fill(0, 5, ['text' => '', 'audio_url' => '']);

        // تولید آرایه segments
        $segments = [];
        foreach ($carousel_items_data as $item) {
            $segments[] = [
                'label' => !empty($item['text']) ? esc_js($item['text']) : '',
                'color' => '#2743da', // رنگ پیش‌فرض
                'audio' => !empty($item['audio_url']) ? esc_url($item['audio_url']) : ''
            ];
        }
    } else {
        // در صورتی که پست لندینگ نباشد، آرایه خالی یا پیش‌فرض
        $segments = [
            ['label' => '', 'color' => '#2743da', 'audio' => ''],
            ['label' => '', 'color' => '#2743da', 'audio' => ''],
            ['label' => '', 'color' => '#2743da', 'audio' => ''],
            ['label' => '', 'color' => '#2743da', 'audio' => ''],
            ['label' => '', 'color' => '#2743da', 'audio' => '']
        ];
    }
    ?>

    let segments = <?php echo wp_json_encode($segments, JSON_UNESCAPED_UNICODE); ?>;
    let usedSegments = []; // Track used segments
    const originalSegments = [...segments]; // Store original segments for reset
    let rotation = 0;
    let spinning = false;
    let animationId = null;
    let n = segments.length;
    const anglePer = (Math.PI * 2) / n;
    const redAngle = 0;
    const player = wheelContainer.querySelector(".carrousel-player");
    const btn = player.querySelector("button");
    const audio = wheelContainer.querySelector("#result-audio");
    const border = player.querySelector(".progress-border");
    const result = wheelContainer.querySelector("#result");
    let playing = false;
    const playSVG = `<div class="inside"><svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect width="48" height="48" fill="var(--background-color)" fill-opacity="0.01"/>
<path d="M16 12V36" stroke="var(--background-color)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M32 12V36" stroke="var(--background-color)" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
</svg></div>`;
    const pauseSVG = `<div class="inside"><svg id="play-button-icon" viewBox="0 0 330 330">
<path d="M37.728,328.12c2.266,1.256,4.77,1.88,7.272,1.88c2.763,0,5.522-0.763,7.95-2.28l240-149.999
c4.386-2.741,7.05-7.548,7.05-12.72c0-5.172-2.664-9.979-7.05-12.72L52.95,2.28c-4.625-2.891-10.453-3.043-15.222-0.4
C32.959,4.524,30,9.547,30,15v300C30,320.453,32.959,325.476,37.728,328.12z" fill="var(--background-color)"></path>
</svg></div>`;

    function drawWheel() {
        ctx.clearRect(0, 0, W, H);
        for (let i = 0; i < n; i++) {
            const start = rotation + i * anglePer;
            const end = start + anglePer;
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.arc(cx, cy, radius, start, end);
            ctx.closePath();
            ctx.fillStyle = segments[i].color;
            ctx.fill();
            ctx.save();
            ctx.translate(cx, cy);
            const mid = start + anglePer / 2;
            ctx.rotate(mid);
            ctx.textAlign = "right";
            ctx.fillStyle = "#fff";
            ctx.font = "bold 21px peyda-regular";
            ctx.fillText(segments[i].label, radius - 30, 8);
            ctx.restore();
        }
        const alpha = anglePer / 2;
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, radius, alpha, Math.PI * 2 - alpha);
        ctx.closePath();
        ctx.fillStyle = "#ffd400";
        ctx.fill();
        ctx.save();
        ctx.globalCompositeOperation = "multiply";
        const shadowGradient = ctx.createLinearGradient(
            0,
            cy - radius,
            0,
            cy + radius
        );
        shadowGradient.addColorStop(0, "rgba(0,100,0,0.9)");
        shadowGradient.addColorStop(0.45, "rgba(0,100,0,0)");
        shadowGradient.addColorStop(0.55, "rgba(0,100,0,0)");
        shadowGradient.addColorStop(1, "rgba(0,100,0,0.9)");
        ctx.beginPath();
        ctx.moveTo(cx, cy);
        ctx.arc(cx, cy, radius, -alpha, alpha, false);
        ctx.closePath();
        ctx.fillStyle = shadowGradient;
        ctx.fill();
        ctx.restore();
        ctx.beginPath();
        ctx.arc(cx, cy, 36, 0, Math.PI * 2);
        ctx.fillStyle = "rgba(255,255,255,0.03)";
        ctx.fill();
        ctx.beginPath();
        ctx.arc(cx, cy, radius + 4, 0, Math.PI * 2);
        ctx.strokeStyle = "#142caf";
        ctx.lineWidth = 20;
        ctx.stroke();
    }

    let targetRotation = 0;
    let velocity = 0;

    function animate() {
        if (!spinning) return;
        const diff = targetRotation - rotation;
        velocity += diff * 0.05;
        velocity *= 0.95;
        rotation += velocity;
        if (Math.abs(velocity) < 0.0001 && Math.abs(diff) < 0.0001) {
            rotation = targetRotation;
            spinning = false;
            announceResult();
        }
        drawWheel();
        animationId = requestAnimationFrame(animate);
    }

    function spin() {
        if (spinning) return;
        // Pause any playing audio before spinning
        if (playing) {
            audio.pause();
            btn.innerHTML = pauseSVG;
            player.style.backgroundColor = "#9ca5f1";
            border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
            playing = false;
        }
        spinning = true;
        // Select only from available (non-used) segments
        const availableSegments = segments.filter(
            (_, i) => !usedSegments.includes(i)
        );
        if (availableSegments.length === 0) {
            // Reset when all segments are used
            usedSegments = [];
            segments = [...originalSegments];
            n = segments.length;
        }
        const availableIndices = segments
            .map((_, i) => i)
            .filter((i) => !usedSegments.includes(i));
        const index =
            availableIndices[Math.floor(Math.random() * availableIndices.length)];
        usedSegments.push(index); // Mark segment as used
        targetRotation =
            -(index * anglePer + anglePer / 2 - redAngle) -
            2 * Math.PI * (5 + Math.floor(Math.random() * 3));
        velocity = 0;
        animate();
    }

    function announceResult() {
        const normalized =
            ((-rotation % (Math.PI * 2)) + Math.PI * 2) % (Math.PI * 2);
        const index = Math.floor(normalized / anglePer) % n;
        const seg = segments[index];
        result.textContent = "نتیجه: " + seg.label;
        // Play audio after wheel stops
        if (seg.audio) {
            audio.src = seg.audio;
            audio.load();
            audio
                .play()
                .then(() => {
                    btn.innerHTML = playSVG;
                    playing = true;
                })
                .catch((err) => {
                    console.error("Audio playback failed:", err);
                    result.textContent += " (خطا در پخش صدا)";
                });
        } else {
            result.textContent += " (بدون صوت)";
        }
    }

    btn.addEventListener("click", () => {
        if (!playing) {
            audio
                .play()
                .then(() => {
                    btn.innerHTML = playSVG;
                    playing = true;
                })
                .catch((err) => {
                    console.error("Audio playback failed:", err);
                    result.textContent = "خطا در پخش صدا";
                });
        } else {
            audio.pause();
            btn.innerHTML = pauseSVG;
            player.style.backgroundColor = "#9ca5f1";
            border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
            playing = false;
        }
    });

    audio.addEventListener("timeupdate", () => {
        if (audio.duration > 0) {
            const progress = audio.currentTime / audio.duration;
            const angle = progress * 270;
            border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg ${angle}deg, transparent ${angle}deg 360deg )`;
        }
    });

    audio.addEventListener("ended", () => {
        playing = false;
        btn.innerHTML = pauseSVG;
        player.style.backgroundColor = "#9ca5f1";
        border.style.background = `conic-gradient(from 135deg, rgba(255,255,255,0.8) 0deg 0deg, transparent 0deg 360deg )`;
    });

    const initialIndex = Math.floor(Math.random() * n);
    rotation = -(initialIndex * anglePer + anglePer / 2 - redAngle);
    // تنظیم صوت و نتیجه اولیه
    const initialSegment = segments[initialIndex];
    if (initialSegment.audio) {
        audio.src = initialSegment.audio;
        audio.load();
        result.textContent = "نتیجه: " + initialSegment.label;
    } else {
        result.textContent = "نتیجه: " + initialSegment.label + " (بدون صوت)";
    }

    drawWheel();

    wheelContainer.querySelector("#spin").addEventListener("click", spin);
</script>