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
</style>
