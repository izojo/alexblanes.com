// ──────────────────────────────────────────────
// Hero section — headline, tagline, CTAs, and
// the recruiter wayfinding link.
// ──────────────────────────────────────────────

export default {

  label: "Senior B2B Marketer",

  // Line break in the name is handled by the template (<br />)
  firstName: "Alex",
  lastName: "Blanes",

  tagline:
    "Transforming multi-region challenges into measurable success. I build integrated go-to-market systems and predictable revenue engines in Europe and globally.",

  buttons: [
    {
      label: "View Experience",
      href: "#experience",
      style: "primary",  // "primary" | "ghost"
    },
    {
      label: "Download CV ↗",
      href: "https://docs.google.com/document/d/1m-w6adC_NfSePpfy6aRDAOAmZphgn6x1/edit?usp=sharing&ouid=105216627635762718693&rtpof=true&sd=true",
      style: "ghost",
      external: true,
    },
  ],

  // Muted link below the CTAs — points recruiters to the Open To section
  recruiterLink: {
    text: "Recruiter or hiring manager? See what I'm looking for →",
    href: "#opento",
  },
};
