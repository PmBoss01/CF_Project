<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>About — Prince Mpem Boateng</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/48e15f0c7c.js" crossorigin="anonymous"></script>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --red: #ff004f;
      --red-dim: rgba(255,0,79,0.12);
      --red-glow: rgba(255,0,79,0.35);
      --dark: #0e0b0d;
      --card: #161114;
      --border: rgba(255,255,255,0.07);
      --text: #f0ecee;
      --muted: #8a8088;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--dark);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* ── Background grain + blobs ── */
    body::before {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      background:
        radial-gradient(ellipse at 10% 30%, rgba(255,0,79,0.12) 0%, transparent 55%),
        radial-gradient(ellipse at 90% 70%, rgba(255,0,79,0.07) 0%, transparent 50%);
      pointer-events: none;
    }

    /* ── Noise texture overlay ── */
    body::after {
      content: '';
      position: fixed; inset: 0; z-index: 0;
      opacity: 0.03;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
      pointer-events: none;
    }

    .page {
      position: relative; z-index: 1;
      max-width: 1100px;
      margin: 0 auto;
      padding: 60px 24px 80px;
    }

    /* ── Top badge ── */
    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: var(--red-dim);
      border: 1px solid rgba(255,0,79,0.25);
      color: var(--red);
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      padding: 6px 14px;
      border-radius: 999px;
      margin-bottom: 56px;
      animation: fadeDown 0.6s ease both;
    }

    .eyebrow span { width: 6px; height: 6px; border-radius: 50%; background: var(--red); display: inline-block; animation: pulse 1.6s infinite; }

    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.4;transform:scale(0.7)} }

    /* ── Hero split ── */
    .hero {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 64px;
      align-items: center;
      animation: fadeUp 0.7s 0.1s ease both;
    }

    /* ── Photo side ── */
    .photo-side { position: relative; }

    .photo-frame {
      position: relative;
      display: inline-block;
      width: 100%;
    }

    .photo-frame::before {
      content: '';
      position: absolute;
      inset: -2px;
      border-radius: 24px;
      background: linear-gradient(135deg, var(--red), transparent 60%);
      z-index: 0;
    }

    .photo-frame img {
      position: relative; z-index: 1;
      width: 100%;
      aspect-ratio: 4/5;
      object-fit: cover;
      object-position: top;
      border-radius: 22px;
      display: block;
      filter: grayscale(15%);
    }

    /* Floating stat cards */
    .stat-card {
      position: absolute;
      background: rgba(22,17,20,0.85);
      backdrop-filter: blur(12px);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 12px 18px;
      display: flex;
      align-items: center;
      gap: 12px;
      z-index: 2;
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      animation: floatCard 4s ease-in-out infinite;
    }

    .stat-card.c1 { bottom: -20px; left: -20px; animation-delay: 0s; }
    .stat-card.c2 { top: 30px; right: -24px; animation-delay: 2s; }

    @keyframes floatCard {
      0%,100%{ transform: translateY(0); }
      50%{ transform: translateY(-8px); }
    }

    .stat-icon {
      width: 38px; height: 38px;
      background: var(--red-dim);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      color: var(--red);
      font-size: 1rem;
    }

    .stat-info .num {
      font-weight: 700;
      font-size: 1.1rem;
      color: #fff;
      line-height: 1;
    }

    .stat-info .lbl {
      font-size: 0.7rem;
      color: var(--muted);
      margin-top: 2px;
    }

    /* ── Text side ── */
    .text-side { }

    .text-side h1 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.6rem, 5vw, 3.8rem);
      font-weight: 900;
      line-height: 1.08;
      letter-spacing: -0.03em;
      color: #fff;
      margin-bottom: 6px;
    }

    .text-side h1 em {
      font-style: italic;
      color: var(--red);
    }

    .role-line {
      font-size: 0.8rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--muted);
      margin-bottom: 28px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .role-line::before {
      content: '';
      width: 28px; height: 1px;
      background: var(--red);
    }

    .bio {
      font-size: 1rem;
      line-height: 1.8;
      color: rgba(240,236,238,0.75);
      margin-bottom: 36px;
    }

    .bio strong { color: var(--red); font-weight: 600; }

    /* ── Skills chips ── */
    .chips {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 40px;
    }

    .chip {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 6px 16px;
      font-size: 0.78rem;
      font-weight: 500;
      color: var(--muted);
      transition: all 0.2s;
    }

    .chip:hover {
      border-color: var(--red);
      color: var(--red);
      background: var(--red-dim);
    }

    /* ── CTA button ── */
    .cta-row { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }

    .btn-primary {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: var(--red);
      color: white;
      text-decoration: none;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 14px 28px;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      box-shadow: 0 0 30px var(--red-glow);
      transition: transform 0.2s, box-shadow 0.2s, background 0.2s;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 50px var(--red-glow);
      background: #e6003f;
      color: white;
      text-decoration: none;
    }

    .btn-secondary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: transparent;
      color: var(--text);
      text-decoration: none;
      font-family: 'DM Sans', sans-serif;
      font-weight: 500;
      font-size: 0.9rem;
      padding: 13px 24px;
      border-radius: 999px;
      border: 1px solid var(--border);
      transition: border-color 0.2s, color 0.2s;
    }

    .btn-secondary:hover {
      border-color: var(--red);
      color: var(--red);
      text-decoration: none;
    }

    /* ── Divider ── */
    .divider {
      border: none;
      border-top: 1px solid var(--border);
      margin: 70px 0;
      animation: fadeUp 0.7s 0.3s ease both;
    }

    /* ── Services section ── */
    .section-label {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--red);
      margin-bottom: 14px;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(1.8rem, 3.5vw, 2.6rem);
      font-weight: 700;
      color: #fff;
      margin-bottom: 48px;
      line-height: 1.15;
    }

    .services {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      animation: fadeUp 0.7s 0.4s ease both;
    }

    .service-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 28px 24px;
      transition: border-color 0.25s, transform 0.25s, box-shadow 0.25s;
      position: relative;
      overflow: hidden;
    }

    .service-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, var(--red-dim), transparent);
      opacity: 0;
      transition: opacity 0.3s;
    }

    .service-card:hover {
      border-color: rgba(255,0,79,0.4);
      transform: translateY(-6px);
      box-shadow: 0 20px 50px rgba(0,0,0,0.4), 0 0 30px rgba(255,0,79,0.08);
    }

    .service-card:hover::before { opacity: 1; }

    .svc-icon {
      width: 48px; height: 48px;
      background: var(--red-dim);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem;
      color: var(--red);
      margin-bottom: 18px;
      position: relative; z-index: 1;
    }

    .service-card h3 {
      font-size: 1rem;
      font-weight: 600;
      color: #fff;
      margin-bottom: 10px;
      position: relative; z-index: 1;
    }

    .service-card p {
      font-size: 0.83rem;
      line-height: 1.7;
      color: var(--muted);
      position: relative; z-index: 1;
    }

    /* ── Stats row ── */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1px;
      background: var(--border);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
      margin-top: 60px;
      animation: fadeUp 0.7s 0.5s ease both;
    }

    .stat-block {
      background: var(--card);
      padding: 32px 28px;
      text-align: center;
    }

    .stat-block .big {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 900;
      color: var(--red);
      line-height: 1;
      margin-bottom: 8px;
    }

    .stat-block .desc {
      font-size: 0.8rem;
      color: var(--muted);
      font-weight: 500;
    }

    /* ── Footer strip ── */
    .footer {
      margin-top: 70px;
      text-align: center;
      font-size: 0.78rem;
      color: var(--muted);
      animation: fadeUp 0.7s 0.6s ease both;
    }

    .footer strong { color: var(--red); }

    /* ── Animations ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeDown {
      from { opacity: 0; transform: translateY(-12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .hero { grid-template-columns: 1fr; gap: 40px; }
      .stat-card.c2 { right: -10px; }
      .services { grid-template-columns: 1fr; }
      .stats-row { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="page">

  <!-- Badge -->
  <div class="eyebrow"><span></span> Pm Tech Solutions — Portfolio</div>

  <!-- Hero -->
  <div class="hero">

    <!-- Photo -->
    <div class="photo-side">
      <div class="photo-frame">
        <img src="https://raw.githubusercontent.com/PmBoss01/CF_Project/main/CEO.png" alt="Prince Mpem Boateng" />
      </div>

      <!-- Floating cards -->
      <div class="stat-card c1">
        <div class="stat-icon"><i class="fa fa-code"></i></div>
        <div class="stat-info">
          <div class="num">Full Stack</div>
          <div class="lbl">Developer</div>
        </div>
      </div>

      <div class="stat-card c2">
        <div class="stat-icon"><i class="fa fa-paint-brush"></i></div>
        <div class="stat-info">
          <div class="num">UI / UX</div>
          <div class="lbl">Designer</div>
        </div>
      </div>
    </div>

    <!-- Text -->
    <div class="text-side">
      <h1>Prince Mpem<br><em>Boateng</em></h1>
      <div class="role-line">Developer & Designer · Pm Tech Solutions</div>

      <p class="bio">
        I build digital experiences that are fast, elegant, and purposeful. As the
        founder of <strong>Pm Tech Solutions</strong>, I specialise in full-stack web
        development and UI/UX design — turning complex ideas into clean, intuitive
        products.<br><br>
        The <strong>Pm E-Voting System</strong> is one of my flagship builds — a secure
        platform enabling voters to cast ballots and view live election results entirely
        online. Got a project in mind? Let's make it real.
      </p>

      <div class="chips">
        <span class="chip">PHP</span>
        <span class="chip">JavaScript</span>
        <span class="chip">MySQL</span>
        <span class="chip">UI/UX Design</span>
        <span class="chip">Bootstrap</span>
        <span class="chip">Figma</span>
        <span class="chip">React</span>
        <span class="chip">Web Security</span>
      </div>

      <div class="cta-row">
        <a href="https://wa.me/0555710380" target="_blank" class="btn-primary">
          <i class="fa fa-whatsapp"></i> Let's Chat
        </a>
        <a href="#services" class="btn-secondary">
          <i class="fa fa-briefcase"></i> My Services
        </a>
      </div>
    </div>

  </div><!-- /hero -->

  <hr class="divider" />

  <!-- Services -->
  <div id="services">
    <div class="section-label">What I do</div>
    <div class="section-title">Services I Offer</div>

    <div class="services">

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-globe"></i></div>
        <h3>Web Development</h3>
        <p>Custom websites and web applications built from the ground up — fast, responsive, and secure.</p>
      </div>

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-mobile"></i></div>
        <h3>UI / UX Design</h3>
        <p>Pixel-perfect interfaces designed around the user — wireframes, prototypes, and full design systems.</p>
      </div>

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-check-square-o"></i></div>
        <h3>E-Voting Systems</h3>
        <p>Secure, scalable online voting platforms with real-time result dashboards and audit trails.</p>
      </div>

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-database"></i></div>
        <h3>Database Design</h3>
        <p>Well-structured relational databases optimised for performance, integrity, and scalability.</p>
      </div>

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-lock"></i></div>
        <h3>Web Security</h3>
        <p>Security audits, input sanitisation, authentication systems, and protection against common vulnerabilities.</p>
      </div>

      <div class="service-card">
        <div class="svc-icon"><i class="fa fa-life-ring"></i></div>
        <h3>Maintenance & Support</h3>
        <p>Ongoing technical support, bug fixes, and feature updates to keep your software running smoothly.</p>
      </div>

    </div>
  </div>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-block">
      <div class="big">3+</div>
      <div class="desc">Years of Experience</div>
    </div>
    <div class="stat-block">
      <div class="big">20+</div>
      <div class="desc">Projects Delivered</div>
    </div>
    <div class="stat-block">
      <div class="big">100%</div>
      <div class="desc">Client Satisfaction</div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>© <?php echo date('Y'); ?> <strong>Pm Tech Solutions</strong> — Crafted with passion by Prince Mpem Boateng</p>
  </div>

</div><!-- /page -->

</body>
</html>