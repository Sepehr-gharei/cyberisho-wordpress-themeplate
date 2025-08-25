<?php
/*
Template Name: about us
*/
get_header();
get_template_part('partials/about-us/about-us-section', 'about-us-section');
get_template_part('partials/about-us/chart-container-section', 'chart-container-section');
get_template_part('partials/about-us/team-and-members-section', 'team-and-members-section');
get_template_part('partials/about-us/collapse-section', 'collapse-section');
get_footer();


?>
<script>
   window.addEventListener("load", function () {
  const svg = document.getElementById("myChart");
  if (!svg) return;

  let lastTooltip = null; // Store the last tooltip
  let lastClickedCircle = null; // Store the last clicked circle

  function drawChart() {
    const svgWidth = svg.clientWidth || 600;
    const svgHeight = 200;
    svg.setAttribute("width", "100%");
    svg.setAttribute("height", svgHeight);

    // Clear existing content
    svg.innerHTML = "";

    const maxX = 600;
    const rawData = [
        { x: 0, y: 0, year: "", projects: "" },
        <?php
        $theme_options = get_option('cyberisho_main_option', []);
        $about_options = $theme_options['about'];
        $chart_items = $about_options['about_chart_items'];
        if (count($chart_items) < 6) {
            $chart_items = array_pad($chart_items, 6, ['year' => '', 'projects' => '']);
        }

        // تعریف موقعیت‌های x,y برای هر یک از 6 آیتم
        $positions = [
            ['x' => 80, 'y' => 50],
            ['x' => 160, 'y' => 20],
            ['x' => 250, 'y' => 160],
            ['x' => 380, 'y' => 80],
            ['x' => 480, 'y' => 130],
            ['x' => 600, 'y' => 200]
        ];
        ?>
        
        <?php for ($i = 0; $i < 6; $i++):
            $item = isset($chart_items[$i]) ? $chart_items[$i] : ['year' => '', 'projects' => ''];
            $year = esc_html($item['year']);
            $projects = esc_html($item['projects']);

            $pos = $positions[$i] ?? ['x' => 0, 'y' => 0]; // موقعیت فعلی
            ?>
                            { x: <?= $pos['x'] ?> / maxX, y: <?= $pos['y'] ?>, year: "<?= $year ?>", projects: "<?= $projects ?>" },
        <?php endfor; ?>
    ];


    const tenPercentX = svgWidth * 0.1;

    const allPoints = rawData.map((p, i) => ({
      x: i === 0 ? 0 : i === 1 ? tenPercentX : p.x * svgWidth,
      y: svgHeight - p.y,
      year: p.year,
      projects: p.projects,
    }));

    let pathD = "";
    for (let i = 0; i < allPoints.length - 1; i++) {
      const curr = allPoints[i];
      const next = allPoints[i + 1];

      if (i === 0) {
        const cp1x = curr.x + (30 * svgWidth) / maxX;
        const cp1y = curr.y;
        const cp2x = next.x - (30 * svgWidth) / maxX;
        const cp2y = next.y;

        pathD += `M ${curr.x},${curr.y}`;
        pathD += ` C ${cp1x},${cp1y} ${cp2x},${cp2y} ${next.x},${next.y}`;
      } else {
        const leftX = curr.x - (3 * svgWidth) / maxX;
        const rightX = curr.x + (3 * svgWidth) / maxX;

        pathD += ` L ${leftX},${curr.y}`;
        pathD += ` L ${rightX},${curr.y}`;

        const cp1x = rightX + (30 * svgWidth) / maxX;
        const cp1y = curr.y;
        const cp2x = next.x - (3 * svgWidth) / maxX - (30 * svgWidth) / maxX;
        const cp2y = next.y;

        pathD += ` C ${cp1x},${curr.y} ${cp2x},${next.y} ${
          next.x - (3 * svgWidth) / maxX
        },${next.y}`;
      }
    }

    const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
    path.setAttribute("d", pathD);
    path.setAttribute("fill", "none");
    path.setAttribute("stroke", "#000");
    path.setAttribute("stroke-width", "4");
    svg.appendChild(path);

    allPoints.slice(1).forEach((p, index) => {
      const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle"
      );
      circle.setAttribute("cx", p.x);
      circle.setAttribute("cy", p.y);
      circle.setAttribute("r", "10");
      circle.setAttribute("fill", "#000");
      circle.setAttribute("stroke", "var(--background-color)");
      circle.setAttribute("stroke-width", "5");
      circle.classList.add("chart-point");
      svg.appendChild(circle);

      // Function to create tooltip
      // Function to create tooltip
      // Function to create tooltip
      // Function to create tooltip
      // Function to create tooltip
      function createTooltip() {
        const verticalPadding = 30; // فاصله عمودی 30px از نقطه
        const horizontalOffset = 2; // جابجایی 2px به راست

        const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
        g.classList.add("tooltip-group");

        // ساخت متن با فرمت "پروژه‌ها • سال" و معکوس کردن ترتیب
        const formattedText = `${p.projects} • ${p.year}`
          .split(" ")
          .reverse()
          .join(" ");

        const text = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "text"
        );
        text.setAttribute("x", p.x + horizontalOffset); // 2px به راست
        text.setAttribute("y", p.y - verticalPadding); // 30px بالا
        text.setAttribute("text-anchor", "middle");
        text.setAttribute(
          "transform",
          `rotate(-90,${p.x + horizontalOffset},${p.y - verticalPadding})`
        );
        text.textContent = formattedText;

        // استایل‌دهی متن
        text.style.fill = "var(--text-medium-blue-color)";
        text.style.fontSize = "12px";
        text.style.fontWeight = "bold";
        text.style.fontFamily = "peyda-regular, Arial, sans-serif";
        text.style.letterSpacing = "0.5px";

        g.appendChild(text);
        return g;
      }
      function createTooltip() {
        const textPadding = 60; // فاصله 30px از نقطه
        const g = document.createElementNS("http://www.w3.org/2000/svg", "g");
        g.classList.add("tooltip-group");

        // ساخت متن با نقطه به عنوان جداکننده و ترتیب معکوس
        const formattedText = `${p.projects} • ${p.year}`
          .split(" ")
          .reverse()
          .join(" ");

        const text = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "text"
        );
        text.setAttribute("x", p.x);
        text.setAttribute("y", p.y - textPadding); // 30px بالاتر از نقطه
        text.setAttribute("text-anchor", "middle");
        text.setAttribute(
          "transform",
          `rotate(-90,${p.x},${p.y - textPadding})`
        );
        text.textContent = formattedText;

        // استایل‌دهی متن
        text.style.fill = "var(--text-medium-blue-color)";
        text.style.fontSize = "12px";
        text.style.fontWeight = "bold";
        text.style.fontFamily = "peyda-regular, Arial, sans-serif";
        text.style.letterSpacing = "0.5px"; // فاصله بین حروف

        g.appendChild(text);
        return g;
      }
      circle.addEventListener("mousemove", (e) => {
        // Reset the previously clicked circle
        if (lastClickedCircle && lastClickedCircle !== circle) {
          lastClickedCircle.classList.remove("clicked");
          lastClickedCircle.setAttribute("fill", "#000");
          lastClickedCircle = null;
        }

        // Remove previous tooltip
        if (lastTooltip) lastTooltip.remove();

        // Create and show new tooltip
        const tooltip = createTooltip();
        svg.appendChild(tooltip);
        lastTooltip = tooltip;
      });

      circle.addEventListener("mouseout", () => {
        if (!circle.classList.contains("clicked")) {
          if (lastTooltip) lastTooltip.remove();
          lastTooltip = null;
        }
      });

      // Click Event
      circle.addEventListener("click", () => {
        // Remove previous tooltip and reset previous circle
        if (lastTooltip) lastTooltip.remove();
        if (lastClickedCircle && lastClickedCircle !== circle) {
          lastClickedCircle.classList.remove("clicked");
          lastClickedCircle.setAttribute("fill", "#000");
        }

        // Add new tooltip
        const tooltip = createTooltip();
        svg.appendChild(tooltip);
        lastTooltip = tooltip;

        // Update circle color and state
        circle.classList.add("clicked");
        circle.setAttribute("fill", "var(--background-medium-blue-color)");
        lastClickedCircle = circle;
      });
    });
  }

  drawChart();
  window.addEventListener("resize", drawChart);
});
</script>