# GitHub + Hostinger Auto-Deploy Setup

This guide walks you through connecting your site to GitHub so you can edit content in a browser and have changes deploy automatically to Hostinger via SSH.

**Time required:** ~15 minutes

---

## Step 1: Create a GitHub Account

1. Go to [github.com](https://github.com) and sign up (free tier is fine)
2. Verify your email

## Step 2: Create a Private Repository

1. Click **+** → **New repository** (top-right corner)
2. Name: `alexblanes.com` (or whatever you prefer)
3. Visibility: **Private** (your phone number and email are in the source)
4. Do **not** tick "Add a README", ".gitignore", or "License" — we'll push existing files
5. Click **Create repository**

## Step 3: Add Your Hostinger SSH Credentials as Secrets

This is the key step — it tells GitHub how to connect to your Hostinger server.

1. In your new repo, go to **Settings** → **Secrets and variables** → **Actions**
2. Click **New repository secret** and add these four secrets, one at a time:

| Secret name | Value |
|---|---|
| `HOSTINGER_HOST` | `141.136.39.164` |
| `HOSTINGER_PORT` | `65002` |
| `HOSTINGER_USERNAME` | `u740916518` |
| `HOSTINGER_PASSWORD` | *(your SSH password — the same one you'd use to SSH in)* |

> **Don't know your SSH password?** In the Hostinger panel, go to **Advanced → SSH Access → Password → Change** to set one. This is separate from your Hostinger account password.

## Step 4: Push Your Code to GitHub

### Option A — Using GitHub's web upload (no Git CLI needed)

1. On your empty repo page, you'll see a blue link: **"uploading an existing file"** — click it
2. Unzip the Commit 015 ZIP on your Mac
3. Drag and drop **all the contents** into the upload area:
   - `.github/` folder (contains the deploy workflow)
   - `src/` folder
   - `public/` folder
   - `package.json`
   - `package-lock.json`
   - `astro.config.mjs`
   - `.gitignore`
   - `CHANGELOG.md`
   - This `GITHUB_SETUP.md` file (optional)
4. Commit message: `Initial commit (Commit 015)`
5. Click **Commit changes**

### Option B — Using Terminal (if you prefer Git CLI)

```bash
cd /path/to/unzipped/commit015
git init
git add .
git commit -m "Initial commit (Commit 015)"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/alexblanes.com.git
git push -u origin main
```

## Step 5: Watch It Deploy

1. Go to the **Actions** tab in your repo
2. You should see a workflow run starting — "Build and deploy to Hostinger"
3. Click into it to watch the progress
4. Green checkmark = your site is live with the latest changes

> **First deploy** may take 1–2 minutes. The action builds your Astro site in the cloud, then uploads the built files to `public_html` on Hostinger via SCP.

## Step 6: Test the Editing Workflow

1. In your repo, navigate to `src/data/hero.js`
2. Click the ✏️ pencil icon to edit
3. Change the `tagline` text to something temporary (e.g., add "TEST" at the start)
4. Click **Commit changes** (directly to `main` is fine)
5. Go to the **Actions** tab — you'll see a new deploy starting automatically
6. Wait for the green checkmark, then check your live site
7. Edit it back and commit again to restore

---

## Your New Editing Workflow

### For content changes (text, stats, cards, etc.):
1. Go to `src/data/` in your GitHub repo
2. Open the relevant file and click ✏️ to edit
3. Make your change and commit — auto-deploys in ~1 minute

### Data file reference:

| What to edit | File |
|---|---|
| Page title, meta tags, OG, JSON-LD | `src/data/site.js` |
| Nav links | `src/data/nav.js` |
| Hero (tagline, buttons, recruiter link) | `src/data/hero.js` |
| Stats bar | `src/data/stats.js` |
| Capability cards | `src/data/capabilities.js` |
| Job roles & experience | `src/data/experience.js` |
| Education entries | `src/data/education.js` |
| Platforms & Tools list | `src/data/platforms.js` |
| Fun facts cards | `src/data/funfacts.js` |
| "Open To" section | `src/data/opento.js` |
| Footer (CTAs, phone, copyright) | `src/data/footer.js` |

### For style/layout/structural changes:
These still live in `src/pages/index.astro` (the CSS and template). Either:
- Edit on GitHub the same way
- Or ask Claude for a new commit

### Manual deploy:
If you ever need to trigger a deploy without making a change, go to **Actions** → **Build and deploy to Hostinger** → **Run workflow** → **Run workflow**.

---

## Important Notes

- **FTP edits**: You can still use Nova/FTP for quick edits, but those changes won't be in your GitHub repo. If you later push a change via GitHub, the FTP edit will be overwritten. Best practice: make all changes via GitHub going forward.
- **Rollback**: Every commit in GitHub is a snapshot. To roll back, revert the commit on GitHub and it auto-deploys the previous version.
- **No more ZIPs**: Once this is set up, you won't need ZIP deployments anymore. Claude can provide individual file changes that you paste into the GitHub editor.

---

## Future: Adding Darkmatter CMS (Optional)

Once this workflow is stable, you can layer [Darkmatter](https://getdarkmatter.dev/) on top for a visual editing interface. Darkmatter reads Astro content collections and gives you a form-based UI + git commit/push built in. The data file structure in this commit is designed to make that transition straightforward.
