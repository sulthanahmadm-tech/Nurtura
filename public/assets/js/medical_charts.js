/**
 * Nurtura Medical Charts - 100% Self-Contained & Offline-Ready
 * Clinical SVG/Canvas Engine for Maternal & Infant Nutrition
 * Standards: Kemenkes RI Standard (LILA Threshold 23.5 cm & AKG Bumil)
 */

(function (window, document) {
    'use strict';

    const MedicalCharts = {
        // Clinical Guidelines
        KEK_THRESHOLD: 23.5,
        LILA_MIN: 15.0,
        LILA_MAX: 35.0,

        RADAR_AXES: [
            { key: 'protein', label: 'Protein Hewani', icon: '🥩', desc: 'Pertumbuhan jaringan & pencegahan stunting' },
            { key: 'kalsium', label: 'Kalsium', icon: '🥛', desc: 'Pembentukan tulang janin & gigi' },
            { key: 'kalori', label: 'Kalori & Energi', icon: '⚡', desc: 'Energi metabolisme ibu hamil' },
            { key: 'folat', label: 'Asam Folat', icon: '🥦', desc: 'Mencegah defek tabung saraf (NTD)' },
            { key: 'besi', label: 'Zat Besi (Fe)', icon: '🩸', desc: 'Mencegah anemia maternal & BBLR' }
        ],

        /**
         * Render Semi-Circular Clinical LILA Gauge (Pure SVG)
         */
        renderLilaGauge: function (container, options) {
            if (typeof container === 'string') {
                container = document.querySelector(container);
            }
            if (!container) return;

            options = options || {};
            const val = parseFloat(options.value !== undefined ? options.value : (container.getAttribute('data-lila') || 23.5));
            const min = parseFloat(options.min || this.LILA_MIN);
            const max = parseFloat(options.max || this.LILA_MAX);
            const threshold = parseFloat(options.threshold || this.KEK_THRESHOLD);
            const isKek = val < threshold;
            const statusText = isKek ? 'Risiko KEK (< 23.5 cm)' : 'Normal / Aman (≥ 23.5 cm)';
            const statusClass = isKek ? 'badge-kek-risk' : 'badge-kek-normal';
            const theme = options.theme || container.getAttribute('data-theme') || 'light';
            const isDark = theme === 'dark';

            const width = options.width || 300;
            const height = options.height || 190;
            const cx = width / 2;
            const cy = height - 38;
            const r = Math.min(width * 0.42, 115);
            const strokeWidth = 18;

            // Math angles: 180 deg (left) to 360 deg (right)
            const clampedVal = Math.max(min, Math.min(max, val));
            const ratio = (clampedVal - min) / (max - min);
            const targetAngleDeg = 180 + ratio * 180;
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
                return ['M', start.x, start.y, 'A', radius, radius, 0, largeArcFlag, 1, end.x, end.y].join(' ');
            }

            const dangerArcPath = describeArc(cx, cy, r, 180, thresholdAngleDeg);
            const safeArcPath = describeArc(cx, cy, r, thresholdAngleDeg, 360);
            const trackPath = describeArc(cx, cy, r, 180, 360);

            // Coordinates for threshold indicator tick
            const threshPointInner = polarToCartesian(cx, cy, r - strokeWidth / 2 - 3, thresholdAngleDeg);
            const threshPointOuter = polarToCartesian(cx, cy, r + strokeWidth / 2 + 5, thresholdAngleDeg);

            // Generate unique IDs for SVG defs to avoid collisions
            const uid = 'lila_' + Math.random().toString(36).substr(2, 9);

            container.innerHTML = `
                <div class="medical-gauge-wrapper ${isDark ? 'dark-mode' : ''}" style="position: relative; text-align: center; max-width: ${width}px; margin: 0 auto;">
                    <svg viewBox="0 0 ${width} ${height}" class="medical-gauge-svg" style="width: 100%; height: auto; overflow: visible;" role="img" aria-label="Grafik Gauge LILA: ${val.toFixed(1)} cm">
                        <defs>
                            <!-- 3D Drop Shadow Filter -->
                            <filter id="${uid}_shadow" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="4" stdDeviation="4" flood-color="rgba(15, 23, 42, 0.25)" />
                            </filter>
                            <filter id="${uid}_glow" x="-30%" y="-30%" width="160%" height="160%">
                                <feGaussianBlur stdDeviation="3" result="blur" />
                                <feComposite in="SourceGraphic" in2="blur" operator="over" />
                            </filter>
                            <!-- Linear Gradients -->
                            <linearGradient id="${uid}_dangerGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#ef4444" />
                                <stop offset="100%" stop-color="#f97316" />
                            </linearGradient>
                            <linearGradient id="${uid}_safeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#10b981" />
                                <stop offset="100%" stop-color="#0284c7" />
                            </linearGradient>
                            <linearGradient id="${uid}_needleGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#0f172a" />
                                <stop offset="50%" stop-color="#334155" />
                                <stop offset="100%" stop-color="#0f172a" />
                            </linearGradient>
                        </defs>

                        <!-- Track Background (3D Inset Groove) -->
                        <path d="${trackPath}" fill="none" stroke="${isDark ? '#334155' : '#e2e8f0'}" stroke-width="${strokeWidth + 2}" stroke-linecap="round" />

                        <!-- Zone 1: Risiko KEK (< 23.5 cm) -->
                        <path d="${dangerArcPath}" fill="none" stroke="url(#${uid}_dangerGrad)" stroke-width="${strokeWidth}" stroke-linecap="round" filter="url(#${uid}_shadow)" />

                        <!-- Zone 2: Normal / Gizi Cukup (>= 23.5 cm) -->
                        <path d="${safeArcPath}" fill="none" stroke="url(#${uid}_safeGrad)" stroke-width="${strokeWidth}" stroke-linecap="round" filter="url(#${uid}_shadow)" />

                        <!-- Ambang Batas 23.5 cm Tick -->
                        <line x1="${threshPointInner.x}" y1="${threshPointInner.y}" x2="${threshPointOuter.x}" y2="${threshPointOuter.y}" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" />

                        <!-- Scale Numbers -->
                        <text x="${cx - r - 8}" y="${cy + 18}" text-anchor="middle" font-size="10" font-weight="700" fill="${isDark ? '#94a3b8' : '#64748b'}">15 cm</text>
                        <text x="${threshPointOuter.x}" y="${threshPointOuter.y - 8}" text-anchor="middle" font-size="9" font-weight="800" fill="#f59e0b">23.5</text>
                        <text x="${cx + r + 8}" y="${cy + 18}" text-anchor="middle" font-size="10" font-weight="700" fill="${isDark ? '#94a3b8' : '#64748b'}">35 cm</text>

                        <!-- 3D Dynamic Needle Group -->
                        <g id="${uid}_needle_group" style="transform-origin: ${cx}px ${cy}px; transform: rotate(180deg); transition: transform 1.2s cubic-bezier(0.2, 0.8, 0.2, 1);">
                            <!-- Needle Shadow -->
                            <polygon points="${cx - 4},${cy} ${cx + 4},${cy} ${cx},${cy - r + 10}" fill="rgba(15, 23, 42, 0.3)" filter="url(#${uid}_shadow)" />
                            <!-- Needle Body -->
                            <polygon points="${cx - 3.5},${cy} ${cx + 3.5},${cy} ${cx},${cy - r + 12}" fill="${isDark ? '#38bdf8' : 'url(#' + uid + '_needleGrad)'}" />
                            <circle cx="${cx}" cy="${cy - r + 12}" r="3" fill="#c7f22b" />
                            <!-- Center Pivot Disc (3D Bevel) -->
                            <circle cx="${cx}" cy="${cy}" r="11" fill="${isDark ? '#1e293b' : '#ffffff'}" stroke="${isDark ? '#38bdf8' : '#0284c7'}" stroke-width="3" filter="url(#${uid}_shadow)" />
                            <circle cx="${cx}" cy="${cy}" r="4.5" fill="#0f172a" />
                        </g>
                    </svg>

                    <!-- Center Clinical Readout -->
                    <div class="medical-gauge-readout" style="margin-top: -12px;">
                        <div style="display: flex; align-items: baseline; justify-content: center; gap: 4px;">
                            <span style="font-size: 1.85rem; font-weight: 800; color: ${isDark ? '#f8fafc' : '#0f172a'}; letter-spacing: -0.02em;">
                                ${val.toFixed(1)}
                            </span>
                            <span style="font-size: 0.85rem; font-weight: 600; color: ${isDark ? '#94a3b8' : '#64748b'};">cm</span>
                        </div>
                        <div style="margin-top: 4px;">
                            <span class="badge ${statusClass}" style="font-size: 0.72rem; padding: 4px 12px; font-weight: 700; border-radius: 9999px;">
                                ${statusText}
                            </span>
                        </div>
                        <div style="font-size: 0.72rem; color: ${isDark ? '#94a3b8' : '#64748b'}; margin-top: 6px;">
                            Standar Kemenkes RI: Ambang batas normal minimal <strong>23,5 cm</strong>
                        </div>
                    </div>
                </div>
            `;

            // Trigger needle rotation animation
            setTimeout(function () {
                const needle = document.getElementById(uid + '_needle_group');
                if (needle) {
                    needle.style.transform = `rotate(${targetAngleDeg}deg)`;
                }
            }, 60);
        },

        /**
         * Intelligent Food Keyword Analyzer
         * Parses indonesian text into 5 nutritional scores (0-100)
         */
        analyzeFoodItems: function (text) {
            text = (text || '').toLowerCase();

            // Default balanced base scores
            let scores = {
                protein: 50,
                kalsium: 45,
                kalori: 55,
                folat: 40,
                besi: 45
            };

            // Protein Hewani keywords
            if (/(telur|telor|ayam|daging|sapi|ikan|lele|tuna|tongkol|salmon|udang|hati\s*ayam|protein\s*hewani)/.test(text)) {
                scores.protein += 42;
                scores.besi += 20;
            }
            // Kalsium & Susu keywords
            if (/(susu|lactamil|prenagen|sgm|keju|yoghurt|yogurt|teri|kalsium|kedelai)/.test(text)) {
                scores.kalsium += 45;
                scores.kalori += 15;
            }
            // Kalori & Karbohidrat keywords
            if (/(beras|nasi|kentang|ubi|umbi|jagung|oat|roti|madu|biskuit|kalori|minyak)/.test(text)) {
                scores.kalori += 38;
            }
            // Asam Folat keywords
            if (/(folat|asam\s*folat|bayam|brokoli|kacang\s*hijau|alpukat|jeruk|pisang|sayuran\s*hijau|sayur)/.test(text)) {
                scores.folat += 46;
                scores.besi += 15;
            }
            // Zat Besi (Fe) keywords
            if (/(zat\s*besi|fe|tablet\s*tambah\s*darah|ttd|hati|bayam|daging\s*merah|kangkung|darah)/.test(text)) {
                scores.besi += 45;
                scores.protein += 15;
            }

            // Clamp scores between 30 and 96
            return [
                Math.min(96, Math.max(30, scores.protein)),
                Math.min(96, Math.max(30, scores.kalsium)),
                Math.min(96, Math.max(30, scores.kalori)),
                Math.min(96, Math.max(30, scores.folat)),
                Math.min(96, Math.max(30, scores.besi))
            ];
        },

        /**
         * Render 5-Axis Nutritional Radar Chart (Pure SVG)
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
                    values = [85, 75, 70, 80, 78]; // default rich prenatal nutritional package
                }
            }

            const theme = options.theme || container.getAttribute('data-theme') || 'light';
            const isDark = theme === 'dark';
            const size = options.size || Math.min(container.clientWidth || 340, 360);
            const cx = size / 2;
            const cy = size / 2;
            const r = size * 0.35;
            const uid = 'radar_' + Math.random().toString(36).substr(2, 9);

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

            // Generate Concentric Web Rings (20%, 40%, 60%, 80%, 100%)
            const levels = [0.2, 0.4, 0.6, 0.8, 1.0];
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

            // Generate Axis Spokes
            let spokes = '';
            let labelElements = '';
            for (let i = 0; i < numAxes; i++) {
                const outer = getPoint(i, 1.0);
                const labelPos = getPoint(i, 1.25);
                const axisDef = MedicalCharts.RADAR_AXES[i];
                const score = values[i];

                spokes += `<line x1="${cx}" y1="${cy}" x2="${outer.x.toFixed(1)}" y2="${outer.y.toFixed(1)}" stroke="${isDark ? '#475569' : '#cbd5e1'}" stroke-width="1" />`;

                // Calculate label positioning adjustments
                let textAnchor = 'middle';
                if (labelPos.x < cx - 10) textAnchor = 'end';
                else if (labelPos.x > cx + 10) textAnchor = 'start';

                labelElements += `
                    <g class="radar-axis-label" style="cursor: pointer;">
                        <title>${axisDef.label}: ${score}% AKG (${axisDef.desc})</title>
                        <text x="${labelPos.x.toFixed(1)}" y="${(labelPos.y - 4).toFixed(1)}" text-anchor="${textAnchor}" font-size="11" font-weight="700" fill="${isDark ? '#f8fafc' : '#0f172a'}">
                            ${axisDef.icon} ${axisDef.label}
                        </text>
                        <text x="${labelPos.x.toFixed(1)}" y="${(labelPos.y + 11).toFixed(1)}" text-anchor="${textAnchor}" font-size="10" font-weight="800" fill="#0284c7">
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
            const benchmarkPolygon = `<polygon points="${benchmarkPts.join(' ')}" fill="none" stroke="${isDark ? '#64748b' : '#94a3b8'}" stroke-width="1.2" stroke-dasharray="4,4" opacity="0.6" />`;

            // Data Polygon Points
            let dataPts = [];
            let vertexCircles = '';
            for (let i = 0; i < numAxes; i++) {
                const ratio = Math.max(0.1, Math.min(1.0, values[i] / 100));
                const p = getPoint(i, ratio);
                dataPts.push(`${p.x.toFixed(1)},${p.y.toFixed(1)}`);
                vertexCircles += `
                    <circle cx="${p.x.toFixed(1)}" cy="${p.y.toFixed(1)}" r="5.5" fill="#c7f22b" stroke="${isDark ? '#0f172a' : '#ffffff'}" stroke-width="2" filter="url(#${uid}_drop)" />
                    <circle cx="${p.x.toFixed(1)}" cy="${p.y.toFixed(1)}" r="2" fill="#0f172a" />
                `;
            }

            container.innerHTML = `
                <div class="medical-radar-card ${isDark ? 'dark-mode' : ''}" style="position: relative; text-align: center; max-width: ${size + 40}px; margin: 0 auto;">
                    <div style="margin-bottom: 8px;">
                        <span class="badge badge-info" style="font-size: 0.72rem; padding: 4px 12px; font-weight: 700; border-radius: 9999px;">
                            Indeks 5 Sumbu Nutrisi Pangan Bumil
                        </span>
                    </div>

                    <svg viewBox="0 0 ${size} ${size}" class="medical-radar-svg" style="width: 100%; height: auto; overflow: visible;" role="img" aria-label="Diagram Radar Nutrisi 5 Sumbu">
                        <defs>
                            <filter id="${uid}_drop" x="-20%" y="-20%" width="140%" height="140%">
                                <feDropShadow dx="0" dy="5" stdDeviation="5" flood-color="rgba(2, 132, 199, 0.35)" />
                            </filter>
                            <linearGradient id="${uid}_fillGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#0284c7" stop-opacity="0.45" />
                                <stop offset="50%" stop-color="#38bdf8" stop-opacity="0.35" />
                                <stop offset="100%" stop-color="#c7f22b" stop-opacity="0.40" />
                            </linearGradient>
                        </defs>

                        <!-- Concentric Web -->
                        ${gridPolygons}

                        <!-- Axis Spokes -->
                        ${spokes}

                        <!-- 100% AKG Guide Line -->
                        ${benchmarkPolygon}

                        <!-- Actual Data Filled Polygon with 3D Depth -->
                        <polygon points="${dataPts.join(' ')}" fill="url(#${uid}_fillGrad)" stroke="#0284c7" stroke-width="2.5" filter="url(#${uid}_drop)" />

                        <!-- Vertex Nodes with 3D Tactile Highlights -->
                        ${vertexCircles}

                        <!-- Axis Labels -->
                        ${labelElements}
                    </svg>

                    <div style="display: flex; justify-content: center; align-items: center; gap: 16px; margin-top: 6px; font-size: 0.75rem; color: ${isDark ? '#94a3b8' : '#64748b'};">
                        <span style="display: inline-flex; align-items: center; gap: 6px;">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #0284c7; border-radius: 3px;"></span>
                            Paket Pengajuan
                        </span>
                        <span style="display: inline-flex; align-items: center; gap: 6px;">
                            <span style="display: inline-block; width: 14px; height: 0; border-top: 2px dashed #94a3b8;"></span>
                            Standar 100% AKG Kemenkes
                        </span>
                    </div>
                </div>
            `;
        },

        /**
         * Realtime Binder for Create Need Form
         * Connects the textarea input to the live mini radar chart
         */
        bindLiveNutritionalPreview: function (textareaId, radarContainerId) {
            const textarea = document.getElementById(textareaId);
            const radarContainer = document.getElementById(radarContainerId);
            if (!textarea || !radarContainer) return;

            let debounceTimer = null;
            function update() {
                const text = textarea.value;
                const scores = MedicalCharts.analyzeFoodItems(text);
                MedicalCharts.renderNutritionRadar(radarContainer, {
                    values: scores,
                    foodText: text,
                    size: 280
                });
            }

            textarea.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(update, 250);
            });

            // Initial render
            update();
        },

        /**
         * Initialize all charts automatically based on DOM attributes
         */
        init: function () {
            // Find all LILA Gauges
            const lilaGauges = document.querySelectorAll('[data-medical-chart="lila-gauge"]');
            lilaGauges.forEach(function (el) {
                MedicalCharts.renderLilaGauge(el);
            });

            // Find all Nutrition Radars
            const nutritionRadars = document.querySelectorAll('[data-medical-chart="nutrition-radar"]');
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

    // Export to global scope
    window.MedicalCharts = MedicalCharts;

})(window, document);
