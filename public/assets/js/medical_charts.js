/**
 * Nurtura Medical Visualizations & Clinical Charts Module
 * 100% Offline-Ready & Self-Contained SVG/Canvas Medical Chart Engine
 * Standards: Kementerian Kesehatan RI (Standar Antropometri Ibu Hamil & AKG Klinis)
 */

(function (window, document) {
    'use strict';

    const MedicalCharts = {
        // Clinical Standards (Kemenkes RI)
        KEK_THRESHOLD: 23.5,
        LILA_MIN: 15.0,
        LILA_MAX: 35.0,

        RADAR_AXES: [
            { key: 'protein', label: 'Protein Hewani', desc: 'Pertumbuhan jaringan & pencegahan stunting' },
            { key: 'kalsium', label: 'Kalsium', desc: 'Pembentukan tulang janin & gigi' },
            { key: 'kalori', label: 'Kalori & Energi', desc: 'Energi metabolisme ibu hamil' },
            { key: 'folat', label: 'Asam Folat', desc: 'Mencegah defek tabung saraf (NTD)' },
            { key: 'besi', label: 'Zat Besi (Fe)', desc: 'Mencegah anemia maternal & BBLR' }
        ],

        /**
         * Render Semi-Circular Clinical LILA Gauge (Pure 3D SVG)
         * Maps arm circumference against the 23.5 cm KEK threshold
         */
        renderLilaGauge: function (container, options) {
            if (typeof container === 'string') {
                container = document.querySelector(container);
            }
            if (!container) return;

            options = options || {};
            const rawVal = options.value !== undefined ? options.value : (container.getAttribute('data-lila') || 23.5);
            const val = parseFloat(rawVal) || 0;
            const min = parseFloat(options.min || this.LILA_MIN);
            const max = parseFloat(options.max || this.LILA_MAX);
            const threshold = parseFloat(options.threshold || this.KEK_THRESHOLD);

            const isKek = val > 0 && val < threshold;
            const statusText = val <= 0 ? 'Belum Ada Data' : (isKek ? 'Risiko KEK (< 23.5 cm)' : 'Normal / Aman (≥ 23.5 cm)');
            const statusClass = val <= 0 ? 'badge-secondary' : (isKek ? 'badge-kek-risk' : 'badge-kek-normal');
            const theme = options.theme || container.getAttribute('data-theme') || 'light';
            const isDark = theme === 'dark';

            const width = options.width || 300;
            const height = options.height || 185;
            const cx = width / 2;
            const cy = height - 35;
            const r = Math.min(width * 0.42, 115);
            const strokeWidth = 18;

            // Clamped value for calculation
            const clampedVal = Math.max(min, Math.min(max, val > 0 ? val : threshold));
            const ratio = (clampedVal - min) / (max - min);

            // Needle rotation angle:
            // Needle is drawn pointing straight UP (12 o'clock).
            // Rotation is: -90 deg (9 o'clock / min 15 cm) to +90 deg (3 o'clock / max 35 cm).
            const targetAngleDeg = -90 + (ratio * 180);

            // Arc angles (180 deg = left/9 o'clock, 270 deg = top/12 o'clock, 360 deg = right/3 o'clock)
            const thresholdRatio = (threshold - min) / (max - min);
            const thresholdAngleDeg = 180 + thresholdRatio * 180;

            function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
                const angleInRadians = (angleInDegrees * Math.PI) / 180.0;
                return {
                    x: centerX + radius * Math.cos(angleInRadians),
                    y: centerY + radius * Math.sin(angleInRadians)
                };
            }

            function describeArc(x, y, radius, startAngle, endAngle) {
                const start = polarToCartesian(x, y, radius, startAngle);
                const end = polarToCartesian(x, y, radius, endAngle);
                const largeArcFlag = endAngle - startAngle <= 180 ? '0' : '1';
                return ['M', start.x.toFixed(2), start.y.toFixed(2), 'A', radius, radius, 0, largeArcFlag, 1, end.x.toFixed(2), end.y.toFixed(2)].join(' ');
            }

            const dangerArcPath = describeArc(cx, cy, r, 180, thresholdAngleDeg);
            const safeArcPath = describeArc(cx, cy, r, thresholdAngleDeg, 360);
            const trackPath = describeArc(cx, cy, r, 180, 360);

            // Coordinates for threshold indicator tick (at 23.5 cm)
            const threshPointInner = polarToCartesian(cx, cy, r - strokeWidth / 2 - 3, thresholdAngleDeg);
            const threshPointOuter = polarToCartesian(cx, cy, r + strokeWidth / 2 + 5, thresholdAngleDeg);

            // Generate unique ID for SVG filters
            const uid = 'lila_' + Math.random().toString(36).substr(2, 9);

            const maxGaugeRem = (width / 16).toFixed(4);
            const originXPct = ((cx / width) * 100).toFixed(2);
            const originYPct = ((cy / height) * 100).toFixed(2);

            container.innerHTML = `
                <div class="medical-gauge-wrapper ${isDark ? 'dark-mode' : ''}" style="position: relative; text-align: center; max-width: ${maxGaugeRem}rem; margin: 0 auto;">
                    <svg viewBox="0 0 ${width} ${height}" class="medical-gauge-svg" style="width: 100%; height: auto; overflow: visible;" role="img" aria-label="Grafik Gauge LILA: ${val > 0 ? val.toFixed(1) : '-'} cm">
                        <defs>
                            <!-- 3D Drop Shadow & Glow Filters -->
                            <filter id="${uid}_shadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="3" stdDeviation="3" flood-color="rgba(15, 23, 42, 0.25)" />
                            </filter>
                            <linearGradient id="${uid}_dangerGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#A83836" />
                                <stop offset="100%" stop-color="#A83836" />
                            </linearGradient>
                            <linearGradient id="${uid}_safeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#006D30" />
                                <stop offset="100%" stop-color="#006D30" />
                            </linearGradient>
                            <linearGradient id="${uid}_needleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#2D3339" />
                                <stop offset="100%" stop-color="#2D3339" />
                            </linearGradient>
                        </defs>

                        <!-- Track Background -->
                        <path d="${trackPath}" fill="none" stroke="${isDark ? '#334155' : '#DDE3EB'}" stroke-width="${strokeWidth + 2}" stroke-linecap="round" />

                        <!-- Zone 1: Risiko KEK (< 23.5 cm) -->
                        <path d="${dangerArcPath}" fill="none" stroke="url(#${uid}_dangerGrad)" stroke-width="${strokeWidth}" stroke-linecap="round" />

                        <!-- Zone 2: Normal / Gizi Cukup (>= 23.5 cm) -->
                        <path d="${safeArcPath}" fill="none" stroke="url(#${uid}_safeGrad)" stroke-width="${strokeWidth}" stroke-linecap="round" />

                        <!-- Ambang Batas 23.5 cm Tick -->
                        <line x1="${threshPointInner.x.toFixed(1)}" y1="${threshPointInner.y.toFixed(1)}" x2="${threshPointOuter.x.toFixed(1)}" y2="${threshPointOuter.y.toFixed(1)}" stroke="#904D00" stroke-width="2.5" stroke-linecap="round" />

                        <!-- Scale Numbers -->
                        <text x="${cx - r - 6}" y="${cy + 18}" text-anchor="middle" font-size="10" font-weight="600" fill="${isDark ? '#A6ACB3' : '#5A6067'}">15 cm</text>
                        <text x="${threshPointOuter.x.toFixed(1)}" y="${(threshPointOuter.y - 7).toFixed(1)}" text-anchor="middle" font-size="9" font-weight="700" fill="#904D00">23.5</text>
                        <text x="${cx + r + 6}" y="${cy + 18}" text-anchor="middle" font-size="10" font-weight="600" fill="${isDark ? '#A6ACB3' : '#5A6067'}">35 cm</text>

                        <!-- 3D Dynamic Needle Group (Rotates around cx, cy) -->
                        <g id="${uid}_needle_group" transform="rotate(${targetAngleDeg}, ${cx}, ${cy})" style="transform-box: view-box; transform-origin: ${originXPct}% ${originYPct}%; transform: rotate(${targetAngleDeg}deg); transition: transform 1.0s cubic-bezier(0.2, 0, 0, 1);">
                            <!-- Needle Body -->
                            <polygon points="${cx - 3.5},${cy} ${cx + 3.5},${cy} ${cx},${cy - r + 12}" fill="${isDark ? '#AACAE9' : 'url(#' + uid + '_needleGrad)'}" />
                            <circle cx="${cx}" cy="${cy - r + 12}" r="3" fill="#376386" />
                            <!-- Center Pivot Disc -->
                            <circle cx="${cx}" cy="${cy}" r="10" fill="${isDark ? '#151A1F' : '#FFFFFF'}" stroke="${isDark ? '#AACAE9' : '#376386'}" stroke-width="3" />
                            <circle cx="${cx}" cy="${cy}" r="4" fill="#376386" />
                        </g>
                    </svg>

                    <!-- Center Clinical Readout -->
                    <div class="medical-gauge-readout" style="margin-top: -0.625rem;">
                        <div style="display: flex; align-items: baseline; justify-content: center; gap: 0.25rem;">
                            <span style="font-family: ui-monospace, SFMono-Regular, Consolas, monospace; font-size: 1.85rem; font-weight: 700; color: ${isDark ? '#E0E6EE' : '#2D3339'}; letter-spacing: -0.02em;">
                                ${val > 0 ? val.toFixed(1) : '-'}
                            </span>
                            <span style="font-size: 0.85rem; font-weight: 600; color: ${isDark ? '#A6ACB3' : '#5A6067'};">cm</span>
                        </div>
                        <div style="margin-top: 0.25rem;">
                            <div class="${val <= 0 ? '' : (isKek ? 'status-kek-text' : 'status-normal-text')}" style="font-size: 0.82rem; font-weight: 700;">
                                ${statusText}
                            </div>
                        </div>
                        <div style="font-size: 0.75rem; color: ${isDark ? '#A6ACB3' : '#5A6067'}; margin-top: 0.375rem;">
                            Standar Kemenkes RI: Ambang batas normal minimal <strong>23,5 cm</strong>
                        </div>
                    </div>
                </div>
            `;
        },

        /**
         * Intelligent Food Keyword Analyzer
         * Parses Indonesian food text into 5 nutritional scores (% AKG Bumil)
         */
        analyzeFoodItems: function (text) {
            text = (text || '').toLowerCase().trim();

            if (!text) {
                return [50, 45, 55, 40, 45]; // Balanced base scores
            }

            let scores = {
                protein: 42,
                kalsium: 40,
                kalori: 48,
                folat: 38,
                besi: 40
            };

            // Protein Hewani keywords
            if (/(telur|telor|ayam|daging|sapi|ikan|lele|tuna|tongkol|salmon|udang|kembung|mujair|patin|bebek|belut|hati\s*ayam|protein\s*hewani)/.test(text)) {
                scores.protein += 45;
                scores.besi += 20;
            }
            // Kalsium & Susu keywords
            if (/(susu|lactamil|prenagen|sgm|keju|yoghurt|yogurt|teri|rebon|kalsium|kedelai|tahu|tempe)/.test(text)) {
                scores.kalsium += 46;
                scores.kalori += 16;
            }
            // Kalori & Karbohidrat seimbang keywords
            if (/(beras|nasi|kentang|ubi|umbi|singkong|jagung|havermut|oat|roti|madu|biskuit|kalori|minyak)/.test(text)) {
                scores.kalori += 38;
            }
            // Asam Folat keywords
            if (/(folat|asam\s*folat|bayam|brokoli|kacang\s*hijau|alpukat|jeruk|pisang|sayuran\s*hijau|katuk|kelor|daun\s*kelor|sawi|sayur)/.test(text)) {
                scores.folat += 46;
                scores.besi += 16;
            }
            // Zat Besi (Fe) keywords
            if (/(zat\s*besi|fe|tablet\s*tambah\s*darah|ttd|hati|bayam|daging\s*merah|kangkung|darah|kelor)/.test(text)) {
                scores.besi += 45;
                scores.protein += 15;
            }

            // Clamp scores between 30% and 96% AKG
            return [
                Math.min(96, Math.max(30, scores.protein)),
                Math.min(96, Math.max(30, scores.kalsium)),
                Math.min(96, Math.max(30, scores.kalori)),
                Math.min(96, Math.max(30, scores.folat)),
                Math.min(96, Math.max(30, scores.besi))
            ];
        },

        // Backward compatibility alias
        calculateScoresFromText: function (text) {
            const arr = this.analyzeFoodItems(text);
            return {
                protein: arr[0],
                kalsium: arr[1],
                kalori: arr[2],
                folat: arr[3],
                besi: arr[4]
            };
        },

        /**
         * Render 5-Axis Nutritional Radar Chart (Pure 3D SVG)
         * Generates a fully enclosed radar chart where labels never clip
         */
        renderNutritionRadar: function (container, options) {
            if (typeof container === 'string') {
                container = document.querySelector(container);
            }
            if (!container) return;

            options = options || {};
            let values = options.values;
            const foodText = options.foodText || container.getAttribute('data-food-text');

            if (!values || !Array.isArray(values) || values.length < 5) {
                const dataAttr = container.getAttribute('data-nutrients');
                if (dataAttr) {
                    values = dataAttr.split(',').map(function (v) { return parseFloat(v.trim()) || 50; });
                } else if (foodText) {
                    values = this.analyzeFoodItems(foodText);
                } else {
                    values = [88, 85, 75, 82, 80]; // default rich prenatal nutritional package
                }
            }

            const theme = options.theme || container.getAttribute('data-theme') || 'light';
            const isDark = theme === 'dark';
            const size = options.size || 340;
            const uid = 'radar_' + Math.random().toString(36).substr(2, 9);

            // Canvas & geometry dimensions:
            // Centered layout with generous margins for labels
            const cx = 180;
            const cy = 185;
            const r = 95; // Radius of 100% AKG web ring

            // 5 Axes Angles: Start at -90 deg (Top), step 72 deg
            const numAxes = 5;
            const stepAngle = (2 * Math.PI) / numAxes;
            const startAngle = -Math.PI / 2;

            function getPoint(axisIndex, ratio) {
                const angle = startAngle + axisIndex * stepAngle;
                return {
                    x: cx + r * ratio * Math.cos(angle),
                    y: cy + r * ratio * Math.sin(angle)
                };
            }

            // Concentric Web Rings (25%, 50%, 75%, 100%)
            const levels = [0.25, 0.5, 0.75, 1.0];
            let gridPolygons = '';
            levels.forEach(function (level) {
                let pts = [];
                for (let i = 0; i < numAxes; i++) {
                    const p = getPoint(i, level);
                    pts.push(`${p.x.toFixed(1)},${p.y.toFixed(1)}`);
                }
                const isOuter = level === 1.0;
                gridPolygons += `<polygon points="${pts.join(' ')}" fill="none" stroke="${isDark ? '#334155' : '#e2e8f0'}" stroke-width="${isOuter ? '1.5' : '1'}" stroke-dasharray="${isOuter ? 'none' : '3,3'}" />`;
            });

            // Axis Spokes & Labels
            let spokes = '';
            let labelElements = '';
            for (let i = 0; i < numAxes; i++) {
                const outer = getPoint(i, 1.0);
                const axisDef = MedicalCharts.RADAR_AXES[i];
                const score = values[i];

                spokes += `<line x1="${cx}" y1="${cy}" x2="${outer.x.toFixed(1)}" y2="${outer.y.toFixed(1)}" stroke="${isDark ? '#475569' : '#cbd5e1'}" stroke-width="1.2" />`;

                // Calculate label coordinates with proper margin
                const labelPos = getPoint(i, 1.28);
                let textAnchor = 'middle';
                let xOffset = 0;
                let yOffset = 0;

                if (i === 0) {
                    // Top (Protein Hewani)
                    textAnchor = 'middle';
                    yOffset = -8;
                } else if (i === 1) {
                    // Top-Right (Kalsium)
                    textAnchor = 'start';
                    xOffset = 6;
                    yOffset = -2;
                } else if (i === 2) {
                    // Bottom-Right (Kalori & Energi)
                    textAnchor = 'start';
                    xOffset = 6;
                    yOffset = 10;
                } else if (i === 3) {
                    // Bottom-Left (Asam Folat)
                    textAnchor = 'end';
                    xOffset = -6;
                    yOffset = 10;
                } else if (i === 4) {
                    // Top-Left (Zat Besi)
                    textAnchor = 'end';
                    xOffset = -6;
                    yOffset = -2;
                }

                const lx = labelPos.x + xOffset;
                const ly = labelPos.y + yOffset;

                labelElements += `
                    <g class="radar-axis-label" style="cursor: pointer;">
                        <title>${axisDef.label}: ${score}% AKG (${axisDef.desc})</title>
                        <text x="${lx.toFixed(1)}" y="${(ly - 4).toFixed(1)}" text-anchor="${textAnchor}" font-size="10.5" font-weight="600" fill="${isDark ? '#E0E6EE' : '#2D3339'}">
                            ${axisDef.label}
                        </text>
                        <text x="${lx.toFixed(1)}" y="${(ly + 10).toFixed(1)}" text-anchor="${textAnchor}" font-size="9.5" font-weight="700" fill="#376386">
                            ${score}% AKG
                        </text>
                    </g>
                `;
            }

            // Benchmark 100% AKG Guide Polygon
            let benchmarkPts = [];
            for (let i = 0; i < numAxes; i++) {
                const p = getPoint(i, 1.0);
                benchmarkPts.push(`${p.x.toFixed(1)},${p.y.toFixed(1)}`);
            }
            const benchmarkPolygon = `<polygon points="${benchmarkPts.join(' ')}" fill="none" stroke="${isDark ? '#70767D' : '#ADB2BA'}" stroke-width="1.2" stroke-dasharray="4,4" opacity="0.7" />`;

            // Data Polygon Points
            let dataPts = [];
            let vertexCircles = '';
            for (let i = 0; i < numAxes; i++) {
                const ratio = Math.max(0.1, Math.min(1.0, values[i] / 100));
                const p = getPoint(i, ratio);
                dataPts.push(`${p.x.toFixed(1)},${p.y.toFixed(1)}`);
                vertexCircles += `
                    <circle cx="${p.x.toFixed(1)}" cy="${p.y.toFixed(1)}" r="4.5" fill="#376386" stroke="${isDark ? '#0C0E11' : '#FFFFFF'}" stroke-width="2" />
                `;
            }

            const maxRadarRem = ((size + 40) / 16).toFixed(4);
            container.innerHTML = `
                <div class="medical-radar-card ${isDark ? 'dark-mode' : ''}" style="position: relative; text-align: center; max-width: ${maxRadarRem}rem; margin: 0 auto; overflow: visible;">
                    <svg viewBox="-70 -15 500 395" class="medical-radar-svg" style="width: 100%; height: auto; max-width: 100%; overflow: visible;" role="img" aria-label="Diagram Radar Nutrisi 5 Sumbu">
                        <!-- Concentric Web -->
                        ${gridPolygons}

                        <!-- Axis Spokes -->
                        ${spokes}

                        <!-- 100% AKG Guide Line -->
                        ${benchmarkPolygon}

                        <!-- Actual Data Filled Polygon (Clinical Care Cerulean Container) -->
                        <polygon points="${dataPts.join(' ')}" fill="#A9D3FC" fill-opacity="0.45" stroke="#376386" stroke-width="2.5" />

                        <!-- Vertex Nodes -->
                        ${vertexCircles}

                        <!-- Axis Labels -->
                        ${labelElements}
                    </svg>

                    <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-top: 0.375rem; font-size: 0.75rem; color: ${isDark ? '#A6ACB3' : '#5A6067'};">
                        <span style="display: inline-flex; align-items: center; gap: 0.375rem;">
                            <span style="display: inline-block; width: 0.75rem; height: 0.75rem; background: #376386; border-radius: 0.1875rem;"></span>
                            Paket Pengajuan
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 0.375rem;">
                            <span style="display: inline-block; width: 0.875rem; height: 0; border-top: 0.125rem dashed #ADB2BA;"></span>
                            Standar 100% AKG Kemenkes
                        </span>
                    </div>
                </div>
            `;
        },

        // Backward compatibility alias
        renderNutritionalRadar: function (container, scores) {
            let values;
            if (scores && typeof scores === 'object') {
                if (Array.isArray(scores)) {
                    values = scores;
                } else {
                    values = [
                        scores.protein || 85,
                        scores.kalsium || 80,
                        scores.kalori || 75,
                        scores.folat || 85,
                        scores.besi || 80
                    ];
                }
            }
            this.renderNutritionRadar(container, { values: values });
        },

        /**
         * Realtime Binder for Create Need Form
         * Connects the food textarea to the live mini radar chart
         */
        bindLiveNutritionalPreview: function (textareaId, radarContainerId) {
            const textarea = document.getElementById(textareaId);
            const radarContainer = document.getElementById(radarContainerId);
            if (!textarea || !radarContainer) return;

            let debounceTimer = null;
            const update = function () {
                const text = textarea.value;
                const scores = MedicalCharts.analyzeFoodItems(text);
                MedicalCharts.renderNutritionRadar(radarContainer, {
                    values: scores,
                    foodText: text,
                    size: 280
                });
            };

            textarea.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(update, 200);
            });

            // Initial render
            update();
        },

        /**
         * Initialize all clinical charts safely based on explicit DOM attributes
         * (Guaranteed to NEVER target generic cards or filter attributes!)
         */
        init: function () {
            // 1. Explicit LILA Gauges
            const lilaGauges = document.querySelectorAll('[data-medical-chart="lila-gauge"], [data-lila-gauge]');
            lilaGauges.forEach(function (el) {
                MedicalCharts.renderLilaGauge(el);
            });

            // 2. Explicit Nutrition Radars
            const nutritionRadars = document.querySelectorAll('[data-medical-chart="nutrition-radar"], [data-nutritional-radar]');
            nutritionRadars.forEach(function (el) {
                MedicalCharts.renderNutritionRadar(el);
            });
        }
    };

    // Auto-init on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            MedicalCharts.init();
        });
    } else {
        MedicalCharts.init();
    }

    // Export both MedicalCharts and NurturaCharts globally
    window.MedicalCharts = MedicalCharts;
    window.NurturaCharts = MedicalCharts;

})(window, document);
