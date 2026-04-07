# alexblanes.com — Changelog

## Commit 016 — "How I Work" Values Section (2026-04-07)
- **New section**: "How I Work" added between Fun Facts and Open To
  - Five values: Kindness as infrastructure, Transparency by default, Mission over mechanics, Complexity over control, Stewardship not extraction
  - Content informed by Alex's trojan mice article (systems thinking / complexity science) and solarpunk treatise (cyclical sustainability)
- **New data file**: `src/data/how.js` — section label, title, and values array (title + desc with HTML support)
- **Template**: new `<!-- HOW I WORK -->` block in `index.astro` with numbered list layout, `set:html` for italic emphasis in descriptions
- **CSS**: `.how-section`, `.how-list`, `.how-item`, `.how-num`, `.how-title`, `.how-desc` — warm-white background with border treatment (matches education/platforms pattern), single-column editorial layout, responsive breakpoint at 480px
- **Observer**: `.how-item` added to IntersectionObserver selector for scroll-reveal animations
- **dateModified** updated to 2026-04-07
- **Rollback**: revert this commit and restore Commit 015's `index.astro` + remove `src/data/how.js`

## Commit 015 — Content Extraction + FTP Sync (2026-03-31)
- **Major refactor**: extracted all editable content from `index.astro` into 10 standalone JS data files in `src/data/`
  - `site.js` — meta tags, OG/Twitter, JSON-LD Person/WebSite/WebPage schemas
  - `nav.js` — navigation links (desktop + mobile)
  - `hero.js` — headline, tagline, CTAs, recruiter link
  - `stats.js` — stats bar values
  - `capabilities.js` — four capability cards (labels, items)
  - `experience.js` — featured role, timeline roles, additional roles
  - `education.js` — education entries
  - `platforms.js` — tools/platforms list
  - `funfacts.js` — fun facts cards (emoji + HTML)
  - `opento.js` — Open To section (cells, intro, salary note)
  - `footer.js` — footer CTAs, phone, copyright
- `index.astro` is now a pure template — imports data, loops, renders. All CSS unchanged.
- **Global scroll offset**: added `[id] { scroll-margin-top: 100px; }` to CSS (replaces per-section inline style)
- **FTP syncs** (3 edits from live site pulled back into Astro source):
  - Hero tagline updated: "...go-to-market systems and predictable revenue engines in Europe and globally."
  - Recruiter wayfinding link added below hero CTAs: "Recruiter or hiring manager? See what I'm looking for →"
  - `scroll-margin-top: 100px` on `#opento` (now handled by global CSS rule)
- **dateModified** in WebPage JSON-LD updated to 2026-03-31
- **Visual output**: pixel-identical to Commit 014 + live FTP edits. No design changes.
- **Editing workflow**: to change site content, edit the relevant file in `src/data/` — no need to touch `index.astro` for text/content changes.
- **Rollback note**: Revert to Commit 014 ZIP for the previous single-file structure. The three FTP syncs would need to be re-applied manually.

## Commit 014 — Open To Section (2026-03-30)
- Added "What I'm looking for" section between Fun Facts and Footer, aimed at recruiters and hiring managers
- 2×2 grid layout: Role, Location, Ideal arrangement, Employment — each cell has a primary detail and an italic qualifier
- Narrative opener positions the section as a senior leadership search; salary excluded by design with a soft redirect line
- White background (same as Capabilities/Experience), consistent with existing section styling
- Grid cells have staggered scroll-reveal animations (0s–0.15s delays)
- No nav link added — section is discoverable by scrolling; nav kept clean at five items
- JSON-LD `seeks` (Demand type) added to Person schema for SEO/AEO coverage of job-seeking status
- Responsive: grid collapses to single-column on mobile (≤480px)
- **FTP syncs** (10 edits from live site pulled back into Astro source):
  - All meta descriptions + JSON-LD descriptions: "multi-market" → "multi-region"
  - OG/Twitter/Person/WebSite descriptions reordered: "field marketing, demand generation" (was "demand generation, field marketing")
  - Hero tagline: "multi-market" → "multi-region"
  - Stats bar: 390%/SQL Growth moved to 3rd position, Nationalities moved to 5th
  - Capabilities card title: "Multi-Market Execution" → "multi-region Execution"
  - Capabilities card bullets reordered: Event strategy → Partner → Regional programme
  - GVR bullet restored to longer version with "field activations" and full venue list
  - GVR channel bullet: "multi-market" → "multi-region"
  - Radiate B2B bullet: "Led" → "Designed and delivered"
  - hasOccupation JSON-LD: description reordered + "multi-region Execution" in skills
  - Footer email CTA: removed trailing "↗" to match live site
- **Section flow**: Hero → Capabilities → Experience → Education → Platforms & Tools → Fun Facts → **Open To** → Footer
- **Rollback note**: Revert to Commit 013a ZIP to remove the Open To section. The FTP syncs are independent content edits and would need to be re-applied manually if rolling back.

## Commit 013a — Footer LinkedIn Shortened Label (2026-03-26)
- Kept both footer buttons as `btn-lg` pills; shortened LinkedIn label from "Connect with me on LinkedIn ↗" to "LinkedIn ↗" for balanced visual weight
- **Rollback note**: Revert to Commit 013 for the longer label.

## Commit 013 — Contact Nav + Footer LinkedIn Button (2026-03-26)
- Changed nav CTA from "LinkedIn ↗" (external) to "Contact" (anchors to `#contact` footer) in both desktop and mobile nav
- Added `id="contact"` to `<footer>` element
- Added secondary ghost button "Connect with me on LinkedIn ↗" in footer below the email CTA
- Added footer-specific `.btn-ghost` styles for legibility on dark background
- **Rollback note**: Revert to Commit 012 to restore the LinkedIn nav button and single-button footer.

## Commit 012 — Add Personal Nav Link + FTP Sync (2026-03-26)
- Added "Personal" link to desktop nav and mobile menu, pointing to `#facts`
- Synced FTP edits into Astro source: "View CV" → "Download CV" button text; first fact card text updated to include "but have lived and worked in 🇬🇧 for the past 10 years"
- **Rollback note**: Revert to Commit 011 to remove the nav link. FTP text syncs are cosmetic only.

## Commit 011 — Remove Skills Section (2026-03-26)
- Removed the "Skills" section (16 competency pills) — Core Capabilities cards now cover this ground
- Migrated 6 keywords not already present into `knowsAbout` JSON-LD array for SEO preservation: Content Marketing, Email Marketing, Lead Scoring & Qualification, Brand Positioning, Budget & ROI Governance, Social Media Strategy
- Also updated "Channel Marketing" → "Channel & Partner Marketing" in `knowsAbout` for consistency
- Cleaned up CSS: removed `.skills-section` selectors, kept `.platforms-section` and `.tag-alt` (still used by Platforms & Tools)
- Section flow now: … Education → Platforms & Tools → Fun Facts → Footer
- **Rollback note**: Revert to Commit 010 ZIP to restore the Skills section. JSON-LD keyword additions are safe to keep either way.

## Commit 010 — Circular Favicon from Headshot (2026-03-25)
- Generated circular (transparent background) favicon from alex-headshot-2023.jpg
- Sizes: 16px, 32px, 180px (Apple touch icon), 192px, 512px (PWA), plus .ico (16+32)
- Files added to `public/`: favicon.ico, favicon-32.png, favicon-192.png, favicon-512.png, apple-touch-icon.png
- Added `<link>` tags in `<head>`: .ico (legacy), 512px PNG (modern), Apple touch icon
- **Rollback note**: Purely additive — new files in `public/` and 3 `<link>` lines in `<head>`. No visual or structural changes.

## Commit 009 — Capabilities Section Repositioning (2026-03-25)
- Replaced all four Core Capabilities cards to reposition from "experienced practitioner" to "senior marketing leader"
- New cards: Strategy & Leadership → Revenue & Pipeline → Multi-Market Execution → Operations & Intelligence
- Old cards: Demand Generation → Field & Channel Marketing → GTM & Sales Alignment → Marketing Ops & Governance
- Card narrative arc: vision → commercial impact → scale → systems
- Removed tool names (HubSpot, Salesforce, Airtable) from capabilities — these already live in Platforms & Tools
- Updated JSON-LD `hasOccupation.skills` to reflect new positioning
- **Context**: Based on Neill Emmett's feedback that Alex was selling himself as more junior than he is. Strategy & Leadership leads with team building, stakeholder engagement, and TAM/segmentation work. Demand gen moves into Revenue & Pipeline as one tool among several.
- **Rollback note**: Content-only change to `.cap-card` blocks + JSON-LD skills string. No structural/CSS changes.

## Commit 008 — Responsive Headshot Optimisation (2026-03-25)
- Replaced single `<img>` with `<picture>` element using WebP srcset
- Generated 5 WebP sizes: 320w (11KB), 480w (24KB), 640w (39KB), 960w (68KB), 1000w (72KB)
- `sizes="(max-width: 900px) 320px, 400px"` — mobile gets 320w, desktop gets 480w
- Original JPG (86KB) retained as fallback for older browsers
- Added `fetchpriority="high"` — tells the browser this is the LCP image, fetch it first
- Mobile image payload: 86KB → ~11KB (87% reduction)
- Schema `image` field still points to headshot.jpg for maximum crawler/social compatibility

## Commit 007 — Self-Hosted Fonts (2026-03-25)
- Converted Instrument Serif (Regular + Italic) and DM Sans (Variable + Italic Variable) from TTF to WOFF2
- Added 4x @font-face declarations with font-display: swap
- Preloading the two most critical font files (Instrument Serif Regular + DM Sans Variable)
- Completely removed all Google Fonts external references (preconnect, stylesheet, noscript fallback)
- Result: zero third-party font requests, all fonts served from origin
- Font files total: 251KB (InstrumentSerif-Regular 27K, InstrumentSerif-Italic 28K, DMSans-Variable 87K, DMSans-Italic-Variable 110K)
- **Supersedes commit 006** (which made Google Fonts async; now they're gone entirely)

## Commit 006 — Fix Render-Blocking Fonts (2026-03-25)
- Replaced render-blocking Google Fonts `<link rel="stylesheet">` with async loading pattern
- Added `<link rel="preload" as="style">` for early fetch without blocking
- Switched stylesheet to `media="print" onload="this.media='all'"` so it loads async
- Added `<noscript>` fallback for non-JS environments
- Estimated savings: ~750ms off initial render (per Lighthouse)
- Synced Schumacher College URL in Person schema to match Alex's FTP edit
- **Visual note**: On first load, text may briefly appear in system fonts before web fonts swap in (FOUT). This is the intended trade-off — faster perceived load vs. invisible text (FOIT).

## Commit 005 — Platforms & Tools Background Match (2026-03-25)
- Applied same off-white background (--warm-white) + top/bottom borders to Platforms & Tools section, matching Skills section design

## Commit 004 — Tier 1 Technical SEO (2026-03-25)
- Added JSON-LD Person schema with: name, jobTitle, description, contact info, knowsAbout (11 skills), sameAs (LinkedIn, Medium), alumniOf (3 universities), hasOccupation, worksFor, nationality
- Added JSON-LD WebSite schema with @id cross-referencing Person
- Added JSON-LD WebPage schema with datePublished, dateModified, about→Person
- All three schemas use @id linking to build a connected entity graph
- Added `<link rel="canonical">` pointing to https://alexblanes.com/
- Added `<meta name="robots" content="index, follow">`
- Updated `lang="en"` → `lang="en-GB"`
- Created robots.txt (Allow all, Sitemap reference)
- Created sitemap.xml (single URL entry, weekly changefreq)
- **Rollback note**: This commit is purely additive (new `<script>` blocks in `<head>`, new files in `/public`). Safe to deploy; no visual changes.

## Commit 003a — Skills Section Tweaks (2026-03-25)
- Moved Skills section BELOW Platforms & Tools (order: Platforms & Tools → Skills → Fun Facts)
- Added off-white background (--warm-white) with top/bottom borders to Skills section for visual alternation

## Commit 003 — Add Skills Section (2026-03-25)
- Added new "Skills" section above "Platforms & Tools"
- Section label: "Competencies", title: "Skills"
- 16 skill pills inferred from CV/experience: Go-to-Market Strategy, Demand Generation, Account-Based Marketing, Field Marketing, Channel & Partner Marketing, Event Strategy, Sales Enablement, Paid Media, Content Marketing, Email Marketing & Nurture, Lead Scoring & Qualification, Marketing Operations, Pipeline Management, Brand & Positioning, Budget & ROI Governance, Social Media Strategy
- Uses same `tag tag-alt` dark pill design as Platforms & Tools
- Section ID: `#skills`

## Commit 002 — Dark Mode (2026-03-24)
- Added `prefers-color-scheme: dark` support via CSS custom properties
- File deployed: alex-blanes-portfolio_darkMode.zip

## Commit 001 — Initial Build (2026-03-23)
- Single-page Astro site: Hero, Stats, Capabilities, Experience, Education, Platforms & Tools, Fun Facts, Footer CTA
- Cream/terracotta palette, Instrument Serif + DM Sans typography
- OpenGraph image + meta tags
- Mobile responsive with hamburger nav
- Scroll-reveal animations
