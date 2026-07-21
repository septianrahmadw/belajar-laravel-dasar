<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @fonts

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    @else
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background-color: #f0f2f5; }
            :root { --fb-blue: #1877f2; --fb-blue-hover: #166fe5; --fb-green: #42b72a; --fb-bg: #f0f2f5; --fb-card: #ffffff; --fb-text: #050505; --fb-text-secondary: #65676b; --fb-border: #ced0d4; --fb-hover: #f2f2f2; --fb-icon: #65676b; }
            .fb-header { background: var(--fb-card); box-shadow: 0 2px 4px rgba(0,0,0,0.1); position: fixed; top: 0; left: 0; right: 0; z-index: 100; height: 56px; display: flex; align-items: center; justify-content: space-between; padding: 0 16px; }
            .fb-logo { color: var(--fb-blue); font-size: 28px; font-weight: 700; text-decoration: none; }
            .fb-search { background: #f0f2f5; border-radius: 50px; padding: 8px 16px; display: flex; align-items: center; gap: 8px; width: 240px; }
            .fb-search input { background: none; border: none; outline: none; font-size: 15px; color: var(--fb-text); width: 100%; }
            .fb-search svg { color: var(--fb-icon); flex-shrink: 0; }
            .fb-nav { display: flex; gap: 8px; }
            .fb-nav-item { padding: 8px 32px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; position: relative; color: var(--fb-icon); transition: background 0.2s; text-decoration: none; }
            .fb-nav-item:hover { background: var(--fb-hover); }
            .fb-nav-item.active { color: var(--fb-blue); }
            .fb-nav-item.active::after { content: ''; position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: var(--fb-blue); border-radius: 2px 2px 0 0; }
            .fb-user-menu { display: flex; align-items: center; gap: 8px; }
            .fb-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 16px; cursor: pointer; }
            .fb-main { display: flex; justify-content: center; gap: 24px; max-width: 1200px; margin: 80px auto 0; padding: 16px; }
            .fb-sidebar { width: 280px; position: sticky; top: 72px; height: fit-content; flex-shrink: 0; }
            .fb-sidebar-item { display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 8px; cursor: pointer; text-decoration: none; color: var(--fb-text); transition: background 0.2s; }
            .fb-sidebar-item:hover { background: var(--fb-hover); }
            .fb-sidebar-icon { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; }
            .fb-feed { flex: 1; max-width: 680px; }
            .fb-card { background: var(--fb-card); border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); margin-bottom: 16px; }
            .fb-create-post { padding: 16px; }
            .fb-create-post-top { display: flex; gap: 8px; align-items: center; margin-bottom: 12px; }
            .fb-create-post-input { flex: 1; background: #f0f2f5; border: none; border-radius: 50px; padding: 10px 16px; font-size: 17px; color: var(--fb-text-secondary); cursor: pointer; transition: background 0.2s; }
            .fb-create-post-input:hover { background: #e4e6e9; }
            .fb-create-post-actions { display: flex; justify-content: space-around; border-top: 1px solid var(--fb-border); padding-top: 12px; }
            .fb-create-post-action { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 8px; cursor: pointer; font-size: 15px; font-weight: 500; color: var(--fb-text-secondary); transition: background 0.2s; }
            .fb-create-post-action:hover { background: var(--fb-hover); }
            .fb-stories { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 8px; margin-bottom: 16px; }
            .fb-story { width: 112px; height: 200px; border-radius: 12px; position: relative; cursor: pointer; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); flex-shrink: 0; transition: transform 0.2s; }
            .fb-story:hover { transform: scale(1.02); }
            .fb-story-avatar { position: absolute; top: 8px; left: 8px; width: 40px; height: 40px; border-radius: 50%; border: 3px solid var(--fb-blue); background: #ddd; }
            .fb-story-name { position: absolute; bottom: 8px; left: 8px; right: 8px; color: white; font-size: 13px; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.6); }
            .fb-post { padding: 16px; }
            .fb-post-header { display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
            .fb-post-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; }
            .fb-post-author { font-weight: 600; font-size: 15px; color: var(--fb-text); }
            .fb-post-time { font-size: 13px; color: var(--fb-text-secondary); }
            .fb-post-text { font-size: 15px; line-height: 1.4; margin-bottom: 12px; color: var(--fb-text); }
            .fb-post-image { width: 100%; border-radius: 8px; margin-bottom: 12px; background: #e4e6e9; height: 300px; display: flex; align-items: center; justify-content: center; color: var(--fb-text-secondary); }
            .fb-post-stats { display: flex; justify-content: space-between; padding: 8px 0; color: var(--fb-text-secondary); font-size: 15px; }
            .fb-post-actions { display: flex; justify-content: space-around; border-top: 1px solid var(--fb-border); padding-top: 4px; }
            .fb-post-action { display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 15px; font-weight: 500; color: var(--fb-text-secondary); transition: background 0.2s; }
            .fb-post-action:hover { background: var(--fb-hover); }
            .fb-right-sidebar { width: 280px; position: sticky; top: 72px; height: fit-content; flex-shrink: 0; }
            .fb-right-title { font-size: 17px; font-weight: 600; color: var(--fb-text-secondary); padding: 8px 16px; }
            .fb-contact { display: flex; align-items: center; gap: 12px; padding: 8px; border-radius: 8px; cursor: pointer; transition: background 0.2s; }
            .fb-contact:hover { background: var(--fb-hover); }
            .fb-contact-avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px; }
            .fb-online-dot { width: 10px; height: 10px; background: var(--fb-green); border-radius: 50%; border: 2px solid white; position: absolute; bottom: 0; right: 0; }
            .fb-btn { background: var(--fb-blue); color: white; border: none; border-radius: 6px; padding: 8px 16px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
            .fb-btn:hover { background: var(--fb-blue-hover); }
            .fb-divider { height: 1px; background: var(--fb-border); margin: 8px 0; }
            .fb-ad { padding: 16px; }
            .fb-ad-label { font-size: 12px; color: var(--fb-text-secondary); margin-bottom: 8px; }
            @media (max-width: 1100px) { .fb-right-sidebar { display: none; } }
            @media (max-width: 900px) { .fb-sidebar { display: none; } }
            @media (max-width: 600px) { .fb-main { padding: 0; margin-top: 56px; } .fb-card { border-radius: 0; } .fb-search { width: 160px; } }
        </style>
    @endif
</head>
<body>
    <header class="fb-header">
        <div style="display:flex;align-items:center;gap:16px;">
            <a href="/" class="fb-logo">facebook</a>
            <div class="fb-search">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M10 2a8 8 0 105.293 14.707l4.5 4.5a1 1 0 001.414-1.414l-4.5-4.5A8 8 0 0010 2zm0 2a6 6 0 110 12 6 6 0 010-12z"/></svg>
                <input type="text" placeholder="Cari di Facebook">
            </div>
        </div>

        <div class="fb-nav">
            <a href="/" class="fb-nav-item active" title="Beranda">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M9.464 2.293a1 1 0 011.072 0l8 5A1 1 0 0119 8v11a2 2 0 01-2 2h-3a1 1 0 01-1-1v-4a1 1 0 00-1-1h-2a1 1 0 00-1 1v4a1 1 0 01-1 1H5a2 2 0 01-2-2V8a1 1 0 01.464-.707l8-5z"/></svg>
            </a>
            <a href="#" class="fb-nav-item" title="Watch">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm4.5 5.5l5 3-5 3v-6z"/></svg>
            </a>
            <a href="#" class="fb-nav-item" title="Marketplace">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M2 9a1 1 0 011-1h2l1.5-4.5A1 1 0 017.5 3h9a1 1 0 01.95.65L19 8h2a1 1 0 011 1v10a2 2 0 01-2 2H3a2 2 0 01-2-2V9z"/></svg>
            </a>
            <a href="#" class="fb-nav-item" title="Grup">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 0114 0H5zm7-9a5 5 0 015 5v1a5 5 0 01-10 0v-1a5 5 0 015-5z"/></svg>
            </a>
            <a href="#" class="fb-nav-item" title="Gaming">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M6 8a2 2 0 110-4 2 2 0 010 4zm0 2a4 4 0 100-8 4 4 0 000 8zm12-2a2 2 0 110-4 2 2 0 010 4zm0 2a4 4 0 100-8 4 4 0 000 8zM6 14a1 1 0 011 1v3h3a1 1 0 110 2H7v3a1 1 0 11-2 0v-3H2a1 1 0 110-2h3v-3a1 1 0 011-1zm8 0a1 1 0 011 1v2h2a1 1 0 110 2h-2v2a1 1 0 11-2 0v-2h-2a1 1 0 110-2h2v-2a1 1 0 011-1z"/></svg>
            </a>
        </div>

        <div class="fb-user-menu">
            <div class="fb-avatar">S</div>
            <button class="fb-btn">+ Buat</button>
        </div>
    </header>

    <div class="fb-main">
        <aside class="fb-sidebar">
            <a href="#" class="fb-sidebar-item">
                <div class="fb-avatar" style="width:36px;height:36px;font-size:14px;">S</div>
                <span style="font-weight:500;">Septian Rahmad W</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:#1877f2;color:white;border-radius:50%;"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 0114 0H5z"/></svg></div>
                <span>Teman</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#8B5CF6,#6366F1);color:white;border-radius:8px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4z"/></svg></div>
                <span>Grup</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:#F59E0B;color:white;border-radius:8px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M2 9a1 1 0 011-1h2l1.5-4.5A1 1 0 017.5 3h9a1 1 0 01.95.65L19 8h2a1 1 0 011 1v10a2 2 0 01-2 2H3a2 2 0 01-2-2V9z"/></svg></div>
                <span>Marketplace</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:#EF4444;color:white;border-radius:8px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v14a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm4.5 5.5l5 3-5 3v-6z"/></svg></div>
                <span>Watch</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:#10B981;color:white;border-radius:8px;"><svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg></div>
                <span>Penyimpanan</span>
            </a>
            <div class="fb-divider" style="margin:12px 0;"></div>
            <div style="padding:8px;font-size:17px;font-weight:600;color:var(--fb-text-secondary);">Shortcut Anda</div>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#F472B6,#EC4899);color:white;border-radius:8px;font-size:14px;">🎮</div>
                <span>Gaming Community</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#34D399,#10B981);color:white;border-radius:8px;font-size:14px;">📸</div>
                <span>Photography Club</span>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#60A5FA,#3B82F6);color:white;border-radius:8px;font-size:14px;">💻</div>
                <span>Web Dev Indonesia</span>
            </a>
        </aside>

        <section class="fb-feed">
            <div class="fb-card fb-create-post">
                <div class="fb-create-post-top">
                    <div class="fb-avatar" style="width:40px;height:40px;font-size:14px;">S</div>
                    <div class="fb-create-post-input">Apa yang Anda pikirkan, Septian?</div>
                </div>
                <div class="fb-create-post-actions">
                    <div class="fb-create-post-action">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#F3425F"><path d="M15 8v8H5V8h10m1-2H4a1 1 0 00-1 1v10a1 1 0 001 1h12a1 1 0 001-1v-3.5l4 4V7l-4 4V7a1 1 0 00-1-1z"/></svg>
                        <span>Video langsung</span>
                    </div>
                    <div class="fb-create-post-action">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#45BD62"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                        <span>Photo/video</span>
                    </div>
                    <div class="fb-create-post-action">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="#F7B928"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                        <span>Rasakan/aktifitas</span>
                    </div>
                </div>
            </div>

            <div class="fb-stories">
                <div class="fb-story" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                    <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M12 4v16m8-8H4" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/></svg>
                    </div>
                    <div class="fb-story-avatar" style="background:linear-gradient(135deg,#667eea,#764ba2);"></div>
                    <div class="fb-story-name">Buat Cerita</div>
                </div>
                <div class="fb-story" style="background:linear-gradient(135deg,#f093fb,#f5576c);">
                    <div class="fb-story-avatar" style="background:linear-gradient(135deg,#f093fb,#f5576c);"></div>
                    <div class="fb-story-name">Rina S.</div>
                </div>
                <div class="fb-story" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">
                    <div class="fb-story-avatar" style="background:linear-gradient(135deg,#4facfe,#00f2fe);"></div>
                    <div class="fb-story-name">Budi P.</div>
                </div>
                <div class="fb-story" style="background:linear-gradient(135deg,#43e97b,#38f9d7);">
                    <div class="fb-story-avatar" style="background:linear-gradient(135deg,#43e97b,#38f9d7);"></div>
                    <div class="fb-story-name">Andi K.</div>
                </div>
                <div class="fb-story" style="background:linear-gradient(135deg,#fa709a,#fee140);">
                    <div class="fb-story-avatar" style="background:linear-gradient(135deg,#fa709a,#fee140);"></div>
                    <div class="fb-story-name">Maya L.</div>
                </div>
            </div>

            <div class="fb-card fb-post">
                <div class="fb-post-header">
                    <div class="fb-post-avatar" style="background:linear-gradient(135deg,#f093fb,#f5576c);">R</div>
                    <div>
                        <div class="fb-post-author">Rina Susanti</div>
                        <div class="fb-post-time">2 jam · <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;"><circle cx="12" cy="12" r="10"/></svg></div>
                    </div>
                </div>
                <div class="fb-post-text">Hari ini sangat menyenangkan! Berangkat kerja sambil menikmati indahnya pagi di Jakarta. Semoga hari kalian juga menyenangkan ya! ☀️</div>
                <div class="fb-post-image" style="background:linear-gradient(135deg,#ffecd2,#fcb69f);">
                    <div style="text-align:center;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#c87" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        <div style="margin-top:8px;font-size:14px;">🌅 Pemandangan Pagi</div>
                    </div>
                </div>
                <div class="fb-post-stats">
                    <div style="display:flex;align-items:center;gap:4px;">
                        <div style="width:20px;height:20px;background:#1877f2;border-radius:50%;display:flex;align-items:center;justify-content:center;"><svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg></div>
                        <span>128</span>
                    </div>
                    <div>45 komentar · 12 bagikan</div>
                </div>
                <div class="fb-post-actions">
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg>
                        Suka
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Komentar
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/></svg>
                        Bagikan
                    </div>
                </div>
            </div>

            <div class="fb-card fb-post">
                <div class="fb-post-header">
                    <div class="fb-post-avatar" style="background:linear-gradient(135deg,#667eea,#764ba2);">B</div>
                    <div>
                        <div class="fb-post-author">Budi Pratama</div>
                        <div class="fb-post-time">5 jam · <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;"><circle cx="12" cy="12" r="10"/></svg></div>
                    </div>
                </div>
                <div class="fb-post-text">Baru saja selesai workshop React.js di kantor! Banyak sekali ilmu baru yang didapat. Terima kasih semua yang sudah hadir! 🚀💻</div>
                <div class="fb-post-image" style="background:linear-gradient(135deg,#a8edea,#fed6e3);">
                    <div style="text-align:center;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#867" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                        <div style="margin-top:8px;font-size:14px;">💻 Workshop React.js</div>
                    </div>
                </div>
                <div class="fb-post-stats">
                    <div style="display:flex;align-items:center;gap:4px;">
                        <div style="width:20px;height:20px;background:#1877f2;border-radius:50%;display:flex;align-items:center;justify-content:center;"><svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg></div>
                        <span>256</span>
                    </div>
                    <div>72 komentar · 34 bagikan</div>
                </div>
                <div class="fb-post-actions">
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg>
                        Suka
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Komentar
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/></svg>
                        Bagikan
                    </div>
                </div>
            </div>

            <div class="fb-card fb-post">
                <div class="fb-post-header">
                    <div class="fb-post-avatar" style="background:linear-gradient(135deg,#43e97b,#38f9d7);color:#333;">A</div>
                    <div>
                        <div class="fb-post-author">Andi Kurniawan</div>
                        <div class="fb-post-time">8 jam · <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor" style="vertical-align:middle;"><circle cx="12" cy="12" r="10"/></svg></div>
                    </div>
                </div>
                <div class="fb-post-text">Tips untuk developer pemula: Jangan takut untuk googling! Bahkan senior developer pun masih sering googling. Yang penting adalah kemauan untuk belajar dan terus mencoba. 💪</div>
                <div class="fb-post-stats">
                    <div style="display:flex;align-items:center;gap:4px;">
                        <div style="width:20px;height:20px;background:#1877f2;border-radius:50%;display:flex;align-items:center;justify-content:center;"><svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg></div>
                        <span>89</span>
                    </div>
                    <div>23 komentar · 8 bagikan</div>
                </div>
                <div class="fb-post-actions">
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M14 9V5a3 3 0 00-6 0v1H5a2 2 0 00-2 2v8a2 2 0 002 2h14a2 2 0 002-2v-8a2 2 0 00-2-2h-3z"/></svg>
                        Suka
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                        Komentar
                    </div>
                    <div class="fb-post-action">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2z"/></svg>
                        Bagikan
                    </div>
                </div>
            </div>
        </section>

        <aside class="fb-right-sidebar">
            <div class="fb-right-title">Kontak</div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#f093fb,#f5576c);">R</div>
                    <div class="fb-online-dot"></div>
                </div>
                <span>Rina Susanti</span>
            </div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#667eea,#764ba2);">B</div>
                    <div class="fb-online-dot"></div>
                </div>
                <span>Budi Pratama</span>
            </div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#43e97b,#38f9d7);color:#333;">A</div>
                    <div class="fb-online-dot"></div>
                </div>
                <span>Andi Kurniawan</span>
            </div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#fa709a,#fee140);">M</div>
                </div>
                <span>Maya Lestari</span>
            </div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#4facfe,#00f2fe);">D</div>
                    <div class="fb-online-dot"></div>
                </div>
                <span>Dimas Aditya</span>
            </div>
            <div class="fb-contact">
                <div style="position:relative;">
                    <div class="fb-contact-avatar" style="background:linear-gradient(135deg,#a8edea,#fed6e3);color:#555;">F</div>
                </div>
                <span>Fajar Nugroho</span>
            </div>
            <div class="fb-divider"></div>
            <div class="fb-right-title" style="margin-top:8px;">Grup yang Direkomendasikan</div>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;border-radius:8px;font-size:14px;">💻</div>
                <div>
                    <div style="font-weight:500;font-size:14px;">Laravel Indonesia</div>
                    <div style="font-size:12px;color:var(--fb-text-secondary);">12rb anggota</div>
                </div>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);color:white;border-radius:8px;font-size:14px;">🎨</div>
                <div>
                    <div style="font-weight:500;font-size:14px;">UI/UX Designer ID</div>
                    <div style="font-size:12px;color:var(--fb-text-secondary);">8.5rb anggota</div>
                </div>
            </a>
            <a href="#" class="fb-sidebar-item">
                <div class="fb-sidebar-icon" style="background:linear-gradient(135deg,#43e97b,#38f9d7);color:#333;border-radius:8px;font-size:14px;">🚀</div>
                <div>
                    <div style="font-weight:500;font-size:14px;">Startup Founders ID</div>
                    <div style="font-size:12px;color:var(--fb-text-secondary);">5.2rb anggota</div>
                </div>
            </a>
        </aside>
    </div>
</body>
</html>
