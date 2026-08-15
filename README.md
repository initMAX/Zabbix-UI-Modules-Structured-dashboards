<div align="center">

<h1>Structured Dashboard</h1>

<p>
developed and maintained by
<a href="https://www.initmax.com"><img alt="initMAX" src="./.readme/logo/initmax-logo-framed.svg" height="22" valign="middle"></a>
and community
</p>

<p><strong>Turns a flat wall of dashboards into a list you can actually navigate.</strong><br>
Turns "Network / Core / Datacenter A" into a folder tree on the Dashboards page - nested sections you can fold, so an installation with a hundred boards stops being a scroll.</p>

<p>
<img src="./.readme/badge/zabbix.svg" alt="Zabbix 6.0-7.4">
<img src="./.readme/badge/version.svg" alt="version 2.0.0">
<img src="./.readme/badge/php.svg" alt="PHP 7.4+">
<img src="./.readme/badge/free.svg" alt="FREE AGPLv3">
<img src="./.readme/badge/gpg.svg" alt="GPG signed">
</p>

<p>
<a href="#what-it-does"><strong>What it does</strong></a> &nbsp;·&nbsp;
<a href="#what-it-looks-like"><strong>Screenshot</strong></a> &nbsp;·&nbsp;
<a href="#install"><strong>Install</strong></a> &nbsp;·&nbsp;
<a href="#requirements"><strong>Requirements</strong></a> &nbsp;·&nbsp;
<a href="https://portal.initmax.com"><strong>Portal</strong></a> &nbsp;·&nbsp;
<a href="https://www.initmax.com/wiki/structured-dashboards/"><strong>Docs</strong></a>
</p>

<br>

<img src="./.readme/screen/01-overview.png" width="880" alt="The Dashboards page grouped into nested, collapsible sections">

</div>

---

## What it does

Zabbix lists every dashboard you can see in one flat, alphabetical table. That is fine with ten of them and unusable with a hundred, where finding the one board you need means scrolling past everyone else's.

**Structured Dashboard** reads the `/` you already put in dashboard names and turns it into structure. `Network / Core / Datacenter A` becomes **Datacenter A** inside **Core** inside **Network**, nested as deep as you name it, and every level folds away. What you folded is remembered per user, so the page opens the way you left it. There is nothing to configure: rename a dashboard and it moves. Nothing else about the page changes - the same rows, the same filter, the same actions, and one tick-box per group to select everything under it.

## What it looks like

<div align="center">
<img src="./.readme/screen/02-collapsed.png" width="880" alt="The same page with one group and one whole section folded away">
</div>

Fold what you are not working on and the page stays short. The arrows keep their state per user, so it opens the way you left it.

## Install

The module ships as a **GPG-signed `deb` / `rpm` package** from the initMAX repository - `apt` / `dnf` installs it and keeps it updated.

### Easiest way - the guided installer on the Portal

Open the product page, pick your **OS**, and copy the ready-made command. It is fully public, no login needed. There's a feedback box right there too.

<p align="center"><a href="https://portal.initmax.com/catalog/zabbix-structured-dashboard#how-to-install"><strong>→ Open the installer on the Portal</strong></a></p>

Prefer a plain archive? Every release also ships as a **ZIP** [straight from the repo](https://repo.initmax.com/zabbix/free/zip/structured-dashboard/) - handy for offline or manual installs.

Then enable it in **Administration → General → Modules** and open **Dashboards**. Done.

## Requirements

|              |                                                              |
| ------------ | ------------------------------------------------------------ |
| **Zabbix**   | 6.0 · 6.2 · 6.4 · 7.0 · 7.2 · 7.4 - one package covers all    |
| **PHP**      | 7.4 or newer                                                 |
| **OS**       | Debian/Ubuntu · RHEL/Rocky/Alma/Oracle/Amazon · SUSE         |
| **Edition**  | FREE - there is no paid edition of this module               |
| **Languages** | Every language Zabbix supports. The only words the module adds are the group names you type into your own dashboard names, and the two tooltips on the collapse control, which come from Zabbix's own translations |
| **High availability** | Ready. Which groups you collapsed is stored in your Zabbix user profile - in the database, not on the frontend node - so install it on every node of an HA cluster and any node can serve the page with your layout intact |

**Every version behaves the same.** The same nesting, the same collapse control, the same per-group selection, on 6.0 as on 7.4. There is exactly one difference, and it is Zabbix's, not ours: 6.0 has no documentation ("?") link on the Dashboards page, so the module does not draw one there either. Nothing else is left out on any version - a control that would be drawn but dead is not shipped at all.

Under the hood the package carries two module trees, because Zabbix 6.0/6.2 load one manifest format and 6.4 and newer load another. They are the same product: the page and its client are written once and both trees use them, which a build-time check enforces.

## Support &amp; links

- 📚 **[Documentation / Wiki](https://www.initmax.com/wiki/structured-dashboards/)**
- 🛒 **[Product page](https://www.initmax.com/product/structured-dashboards/)**
- 🎫 **[Portal](https://portal.initmax.com)** - downloads, support tickets
- 💾 **Source code** (AGPLv3) - included in every package and published as a [source archive](https://repo.initmax.com/zabbix/free/zip/structured-dashboard/) on repo.initmax.com
- ✉️ **[support@initmax.com](mailto:support@initmax.com)**

---

<div align="center">
<sub><a href="https://www.gnu.org/licenses/agpl-3.0.html">AGPLv3</a> &nbsp;·&nbsp; © 2021–2026 initMAX s.r.o.</sub>
</div>
