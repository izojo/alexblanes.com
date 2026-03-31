// ──────────────────────────────────────────────
// Experience section.
//
// Three groups:
//   featured  – the GVR role with subsections
//   timeline  – other main roles (displayed as cards)
//   additional – compact one-liner roles
// ──────────────────────────────────────────────

export const sectionLabel = "Career";
export const sectionTitle = "Experience";

// ── Featured role ──────────────────────────────
export const featured = {
  title: "Head of Marketing Communications",
  company: "Gilbarco Veeder-Root",
  period: "May 2022 – Apr 2025",
  location: "Remote, UK",
  context:
    "OEM market leader across 48 countries + 12 languages. Owned the full European marketing function — strategy, demand generation, field/events, channel marketing, and brand — with a $1M+ budget, a core team of four, two agencies, and 30+ vendors.",
  subsections: [
    {
      heading: "Demand Generation & Field Marketing",
      bullets: [
        "Led 30+ owned and paid field activations across European markets — trade events, distributor roadshows, product launches, showroom openings, aftermarket webinars, customer days and partner summits — fused with pre-event ABM targeting, on-site lead capture, and post-event nurture sequences",
        "$26M sales pipeline generated through integrated field and digital demand programmes, with attribution tied to field-sourced and field-accelerated pipeline",
        "Embedded closed-loop reporting to reallocate spend toward high-yield motions. Built pipeline review cadences with Sales leadership and established lead handoff SLAs",
      ],
    },
    {
      heading: "Channel & Partner Marketing",
      bullets: [
        "Launched an aftermarket parts eCommerce platform as Product Owner — €2M revenue in 6 months, scaled to €10M+, lifted downstream distributor sales +29%, removed €200K annual operating cost",
        "Managed multi-brand, multi-region channel execution across 30+ vendors and distributor partners with partner-facing content, co-marketing collateral, and sales enablement materials",
      ],
    },
    {
      heading: "Marketing Operations & Strategic Planning",
      bullets: [
        "Built the European marketing operating system — integrated process ecosystem in Airtable linking Marketing, Finance, Product, and Commercial teams for unified execution and credible ROI governance",
        "Owned TAM development and refinement (2022, 2023) and facilitated annual executive reviews to inform Product/R&D roadmaps and M&A considerations",
      ],
    },
  ],
};

// ── Timeline roles ─────────────────────────────
export const timeline = [
  {
    title: "Head of Strategy (Contract)",
    company: "Ziggy Agency",
    period: "Nov 2025 – Feb 2026",
    location: "Remote, UK",
    context:
      "B2B demand generation agency serving enterprise and Fortune 500 clients. Contracted to build a strategic development function shifting the agency from campaign execution to full-funnel revenue accountability.",
    bullets: [
      "Designed and delivered demand generation strategies for Fortune 500 clients including Canon Europe, Schneider Electric, and Publicis Groupe (Epsilon), with budgets ranging from £57K to $1M+",
      "Allocated a $1.1M paid media budget across three segments for a major travel tech company, aligning quarterly campaigns with rebrand milestones and external demand spikes.",
      "Shifted performance measurement from vanity metrics (MQLs, form fills) to pipeline ROAS, CAC:LTV ratios, and payback period optimisation",
    ],
  },
  {
    title: "Head of Marketing",
    company: "Gyre (formerly CharacterScope)",
    period: "Apr 2021 – Mar 2022",
    location: "Remote, UK",
    context:
      "L&D SaaS rebranding and repositioning; mandate to build pipeline from zero.",
    bullets: [
      "Co-led end-to-end rebrand as a pipeline strategy, turning positioning, ICP definition, and value proposition into the spine for GTM, sales enablement, and channel mix decisions.",
      "Generated 100+ qualified leads in 45 days at £32 CPL through LinkedIn and Google Ads with creative/keyword testing and landing-page optimisation",
      "Built ABM with Sales from day one: account selection via Crunchbase, personalised outreach, and integrated web/SEO/automation against shared revenue goals",
    ],
  },
  {
    title: "Marketing Manager",
    company: "Global Fund Media Ltd",
    period: "Jan 2020 – Mar 2021",
    location: "London, UK",
    context:
      "Pandemic pivot to virtual summits required a scalable field events engine for a fast-growing publishing and events firm.",
    bullets: [
      "Built a scalable virtual field events engine that became a new revenue stream worth £500K+",
      "Drove webinar registrations +794% (177 → 1,583) in a single quarter. Reset email performance baseline: open rates +125%, click rates +900%",
    ],
  },
  {
    title: "Marketing Communications Manager",
    company: "Interprefy",
    period: "Aug 2019 – Jan 2020",
    location: "Remote, UK",
    context:
      "Rapidly scaling SaaS in real-time translation, transitioning to a unified inbound model.",
    bullets: [
      "Increased monthly SQLs by 390% (25 → 120+) and generated 360+ opportunities worth €581K in a single quarter",
      "Migrated to HubSpot Enterprise. Re-engineered lead scoring and qualification with business process modelling, defining clean handoffs between Marketing and Sales",
    ],
  },
];

// ── Additional roles ───────────────────────────
export const additional = [
  {
    title: "Marketing Consultant & Product Owner",
    company: "Aalbun, London",
    period: "Jan 2020 – Mar 2021",
    summary:
      "Built full GTM framework from scratch (personas, SWOT, channel strategy, USPs) and implemented HubSpot CRM/CMS as integrated growth infrastructure. Later re-engaged to lead beta delivery of a legal tech product.",
  },
  {
    title: "Social Media Manager",
    company: "Ofgem, London",
    period: "Jan 2018 – Mar 2019",
    summary:
      "Designed the UK energy regulator's first social media strategy; +818% engagement and +284% audience growth in six months. Deployed social listening for regulatory compliance intelligence.",
  },
  {
    title: "Social Media Manager",
    company: "QS (Quacquarelli Symonds), London",
    period: "Mar 2019 – Aug 2019",
    summary:
      "Unified editorial and social content operations across global higher-education platforms (TopUniversities.com, TopMBA.com).",
  },
];
