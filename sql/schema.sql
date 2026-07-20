-- =============================================================================
--  Demo Contracting Ltd — schema + seed content
--  Template: "Homi" (Eightheme) home-improvement Elementor kit
--  MySQL 5.7+/8.0, utf8mb4. Import once to create + seed the database.
--  NOTE: no admin password is set here. Visit /admin/setup once after import.
-- =============================================================================

SET NAMES utf8mb4;
SET foreign_key_checks = 0;

-- ---------------------------------------------------------------------------
--  admins  (password set ONLY via /admin/setup — never stored in SQL)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username      VARCHAR(64)  NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_admin_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  settings  (drives the auto-generated settings form)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS settings (
    id            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    setting_key   VARCHAR(64)  NOT NULL,
    setting_value TEXT         NULL,
    label         VARCHAR(128) NOT NULL DEFAULT '',
    input_type    ENUM('text','textarea','email','tel','url','toggle') NOT NULL DEFAULT 'text',
    sort_order    INT          NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY uq_setting_key (setting_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  content_blocks  (one-off page sections)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS content_blocks (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    block_key  VARCHAR(64)  NOT NULL,
    label      VARCHAR(128) NOT NULL DEFAULT '',
    eyebrow    VARCHAR(191) NULL,
    heading    TEXT         NULL,
    body       TEXT         NULL,
    image      VARCHAR(255) NULL,
    image2     VARCHAR(255) NULL,
    extra      TEXT         NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_block_key (block_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  items  (all repeating cards, grouped by `section`)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS items (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    section    VARCHAR(48)  NOT NULL,
    title      VARCHAR(191) NULL,
    subtitle   VARCHAR(191) NULL,
    body       TEXT         NULL,
    image      VARCHAR(255) NULL,
    icon       VARCHAR(128) NULL,
    value      VARCHAR(128) NULL,
    url        VARCHAR(255) NULL,
    sort_order INT          NOT NULL DEFAULT 0,
    is_active  TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    KEY idx_section_sort (section, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  posts  (blog)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS posts (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug         VARCHAR(191) NOT NULL,
    title        VARCHAR(191) NOT NULL,
    excerpt      TEXT         NULL,
    body         MEDIUMTEXT   NULL,
    image        VARCHAR(255) NULL,
    author       VARCHAR(128) NULL,
    is_published TINYINT(1)   NOT NULL DEFAULT 1,
    published_at DATETIME     NULL,
    created_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_post_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  quotes  (form submissions)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS quotes (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name       VARCHAR(128) NOT NULL,
    email      VARCHAR(191) NOT NULL,
    phone      VARCHAR(64)  NULL,
    service    VARCHAR(191) NULL,
    message    TEXT         NULL,
    source     VARCHAR(48)  NULL,
    is_read    TINYINT(1)   NOT NULL DEFAULT 0,
    created_at DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_quote_read (is_read, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
--  sections  (homepage order + visibility)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS sections (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    section_key VARCHAR(48)  NOT NULL,
    label       VARCHAR(128) NOT NULL DEFAULT '',
    sort_order  INT          NOT NULL DEFAULT 0,
    is_enabled  TINYINT(1)   NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY uq_section_key (section_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET foreign_key_checks = 1;

-- =============================================================================
--  SEED DATA
-- =============================================================================

-- ---- settings -------------------------------------------------------------
INSERT INTO settings (setting_key, setting_value, label, input_type, sort_order) VALUES
('site_name',        'Demo Contracting Ltd', 'Business name', 'text', 10),
('tagline',          'Contracting & Home Improvement', 'Tagline', 'text', 20),
('logo',             'assets/img/logo.svg', 'Logo image path', 'text', 30),
('meta_description', 'Demo Contracting Ltd delivers expert renovations, additions, roofing and remodeling across Saskatchewan. Quality craftsmanship, on time and on budget.', 'Default meta description', 'textarea', 40),
('og_image',         'assets/img/hero-home.jpg', 'Social share image', 'text', 50),
('contact_phone',    '306-555-0142', 'Phone', 'tel', 60),
('contact_email',    'info@homedemo.prairiewebdesign.ca', 'Contact email', 'email', 70),
('contact_address',  '100 Centennial Drive', 'Street address', 'text', 80),
('contact_city',     'Martensville', 'City', 'text', 90),
('contact_region',   'SK', 'Province', 'text', 100),
('contact_postal',   'S0K 2T0', 'Postal code', 'text', 110),
('contact_country',  'CA', 'Country code', 'text', 120),
('contact_hours',    'Mon-Fri 07:30-17:30', 'Opening hours', 'text', 130),
('hero_video_url',   'https://www.youtube.com/embed/VhBl3dHT5SY', 'Hero video URL', 'url', 140),
('footer_about',     'Demo Contracting Ltd is a full-service contracting company building, renovating and improving homes across the prairies since 2009.', 'Footer about text', 'textarea', 150),
('footer_note',      'This is a demo website built by Prairie Web Design.', 'Footer note', 'text', 160),
('social_facebook',  '#', 'Facebook URL', 'url', 170),
('social_instagram', '#', 'Instagram URL', 'url', 180),
('social_linkedin',  '#', 'LinkedIn URL', 'url', 190),
('show_prices',      '1', 'Show pricing section prices', 'toggle', 200);

-- ---- content_blocks -------------------------------------------------------
INSERT INTO content_blocks (block_key, label, eyebrow, heading, body, image, image2, extra) VALUES
('hero', 'Homepage hero', 'Trusted Local Contractors',
 'Build, Renovate &amp; <span><span>Improve Your Home</span></span> With Demo Contracting.',
 'From full renovations to additions, roofing and finishing carpentry — our crews deliver dependable craftsmanship on time and on budget.',
 'assets/img/hero-home.jpg', 'assets/img/hero-2.jpg',
 '450+ Projects Completed'),
('about', 'About section', 'Who We Are',
 'Built on Craftsmanship, Trust and a Commitment to <span><span>Quality Work.</span></span>',
 'For over 15 years Demo Contracting Ltd has helped Saskatchewan homeowners bring their projects to life. Licensed, insured, and proud of every finished job.',
 'assets/img/about-1.jpg', 'assets/img/about-2.jpg',
 'Over 15 Years of Contracting Experience'),
('cta_banner', 'Mid-page CTA banner', 'Ready When You Are',
 'Ready to Start Your Next Project With a <span><span>Contractor You Can Trust?</span></span>',
 'Get a free, no-obligation estimate. Tell us about your project and we will get back to you within one business day.',
 'assets/img/cta-bg.jpg', '', 'Get a Free Estimate'),
('contact_cta', 'Contact CTA / quote form', 'Get In Touch',
 'Let&#8217;s Discuss How We Can <span><span>Improve Your Space</span></span> and Stay Within Budget.',
 'Fill out the form and our team will reach out to schedule your consultation.',
 'assets/img/contact.jpg', '', ''),
-- section-heading blocks (eyebrow + heading drive each homepage section title)
('services', 'Services section heading', 'What We Do',
 'Explore Our Full Range of Professional <span><span>Contracting &amp; Remodeling</span></span> Services.',
 'From first framing to final finish, our crews handle every stage of your project under one roof.', '', '', ''),
('why_choose', 'Why-Choose-Us heading', 'Why Choose Us',
 'Discover the Reasons Homeowners Across the Prairies <span><span>Continue to Trust Us.</span></span>',
 'We combine skilled trades, honest pricing and clear communication on every job.', 'assets/img/about-1.jpg', '', ''),
('features', 'Features section heading', 'Key Features',
 'Essential Features That Make <span><span>Our Service Reliable.</span></span>',
 'The details that keep your project on track and stress-free.', 'assets/img/service-interior.jpg', '', ''),
('testimonials', 'Testimonials heading', 'Client Reviews',
 'Hear From <span><span>Homeowners</span></span> Who Trusted Us.',
 'Real feedback from real projects across central Saskatchewan.', 'assets/img/hero-home.jpg', '', ''),
('process', 'Process section heading', 'How It Works',
 'A Simple and Transparent <span><span>Process</span></span> to Deliver Results.',
 'Three clear steps from first call to finished project.', '', '', ''),
('pricing', 'Pricing section heading', 'Choose a Package',
 'Flexible Packages That Fit Your <span><span>Budget and Project Size.</span></span>',
 'Straightforward pricing with no hidden surprises.', '', '', ''),
('team', 'Team section heading', 'Meet the Team',
 'The Skilled People Behind Every Successful <span><span>Home Improvement Project.</span></span>',
 'Experienced tradespeople who treat your home like their own.', '', '', ''),
('faq', 'FAQ section heading', 'Got Questions',
 'Frequently Asked <span><span>Questions</span></span> About Our Work.',
 'Answers to the things homeowners ask us most.', '', '', ''),
('blog', 'Blog section heading', 'From the Blog',
 'Tips, Guides and News to Help You <span><span>Plan Your Project.</span></span>',
 'Insights from our crew on renovations, materials and maintenance.', '', '', '');

-- ---- items: hero_tags (hero service pills) --------------------------------
INSERT INTO items (section, title, sort_order) VALUES
('hero_tags', 'Renovations', 10),
('hero_tags', 'Home Additions', 20),
('hero_tags', 'Roofing &amp; Siding', 30),
('hero_tags', 'Kitchens &amp; Baths', 40);

-- ---- items: about_points --------------------------------------------------
INSERT INTO items (section, title, body, icon, sort_order) VALUES
('about_points', 'Over 15 Years of Renovation &amp; Build Expertise', 'Seasoned crews who have handled hundreds of prairie home projects.', 'fas fa-check', 10),
('about_points', 'Licensed, Insured &amp; Fully Warrantied Work', 'Every job is backed by workmanship you can count on.', 'fas fa-check', 20);

-- ---- items: counters ------------------------------------------------------
INSERT INTO items (section, title, value, subtitle, sort_order) VALUES
('counters', 'Projects Completed', '450', '+', 10),
('counters', 'Years of Experience', '15', '+', 20),
('counters', 'Satisfaction Rate',   '98', '%', 30),
('counters', 'Skilled Team Members', '24', '+', 40);

-- ---- items: services ------------------------------------------------------
INSERT INTO items (section, title, subtitle, body, image, icon, sort_order) VALUES
('services', 'Kitchen &amp; Bath Remodeling', 'Renovation', 'Full kitchen and bathroom renovations — cabinetry, tile, plumbing and finishes that transform the rooms you use most.', 'assets/img/service-kitchen.jpg', 'fas fa-sink', 10),
('services', 'Home Additions &amp; Framing', 'Construction', 'Add space and value with expertly engineered additions, garages and structural framing built to code.', 'assets/img/service-addition.jpg', 'fas fa-drafting-compass', 20),
('services', 'Interior Renovations &amp; Drywall', 'Interior', 'Open up floor plans, refresh interiors, and get flawless drywall, taping and paint from start to finish.', 'assets/img/service-interior.jpg', 'fas fa-paint-roller', 30),
('services', 'Roofing &amp; Siding', 'Exterior', 'Protect your home with quality roofing, soffit, fascia and siding installations that stand up to prairie weather.', 'assets/img/service-roofing.jpg', 'fas fa-home', 40),
('services', 'Decks, Fences &amp; Exteriors', 'Outdoor', 'Custom decks, fences and outdoor living spaces designed and built to last for seasons of enjoyment.', 'assets/img/service-deck.jpg', 'fas fa-tree', 50),
('services', 'Electrical &amp; Smart-Home Upgrades', 'Systems', 'Modern wiring, lighting, panel upgrades and smart-home installations handled by trusted trade partners.', 'assets/img/service-electrical.jpg', 'fas fa-bolt', 60);

-- ---- items: why_choose ----------------------------------------------------
INSERT INTO items (section, title, body, icon, sort_order) VALUES
('why_choose', 'On Time, On Budget', 'Clear timelines and transparent quotes — no surprises, no runaround.', 'fas fa-clock', 10),
('why_choose', 'Skilled, Vetted Crews', 'Experienced tradespeople who treat your home with care and respect.', 'fas fa-hard-hat', 20),
('why_choose', 'Quality Guaranteed', 'We stand behind our workmanship with a written warranty on every project.', 'fas fa-shield-alt', 30);

-- ---- items: features ------------------------------------------------------
INSERT INTO items (section, title, body, icon, sort_order) VALUES
('features', 'Free On-Site Estimates', 'We come to you, assess the work, and provide a detailed written quote at no cost.', 'fas fa-clipboard-list', 10),
('features', 'Dedicated Project Manager', 'One point of contact keeps your project organized and communication easy.', 'fas fa-user-tie', 20),
('features', 'Clean, Respectful Job Sites', 'We protect your home and leave every site tidy at the end of each day.', 'fas fa-broom', 30);

-- ---- items: process -------------------------------------------------------
INSERT INTO items (section, title, body, value, sort_order) VALUES
('process', 'Consultation &amp; Estimate', 'We meet, review your goals, and provide a clear written quote.', '01', 10),
('process', 'Design &amp; Planning', 'We finalize materials, timelines and permits before work begins.', '02', 20),
('process', 'Build &amp; Deliver', 'Our crews get to work and hand over a finished space you will love.', '03', 30);

-- ---- items: testimonials --------------------------------------------------
INSERT INTO items (section, title, subtitle, body, image, value, sort_order) VALUES
('testimonials', 'Karen M.', 'Warman, SK', 'Demo Contracting rebuilt our kitchen and it exceeded every expectation. Professional, tidy, and right on schedule.', 'assets/img/team-1.jpg', '5', 10),
('testimonials', 'Dave R.', 'Saskatoon, SK', 'They framed and finished our garage addition flawlessly. The project manager kept us informed the whole way through.', 'assets/img/team-2.jpg', '5', 20),
('testimonials', 'Priya S.', 'Martensville, SK', 'New roof and siding done in a week, no mess left behind. Honest pricing and great craftsmanship.', 'assets/img/team-3.jpg', '5', 30);

-- ---- items: pricing -------------------------------------------------------
--  value = price, subtitle = period, body = features (one per line), icon 'popular' flags the highlighted plan
INSERT INTO items (section, title, subtitle, body, value, icon, sort_order) VALUES
('pricing', 'Handyman', 'per visit', 'Half-day of work\nMinor repairs &amp; fixes\nOne tradesperson\nMaterials billed separately\nSame-week scheduling', '299', '', 10),
('pricing', 'Renovation', 'per project', 'Dedicated project manager\nFull interior renovation\nDesign &amp; material guidance\nWritten workmanship warranty\nWeekly progress updates', '4,900', 'popular', 20),
('pricing', 'Full Build', 'custom quote', 'Additions &amp; new builds\nEngineered &amp; permitted\nComplete project management\nExtended structural warranty\nFixed-price contract', 'Custom', '', 30);

-- ---- items: team ----------------------------------------------------------
INSERT INTO items (section, title, subtitle, image, url, sort_order) VALUES
('team', 'Mark Delaney', 'Founder &amp; Lead Contractor', 'assets/img/team-1.jpg', '#', 10),
('team', 'Sara Whitfield', 'Project Manager', 'assets/img/team-2.jpg', '#', 20),
('team', 'Tyler Brooks', 'Site Foreman', 'assets/img/team-3.jpg', '#', 30);

-- ---- items: faq -----------------------------------------------------------
INSERT INTO items (section, title, body, sort_order) VALUES
('faq', 'Do you offer free estimates?', 'Yes — every project starts with a free on-site consultation and a detailed written estimate at no cost to you.', 10),
('faq', 'Are you licensed and insured?', 'Absolutely. Demo Contracting Ltd is fully licensed and carries liability and workers'' coverage on every job.', 20),
('faq', 'How long will my project take?', 'It depends on scope. We provide a realistic timeline with your quote and keep you updated throughout the build.', 30),
('faq', 'Do you handle permits?', 'Yes. For additions and structural work we manage the permit and inspection process on your behalf.', 40),
('faq', 'What areas do you serve?', 'We serve Martensville, Warman, Saskatoon and surrounding communities across central Saskatchewan.', 50),
('faq', 'Do you provide a warranty?', 'Every project includes a written workmanship warranty, with extended coverage on structural builds.', 60);

-- ---- items: projects (for the Projects page) ------------------------------
INSERT INTO items (section, title, subtitle, body, image, sort_order) VALUES
('projects', 'Modern Kitchen Remodel', 'Renovation', 'A full gut-and-rebuild kitchen renovation with custom cabinetry and quartz counters in Warman.', 'assets/img/service-kitchen.jpg', 10),
('projects', 'Two-Car Garage Addition', 'Construction', 'Engineered and permitted attached garage with a finished bonus room above, built in Saskatoon.', 'assets/img/service-addition.jpg', 20),
('projects', 'Roof &amp; Siding Replacement', 'Exterior', 'Complete tear-off, new architectural shingles and premium siding for a Martensville family home.', 'assets/img/service-roofing.jpg', 30),
('projects', 'Backyard Cedar Deck', 'Outdoor', 'A multi-level cedar deck with built-in benches and privacy screening for prairie summers.', 'assets/img/service-deck.jpg', 40);

-- ---- posts ----------------------------------------------------------------
INSERT INTO posts (slug, title, excerpt, body, image, author, is_published, published_at) VALUES
('planning-a-home-renovation', 'Planning a Home Renovation: A Contractor''s Checklist',
 'Thinking about renovating? Here are the steps we walk every client through before the first hammer swings.',
 '<p>A successful renovation starts long before demolition day. At Demo Contracting Ltd we always begin with a clear plan.</p><h3>1. Define your goals</h3><p>Know what you want to achieve — more space, better flow, higher resale value — so every decision supports it.</p><h3>2. Set a realistic budget</h3><p>Include a 10-15% contingency for the surprises every older home hides.</p><h3>3. Choose the right contractor</h3><p>Look for licensing, insurance, references and clear written quotes.</p>',
 'assets/img/service-interior.jpg', 'Mark Delaney', 1, '2025-05-12 09:00:00'),
('roofing-signs-you-need-replacement', '5 Signs It''s Time to Replace Your Roof',
 'Prairie weather is hard on roofs. Here are the warning signs that it may be time for a replacement.',
 '<p>Your roof is your home''s first line of defense. Watch for these signs:</p><ul><li>Curling or missing shingles</li><li>Granules in the gutters</li><li>Daylight or stains in the attic</li><li>Sagging rooflines</li><li>A roof over 20 years old</li></ul><p>If you spot any of these, book a free inspection with our team.</p>',
 'assets/img/service-roofing.jpg', 'Sara Whitfield', 1, '2025-06-03 09:00:00'),
('choosing-materials-for-your-deck', 'Choosing the Right Materials for Your New Deck',
 'Cedar, composite or pressure-treated? We break down the pros and cons for prairie climates.',
 '<p>The material you choose shapes how your deck looks, lasts and feels underfoot.</p><h3>Cedar</h3><p>Naturally beautiful and rot-resistant, but needs regular sealing.</p><h3>Composite</h3><p>Low maintenance and long lasting, at a higher up-front cost.</p><h3>Pressure-treated</h3><p>Budget friendly and strong — the workhorse of prairie decks.</p>',
 'assets/img/service-deck.jpg', 'Tyler Brooks', 1, '2025-06-28 09:00:00');

-- ---- sections (homepage order + visibility) -------------------------------
INSERT INTO sections (section_key, label, sort_order, is_enabled) VALUES
('hero',        'Hero',            10,  1),
('about',       'About',           20,  1),
('counters',    'Counters / Stats',30,  1),
('services',    'Services',        40,  1),
('why_choose',  'Why Choose Us',   50,  1),
('features',    'Features',        60,  1),
('cta_banner',  'CTA Banner',      70,  1),
('testimonials','Testimonials',    80,  1),
('process',     'Process',         90,  1),
('pricing',     'Pricing',         100, 1),
('team',        'Team',            110, 1),
('faq',         'FAQ',             120, 1),
('contact_cta', 'Contact CTA',     130, 1),
('blog',        'Latest Blog',     140, 1);
