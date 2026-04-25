<style>
    .app-content { padding: 0 !important; overflow: hidden !important; }
    .app-footer { display: none !important; }
    .app-main { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
    .map-fullscreen-wrap { flex: 1; position: relative; overflow: hidden; }
    #globe-wrap {
        position: absolute;
        inset: 0;
        background: #000d1a;
    }
    #globe-label {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        padding: 8px 20px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.05em;
        z-index: 10;
        pointer-events: none;
    }
    #globe-back {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 10;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }
    #globe-back:hover { background: rgba(255,255,255,0.2); color: #fff; }
    .globe-marker-wrap {
        width: 30px; height: 30px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        pointer-events: all !important;
    }
    .globe-marker {
        width: 12px; height: 12px;
        border-radius: 50%;
        background: #818cf8;
        box-shadow: 0 0 6px 2px rgba(129,140,248,0.8);
        position: relative;
        pointer-events: none;
    }
    .globe-marker::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        background: rgba(129,140,248,0.35);
        animation: pulse-ring 1.6s ease-out infinite;
    }
    @keyframes pulse-ring {
        0%   { transform: scale(0.6); opacity: 1; }
        100% { transform: scale(2.2); opacity: 0; }
    }
    #globe-tooltip {
        position: fixed;
        background: rgba(0,0,0,0.82);
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        pointer-events: none;
        display: none;
        z-index: 99999;
        white-space: nowrap;
        transform: translate(12px, -50%);
    }
</style>

<div class="map-fullscreen-wrap">
    <div id="globe-wrap">
        <div id="globe-label">Globe Interaktif — Siklus Siang &amp; Malam</div>
        <a href="<?= base_url('v_lokasi_startup') ?>" id="globe-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Peta
        </a>
    </div>
</div>
<div id="globe-tooltip"></div>

<script src="//unpkg.com/globe.gl"></script>
<script>
    var container = document.getElementById('globe-wrap');
    var startupPoints = <?= json_encode(array_values(array_map(function($s) {
        return [
            'lat'  => (float)$s->latitude,
            'lng'  => (float)$s->longitude,
            'name' => $s->nama_perusahaan,
        ];
    }, array_filter($startups, fn($s) => !empty($s->latitude))))) ?>;

    var avgLat = startupPoints.reduce(function(s,p){ return s+p.lat; },0) / (startupPoints.length||1);
    var avgLng = startupPoints.reduce(function(s,p){ return s+p.lng; },0) / (startupPoints.length||1);

    function buildClusters(radius) {
        var used = new Array(startupPoints.length).fill(false);
        var result = [];
        for (var i = 0; i < startupPoints.length; i++) {
            if (used[i]) continue;
            var g = { lat: startupPoints[i].lat, lng: startupPoints[i].lng, names: [startupPoints[i].name] };
            used[i] = true;
            for (var j = i+1; j < startupPoints.length; j++) {
                if (used[j]) continue;
                var dl = startupPoints[j].lat - startupPoints[i].lat;
                var dn = startupPoints[j].lng - startupPoints[i].lng;
                if (Math.sqrt(dl*dl+dn*dn) < radius) { g.names.push(startupPoints[j].name); used[j]=true; }
            }
            result.push(g);
        }
        return result;
    }

    function getRadius(alt) {
        if (alt > 3)   return 999;
        if (alt > 1.5) return 5;
        if (alt > 0.5) return 1;
        return 0.05;
    }

    function makeMarker(d) {
        var count = d.names.length;
        var size = 28;
        var wrap = document.createElement('div');
        wrap.style.cssText = 'position:relative;width:42px;height:42px;display:flex;align-items:center;justify-content:center;cursor:pointer;pointer-events:all;';
        var ring = document.createElement('div');
        ring.style.cssText = 'position:absolute;inset:0;border-radius:50%;background:rgba(99,102,241,0.3);animation:pulse-ring 1.6s ease-out infinite;pointer-events:none;';
        wrap.appendChild(ring);
        var dot = document.createElement('div');
        dot.style.cssText = 'width:'+size+'px;height:'+size+'px;border-radius:50%;background:#6366f1;box-shadow:0 0 10px 4px rgba(99,102,241,0.7);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:#fff;pointer-events:none;position:relative;z-index:1;line-height:1;';
        dot.textContent = count;
        wrap.appendChild(dot);
        var tip = document.getElementById('globe-tooltip');
        wrap.addEventListener('mouseenter', function(e) {
            tip.innerHTML = '<div style="font-size:11px;font-weight:700;color:#a5b4fc;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">'+count+' Startup</div>'+
                d.names.map(function(n,i){
                    return '<div style="padding:3px 0;'+(i<d.names.length-1?'border-bottom:1px solid rgba(255,255,255,0.1);':'')+'">'+n+'</div>';
                }).join('');
            tip.style.display='block';
            tip.style.left=(e.clientX+14)+'px';
            tip.style.top=e.clientY+'px';
        });
        wrap.addEventListener('mousemove', function(e) {
            tip.style.left=(e.clientX+14)+'px';
            tip.style.top=e.clientY+'px';
        });
        wrap.addEventListener('mouseleave', function() { tip.style.display='none'; });
        return wrap;
    }

    var globe = Globe()(container)
        .width(container.offsetWidth)
        .height(container.offsetHeight)
        .backgroundImageUrl('//unpkg.com/three-globe/example/img/night-sky.png')
        .globeImageUrl('//unpkg.com/three-globe/example/img/earth-day.jpg')
        .atmosphereAltitude(0.18)
        .htmlElementsData([])
        .htmlLat('lat')
        .htmlLng('lng')
        .htmlAltitude(0.01)
        .htmlElement(makeMarker);

    function refreshMarkers() {
        var alt = globe.pointOfView().altitude;
        globe.htmlElementsData(buildClusters(getRadius(alt)));
    }

    globe.pointOfView({ lat: avgLat, lng: avgLng, altitude: 1.8 }, 0);
    refreshMarkers();
    globe.controls().autoRotate = true;
    globe.controls().autoRotateSpeed = 0.4;
    globe.controls().enableZoom = true;
    globe.controls().addEventListener('end', refreshMarkers);

    window.addEventListener('resize', function() {
        globe.width(container.offsetWidth).height(container.offsetHeight);
    });
</script>
