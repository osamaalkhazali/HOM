<style>
    /* Site-wide variables and common utilities */
    :root {
        --primary-color: #18458f;
        --primary-dark: #123660;
        --primary-light: #4e80bb;
        --gradient-1: linear-gradient(135deg, #18458f 0%, #667eea 100%);
        --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --gradient-4: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif !important;
        overflow-x: hidden;
    }

    /* App layout base (scoped to body.app so landing pages are unaffected) */
    body.app {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding-top: 80px;
    }

    main { position: relative; z-index: 1; }
    .content-wrapper { background: rgba(255,255,255,0.9); backdrop-filter: blur(8px); border-radius: 10px; padding: 1.25rem; margin: 1.25rem 0; box-shadow: 0 10px 20px rgba(0,0,0,0.06); }

    /* Navbar (shared) */
    .navbar-custom { background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); transition: all .3s ease; border-bottom: 1px solid rgba(0,0,0,0.05); }
    .navbar-scrolled { background: rgba(255,255,255,0.98); box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
    .nav-link { color: #6c757d !important; font-weight: 500; position: relative; transition: all .3s ease; }
    .nav-link:hover { color: var(--primary-color) !important; }

    /* Reusable visual utilities */
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .hover-lift {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .hover-lift:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .morph-btn {
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .morph-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .morph-btn:hover::before {
        left: 100%;
    }

    .pulse-btn {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(24, 69, 143, 0.7);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(24, 69, 143, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(24, 69, 143, 0);
        }
    }

    .logo-img {
        height: 65px;
        width: auto;
        object-fit: contain;
        transition: all 0.3s ease;
    }

    .logo-img:hover {
        transform: scale(1.05);
    }

    /* Shared background section pattern */
    .section-with-bg {
        background-image: linear-gradient(135deg, rgba(0, 0, 0, 0.2) 0%, rgba(24, 69, 143, 0.1) 100%),
            url('{{ asset('assets/images/hero.jpg') }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        position: relative;
        overflow: hidden;
    }

    .section-bg-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 252, 0.9) 50%, rgba(255, 255, 255, 0.85) 100%);
        z-index: 1;
    }

    .section-with-bg .container {
        position: relative;
        z-index: 2;
    }

    .section-with-bg h2,
    .section-with-bg h3,
    .section-with-bg h4 {
        position: relative;
        z-index: 3;
    }

    @media (max-width: 991px) {
        .section-with-bg {
            background-image: none !important;
            background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
            background-attachment: scroll;
        }

        .section-bg-overlay {
            background: none;
        }
    }

    /* Landing-only refinements (scoped to landing pages) */
    .landing .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #667eea 100%);
        border: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 15px 35px rgba(24, 69, 143, 0.3);
        position: relative;
        overflow: hidden;
    }

    .landing .btn-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, var(--primary-color) 100%);
        transform: translateY(-3px);
        box-shadow: 0 20px 45px rgba(24, 69, 143, 0.4);
    }

    .landing .section-title {
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        line-height: 1.2;
        color: var(--primary-color) !important;
        margin-bottom: 1.5rem;
    }

    /* Utilities */
    .btn-hom {
        border-radius: 10px !important;
    }

    .btn-gradient-1 {
        background: var(--gradient-1);
        border: 0;
        color: #fff;
    }

    .btn-gradient-1:hover {
        filter: brightness(0.95);
        color: #fff;
    }

    .btn-gradient-2 {
        background: var(--gradient-3);
        border: 0;
        color: #fff;
    }

    .btn-gradient-2:hover {
        filter: brightness(0.95);
        color: #fff;
    }

    .text-hom-primary {
        color: var(--primary-color) !important;
    }

    /* Dashboard theme (scoped) */
    .dashboard .card-10 { border-radius: 10px; }
    .dashboard .shadow-soft { box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .dashboard .shadow-hover:hover { box-shadow: 0 20px 45px rgba(0,0,0,0.12); transform: translateY(-4px); }

    .dashboard .kpi-card { border-radius: 10px; color: #fff; padding: 1rem; border: 0; position: relative; overflow: hidden; }
    .dashboard .kpi-1 { background: var(--primary-color); }
    .dashboard .kpi-2 { background: #f5576c; }
    .dashboard .kpi-3 { background: #00bcd4; }
    .dashboard .kpi-4 { background: #43e97b; }
    .dashboard .kpi-icon { width: 36px; height: 36px; border-radius: 10px; background: rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; }
    .dashboard .kpi-number { font-weight: 800; font-size: 1.5rem; line-height: 1; }
    .dashboard .kpi-label { font-size: .8rem; opacity:.95; }

    .dashboard .panel { background:#fff; border:1px solid rgba(0,0,0,0.06); border-radius:10px; overflow:hidden; }
    .dashboard .panel-header { padding: .9rem 1rem; border-bottom:1px solid rgba(0,0,0,0.06); background:#f9fbff; }
    .dashboard .panel-title { margin:0; font-weight:700; color:#1a202c; font-size:1rem; }
    .dashboard .panel-body { padding: 1rem; }

    .dashboard .list-item { padding: .9rem 1rem; border-bottom:1px solid rgba(0,0,0,0.06); }
    .dashboard .list-item:last-child { border-bottom: 0; }
    .dashboard .list-item:hover { background:#f8fafc; }
    @media (max-width: 576px) {
        .dashboard .list-item { padding: .85rem .75rem; }
        .dashboard .item-actions .btn { padding: .25rem .5rem; }
        .dashboard .item-status { margin-top: .25rem; }
    }

    .dashboard .status { padding: 0.25rem .6rem; border-radius: 10px; font-size: .75rem; font-weight:700; text-transform: capitalize; display:inline-flex; align-items:center; gap:.35rem; }
    .dashboard .status-pending { background:#fef3c7; color:#92400e; }
    .dashboard .status-reviewed { background:#dbeafe; color:#1e40af; }
    .dashboard .status-accepted { background:#d1fae5; color:#065f46; }
    .dashboard .status-rejected { background:#fee2e2; color:#991b1b; }
    .dashboard .status-shortlisted { background:#e0e7ff; color:#3730a3; }
    .dashboard .status-hired { background:#dcfce7; color:#166534; }

    .dashboard .quick-action { background:#fff; border:1px solid rgba(0,0,0,0.06); border-radius:10px; padding: .9rem; text-align:center; transition:.2s; text-decoration:none; color:inherit; display:block; }
    .dashboard .quick-action:hover { border-color: var(--primary-color); box-shadow: 0 8px 20px rgba(24,69,143,.15); transform: translateY(-2px); color:inherit; }
    .dashboard .quick-icon { width: 40px; height: 40px; border-radius:10px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color: var(--primary-color); margin: 0 auto .5rem; }

    /* Standard page header (app layout) */
    .page-header { background: var(--primary-color); color:#fff; padding: 1.5rem 0; margin-bottom: 1.25rem; border-radius: 0; position: relative; overflow:hidden; }
    .page-header .title { font-weight:800; margin:0; }
    .page-header .subtitle { opacity: .95; margin: .25rem 0 0; }
    .page-header .actions .btn { border-radius:10px; }

    /* Small generic helpers used by dashboard */
    .avatar-lg { width: 60px; height: 60px; border-radius: 12px; background: var(--primary-color); display:flex; align-items:center; justify-content:center; margin: 0 auto 1rem; }

    /* Profile card refinements */
    .profile-card { position: relative; }
    .verified-badge { position: absolute; top: 12px; right: 12px; border-radius: 10px; }
    .profile-avatar { box-shadow: 0 0 0 4px rgba(24,69,143,.08); }
    .profile-card .meta .label { font-size: .75rem; font-weight: 600; color: #64748b; letter-spacing: .2px; text-transform: uppercase; }
    .profile-card .meta .value { font-weight: 700; color:#0f172a; }

    /* App-scoped button colors to use primary brand instead of Bootstrap blue */
    body.app .btn { border-radius: 10px; }
    body.app .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    body.app .btn-primary:hover,
    body.app .btn-primary:focus {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }
    body.app .btn-outline-primary {
        color: var(--primary-color);
        border-color: var(--primary-color);
    }
    body.app .btn-outline-primary:hover,
    body.app .btn-outline-primary:focus {
        color: #fff;
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    body.app .btn.text-primary { color: var(--primary-color) !important; }
</style>
