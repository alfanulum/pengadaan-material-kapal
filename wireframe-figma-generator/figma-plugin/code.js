// ============================================================
// PT PAL Wireframe Generator – Figma Plugin code.js
// Sistem Pengadaan Material Kapal
// ============================================================
figma.showUI(__html__, { width: 520, height: 680, title: "PT PAL Wireframe Generator" });

// ---- DESIGN TOKENS (Low-Fidelity: hanya hitam, putih, abu) ----
const TOKEN = {
  white:     { r: 1,    g: 1,    b: 1 },
  black:     { r: 0,    g: 0,    b: 0 },
  gray50:    { r: 0.98, g: 0.98, b: 0.98 },
  gray100:   { r: 0.96, g: 0.96, b: 0.96 },
  gray200:   { r: 0.9,  g: 0.9,  b: 0.9 },
  gray300:   { r: 0.8,  g: 0.8,  b: 0.8 },
  gray400:   { r: 0.65, g: 0.65, b: 0.65 },
  gray500:   { r: 0.5,  g: 0.5,  b: 0.5 },
  gray700:   { r: 0.3,  g: 0.3,  b: 0.3 },
  gray900:   { r: 0.1,  g: 0.1,  b: 0.1 },
  dark:      { r: 0.07, g: 0.07, b: 0.07 },
};

// ---- FONTS ----
const FONT_REGULAR = { family: "Inter", style: "Regular" };
const FONT_MEDIUM  = { family: "Inter", style: "Medium" };
const FONT_BOLD    = { family: "Inter", style: "Bold" };

// ---- CANVAS CONFIG ----
const FRAME_W = 1440;
const FRAME_H = 900;
const PADDING = 40;
const GRID    = 8;

// ============================================================
// HELPER FUNCTIONS
// ============================================================

function rgb(color) { return color; }
function solid(color) { return [{ type: "SOLID", color: rgb(color) }]; }

async function loadFonts() {
  await figma.loadFontAsync(FONT_REGULAR);
  await figma.loadFontAsync(FONT_MEDIUM);
  await figma.loadFontAsync(FONT_BOLD);
}

function makeRect(parent, x, y, w, h, fill, name) {
  const r = figma.createRectangle();
  r.name = name || "rect";
  r.x = x; r.y = y; r.resize(w, h);
  r.fills = solid(fill);
  parent.appendChild(r);
  return r;
}

function makeText(parent, x, y, content, size, weight, color, maxW) {
  const t = figma.createText();
  t.fontName = weight === "bold" ? FONT_BOLD : weight === "medium" ? FONT_MEDIUM : FONT_REGULAR;
  t.characters = content;
  t.fontSize = size || 14;
  t.fills = solid(color || TOKEN.gray900);
  t.x = x; t.y = y;
  if (maxW) { t.textAutoResize = "HEIGHT"; t.resize(maxW, t.height); }
  parent.appendChild(t);
  return t;
}

function makeLine(parent, x, y, w) {
  const l = figma.createLine();
  l.x = x; l.y = y;
  l.resize(w, 0);
  l.strokes = solid(TOKEN.gray200);
  l.strokeWeight = 1;
  parent.appendChild(l);
  return l;
}

function roundedRect(parent, x, y, w, h, fill, radius, name) {
  const r = figma.createRectangle();
  r.name = name || "rounded-rect";
  r.x = x; r.y = y; r.resize(w, h);
  r.fills = solid(fill);
  r.cornerRadius = radius || 8;
  parent.appendChild(r);
  return r;
}

// ---- Composite Components ----

function drawNavbar(frame, items, cursorY) {
  const navH = 60;
  // Nav bg
  roundedRect(frame, 0, cursorY, FRAME_W, navH, TOKEN.white, 0, "navbar-bg");
  // bottom border
  makeLine(frame, 0, cursorY + navH - 1, FRAME_W);
  // Logo area
  roundedRect(frame, PADDING, cursorY + 16, 120, 28, TOKEN.gray200, 6, "logo-placeholder");
  makeText(frame, PADDING + 8, cursorY + 20, "PT PAL", 13, "bold", TOKEN.gray700);
  // Nav items
  let nx = 220;
  (items || ["Dashboard"]).forEach(item => {
    makeText(frame, nx, cursorY + 20, item, 13, "medium", TOKEN.gray700);
    nx += item.length * 8 + 32;
  });
  // User avatar
  roundedRect(frame, FRAME_W - PADDING - 36, cursorY + 12, 36, 36, TOKEN.gray300, 18, "avatar");
  return navH;
}

function drawHeader(frame, title, subtitle, buttons, cursorY) {
  const hdrH = buttons && buttons.length ? 80 : 72;
  makeText(frame, PADDING, cursorY + 16, title, 22, "bold", TOKEN.gray900, FRAME_W - 2 * PADDING - 200);
  if (subtitle) {
    makeText(frame, PADDING, cursorY + 44, subtitle, 13, "regular", TOKEN.gray500, FRAME_W - 2 * PADDING - 200);
  }
  if (buttons && buttons.length) {
    let bx = FRAME_W - PADDING;
    buttons.slice().reverse().forEach(btn => {
      const bw = Math.max(120, btn.text.length * 8 + 24);
      bx -= bw + 8;
      roundedRect(frame, bx, cursorY + 20, bw, 36, btn.variant === "primary" ? TOKEN.gray900 : TOKEN.gray200, 10, `header-btn-${btn.id}`);
      makeText(frame, bx + 12, cursorY + 28, btn.text, 12, "medium", btn.variant === "primary" ? TOKEN.white : TOKEN.gray700);
    });
  }
  makeLine(frame, 0, cursorY + hdrH - 1, FRAME_W);
  return hdrH;
}

function drawHeroBanner(frame, comp, cursorY) {
  const bh = 160;
  roundedRect(frame, PADDING, cursorY, FRAME_W - 2 * PADDING, bh, TOKEN.dark, 20, "hero-banner");
  // Tag pill
  roundedRect(frame, PADDING + 24, cursorY + 20, 140, 28, TOKEN.gray700, 14, "hero-tag");
  makeText(frame, PADDING + 36, cursorY + 27, comp.title ? comp.title.substring(0, 20) + (comp.title.length > 20 ? "..." : "") : "Banner", 11, "regular", TOKEN.gray300);
  // Title
  const titleText = comp.title || "Hero Title";
  makeText(frame, PADDING + 24, cursorY + 58, titleText, 22, "bold", TOKEN.white, FRAME_W - 2 * PADDING - 280);
  // CTA button
  if (comp.button_text || comp.button_id) {
    const btnTxt = comp.button_text || "Action";
    roundedRect(frame, PADDING + 24, cursorY + 110, 160, 36, TOKEN.white, 10, "hero-btn");
    makeText(frame, PADDING + 36, cursorY + 120, btnTxt, 12, "bold", TOKEN.gray900);
  }
  // Info card on right
  if (comp.info_card || comp.stat_card) {
    const card = comp.info_card || comp.stat_card;
    roundedRect(frame, FRAME_W - PADDING - 200, cursorY + 20, 176, 120, TOKEN.gray700, 14, "hero-info-card");
    const cardLabel = card.label || "Info";
    makeText(frame, FRAME_W - PADDING - 188, cursorY + 34, cardLabel, 11, "regular", TOKEN.gray400);
    if (card.value) {
      makeText(frame, FRAME_W - PADDING - 188, cursorY + 54, card.value, 28, "bold", TOKEN.white);
    }
    if (card.steps && Array.isArray(card.steps)) {
      card.steps.forEach((step, i) => {
        const s = typeof step === "string" ? step : (step.title || step.no || "");
        makeText(frame, FRAME_W - PADDING - 188, cursorY + 48 + i * 22, s, 11, "regular", TOKEN.gray300);
      });
    }
  }
  // Stat cards in hero (gudang)
  if (comp.stat_cards && Array.isArray(comp.stat_cards)) {
    comp.stat_cards.forEach((sc, i) => {
      const scx = PADDING + 24 + i * 200;
      roundedRect(frame, scx, cursorY + 90, 180, 56, TOKEN.gray700, 10, `hero-stat-${i}`);
      makeText(frame, scx + 12, cursorY + 100, sc.label, 10, "regular", TOKEN.gray400);
      makeText(frame, scx + 12, cursorY + 116, sc.value, 16, "bold", TOKEN.white);
    });
  }
  return bh + 20;
}

function drawStatCards(frame, comp, cursorY) {
  const cols = comp.columns || 4;
  const cardW = Math.floor((FRAME_W - 2 * PADDING - (cols - 1) * 16) / cols);
  const cardH = 80;
  (comp.cards || []).forEach((card, i) => {
    const cx = PADDING + i * (cardW + 16);
    roundedRect(frame, cx, cursorY, cardW, cardH, TOKEN.white, 12, `stat-card-${card.id || i}`);
    makeRect(frame, cx, cursorY, cardW, cardH, TOKEN.gray200, "stat-card-border");
    makeText(frame, cx + 16, cursorY + 14, card.label || "Stat", 11, "regular", TOKEN.gray500);
    makeText(frame, cx + 16, cursorY + 32, String(card.value || "0"), 22, "bold", TOKEN.gray900);
    if (card.sublabel) makeText(frame, cx + 16, cursorY + 58, card.sublabel, 10, "regular", TOKEN.gray400);
  });
  return cardH + 16;
}

function drawMenuCards(frame, comp, cursorY) {
  const cards = comp.cards || [];
  const cols = comp.columns || 2;
  const cardW = Math.floor((FRAME_W - 2 * PADDING - (cols - 1) * 20) / cols);
  const cardH = 160;
  const rows = Math.ceil(cards.length / cols);
  cards.forEach((card, i) => {
    const col = i % cols;
    const row = Math.floor(i / cols);
    const cx = PADDING + col * (cardW + 20);
    const cy = cursorY + row * (cardH + 16);
    const cw = (card.span === 2 && cols === 2) ? FRAME_W - 2 * PADDING : cardW;
    roundedRect(frame, cx, cy, cw, cardH, TOKEN.white, 16, `menu-card-${card.id || i}`);
    // Number
    roundedRect(frame, cx + 20, cy + 20, 36, 36, TOKEN.gray100, 10, "card-num-bg");
    makeText(frame, cx + 28, cy + 28, card.number || String(i + 1), 14, "bold", TOKEN.gray700);
    // Tag
    roundedRect(frame, cx + 68, cy + 28, 50, 22, TOKEN.gray100, 6, "card-tag-bg");
    makeText(frame, cx + 74, cy + 32, card.tag || "Tag", 10, "regular", TOKEN.gray500);
    // Title
    makeText(frame, cx + 20, cy + 68, card.title || "Menu", 16, "bold", TOKEN.gray900, cw - 40);
    // Desc
    if (card.desc) makeText(frame, cx + 20, cy + 94, card.desc, 12, "regular", TOKEN.gray500, cw - 40);
    // CTA
    makeText(frame, cx + 20, cy + cardH - 28, (card.cta || "Buka") + " →", 12, "medium", TOKEN.gray700);
  });
  return rows * (cardH + 16) + 16;
}

function drawTable(frame, comp, cursorY) {
  const cols = comp.columns || [];
  const rows = comp.sample_rows || [];
  const tableW = FRAME_W - 2 * PADDING;
  const rowH = 44;
  const hdrH = 44;
  const colW = Math.floor(tableW / cols.length);
  // Table title
  if (comp.title) {
    makeText(frame, PADDING, cursorY, comp.title, 14, "bold", TOKEN.gray900);
    cursorY += 28;
  }
  // Header
  roundedRect(frame, PADDING, cursorY, tableW, hdrH, TOKEN.gray50, 0, "tbl-header");
  cols.forEach((col, i) => {
    makeText(frame, PADDING + i * colW + 16, cursorY + 14, col.toUpperCase(), 10, "bold", TOKEN.gray500);
  });
  cursorY += hdrH;
  makeLine(frame, PADDING, cursorY, tableW);
  // Rows
  rows.forEach((row, ri) => {
    roundedRect(frame, PADDING, cursorY, tableW, rowH, ri % 2 === 0 ? TOKEN.white : TOKEN.gray50, 0, `tbl-row-${ri}`);
    row.forEach((cell, ci) => {
      const cellStr = String(cell);
      if (cellStr.startsWith("[BADGE:")) {
        const badgeTxt = cellStr.replace("[BADGE:", "").replace("]", "").trim();
        roundedRect(frame, PADDING + ci * colW + 16, cursorY + 12, badgeTxt.length * 7 + 20, 22, TOKEN.gray200, 11, `badge-${ri}-${ci}`);
        makeText(frame, PADDING + ci * colW + 26, cursorY + 17, badgeTxt, 10, "medium", TOKEN.gray700);
      } else if (cellStr.startsWith("[") && cellStr.endsWith("]")) {
        // Action buttons
        const btns = cellStr.slice(1, -1).split("][");
        let bx = PADDING + ci * colW + 16;
        btns.forEach(btn => {
          const bw = btn.length * 7 + 16;
          roundedRect(frame, bx, cursorY + 10, bw, 24, TOKEN.gray900, 6, `action-${btn}-${ri}`);
          makeText(frame, bx + 8, cursorY + 15, btn, 10, "medium", TOKEN.white);
          bx += bw + 6;
        });
      } else {
        makeText(frame, PADDING + ci * colW + 16, cursorY + 14, cellStr.substring(0, 30), 12, "regular", TOKEN.gray700);
      }
    });
    cursorY += rowH;
    makeLine(frame, PADDING, cursorY, tableW);
  });
  // Empty state
  if (rows.length === 0) {
    makeText(frame, PADDING + tableW / 2 - 80, cursorY + 16, "Belum ada data.", 13, "regular", TOKEN.gray400);
    cursorY += 48;
  }
  return cursorY + 16;
}

function drawForm(frame, comp, startY) {
  let cy = startY;
  if (comp.title) {
    makeText(frame, PADDING, cy, comp.title, 14, "bold", TOKEN.gray900);
    cy += 32;
  }
  const fields = comp.fields || [];
  const fieldW = FRAME_W - 2 * PADDING;
  fields.forEach(field => {
    if (field.type === "table-input") {
      makeText(frame, PADDING, cy, field.label || "Table Input", 12, "medium", TOKEN.gray700);
      cy += 20;
      // Draw a mini-table placeholder
      roundedRect(frame, PADDING, cy, fieldW, 80, TOKEN.gray50, 8, "table-input-placeholder");
      makeText(frame, PADDING + 16, cy + 28, (field.columns || []).join("  |  "), 11, "regular", TOKEN.gray400);
      cy += 96;
      return;
    }
    makeText(frame, PADDING, cy, field.label || "Field", 12, "medium", TOKEN.gray700);
    cy += 20;
    const inputH = field.type === "textarea" ? 72 : 40;
    roundedRect(frame, PADDING, cy, fieldW, inputH, TOKEN.white, 10, `field-${field.id || field.label}`);
    makeRect(frame, PADDING, cy, fieldW, inputH, TOKEN.gray200, "field-border");
    if (field.placeholder) {
      makeText(frame, PADDING + 14, cy + 12, field.placeholder, 12, "regular", TOKEN.gray400);
    } else if (field.options) {
      makeText(frame, PADDING + 14, cy + 12, `-- Pilih ${field.label || ""}... ▼`, 12, "regular", TOKEN.gray400);
    } else if (field.type === "file-upload") {
      makeText(frame, PADDING + 14, cy + 12, "📎 " + (field.label || "Upload file"), 12, "regular", TOKEN.gray400);
    } else if (field.type === "checkbox-group") {
      makeText(frame, PADDING + 14, cy + 12, "☑ Pilih vendor... (daftar checkbox)", 12, "regular", TOKEN.gray400);
    }
    cy += inputH + 16;
  });
  return cy;
}

function drawButtonGroup(frame, buttons, cursorY) {
  let bx = PADDING;
  const btnH = 40;
  (buttons || []).forEach(btn => {
    const bw = Math.max(120, btn.text.length * 8 + 32);
    const fill = btn.variant === "primary" ? TOKEN.gray900 : btn.variant === "danger" ? TOKEN.gray700 : TOKEN.gray200;
    const textColor = btn.variant === "secondary" ? TOKEN.gray700 : TOKEN.white;
    roundedRect(frame, bx, cursorY, bw, btnH, fill, 10, `btn-${btn.id}`);
    makeText(frame, bx + 14, cursorY + 12, btn.text, 13, "medium", textColor);
    if (btn.condition) {
      makeText(frame, bx + 14, cursorY + btnH + 2, `*${btn.condition}`, 9, "regular", TOKEN.gray400);
    }
    bx += bw + 12;
  });
  return btnH + 24;
}

function drawChat(frame, comp, cursorY) {
  const chatH = 280;
  const chatW = FRAME_W - 2 * PADDING;
  // Header
  roundedRect(frame, PADDING, cursorY, chatW, 48, TOKEN.gray100, 10, "chat-header");
  makeText(frame, PADDING + 16, cursorY + 14, comp.info || "Chat", 13, "bold", TOKEN.gray900);
  cursorY += 56;
  // Messages area
  roundedRect(frame, PADDING, cursorY, chatW, 160, TOKEN.gray50, 10, "chat-messages");
  const msgs = comp.sample || [];
  let my = cursorY + 12;
  msgs.forEach((msg, i) => {
    const isLeft = i % 2 === 0;
    const bubbleW = Math.min(400, msg.text.length * 8 + 32);
    const bx = isLeft ? PADDING + 12 : FRAME_W - PADDING - bubbleW - 12;
    roundedRect(frame, bx, my, bubbleW, 36, isLeft ? TOKEN.gray200 : TOKEN.gray900, 10, `bubble-${i}`);
    makeText(frame, bx + 10, my + 10, msg.text.substring(0, 48), 11, "regular", isLeft ? TOKEN.gray700 : TOKEN.white);
    makeText(frame, bx, my - 14, msg.sender, 10, "medium", TOKEN.gray500);
    my += 52;
  });
  cursorY += 168;
  // Input area
  roundedRect(frame, PADDING, cursorY, chatW - 100, 44, TOKEN.white, 10, "chat-input");
  makeText(frame, PADDING + 14, cursorY + 14, "Tulis pesan...", 12, "regular", TOKEN.gray400);
  roundedRect(frame, FRAME_W - PADDING - 88, cursorY, 80, 44, TOKEN.gray900, 10, "btn-kirim-chat");
  makeText(frame, FRAME_W - PADDING - 72, cursorY + 14, "Kirim", 13, "medium", TOKEN.white);
  return cursorY + 60;
}

function drawInfoPanel(frame, comp, cursorY, x, w) {
  roundedRect(frame, x, cursorY, w, 300, TOKEN.gray50, 16, "info-panel");
  makeText(frame, x + 20, cursorY + 20, comp.title || "Info Panel", 15, "bold", TOKEN.gray900);
  const steps = comp.steps || [];
  steps.forEach((step, i) => {
    roundedRect(frame, x + 20, cursorY + 60 + i * 44, 24, 24, TOKEN.gray200, 12, `step-num-${i}`);
    makeText(frame, x + 29, cursorY + 65 + i * 44, String(i + 1), 11, "bold", TOKEN.gray700);
    makeText(frame, x + 54, cursorY + 65 + i * 44, step, 12, "regular", TOKEN.gray700, w - 80);
  });
}

function drawTimeline(frame, comp, cursorY) {
  const steps = comp.steps || [];
  const stepW = Math.floor((FRAME_W - 2 * PADDING) / steps.length);
  steps.forEach((step, i) => {
    const cx = PADDING + i * stepW + stepW / 2;
    // Circle
    roundedRect(frame, cx - 16, cursorY, 32, 32, i === 0 ? TOKEN.gray900 : TOKEN.gray300, 16, `tl-step-${i}`);
    makeText(frame, cx - 8, cursorY + 8, String(i + 1), 12, "bold", i === 0 ? TOKEN.white : TOKEN.gray700);
    // Line
    if (i < steps.length - 1) makeRect(frame, cx + 16, cursorY + 14, stepW - 32, 4, TOKEN.gray300, `tl-line-${i}`);
    // Label
    makeText(frame, cx - 60, cursorY + 40, step, 10, "regular", TOKEN.gray700, 120);
  });
  return 80;
}

function drawWorkflowSteps(frame, comp, cursorY) {
  const steps = comp.steps || [];
  roundedRect(frame, PADDING, cursorY, FRAME_W - 2 * PADDING, 64, TOKEN.gray50, 12, "workflow-steps");
  makeText(frame, PADDING + 16, cursorY + 8, comp.title || "Alur Kerja", 12, "bold", TOKEN.gray700);
  const stepW = Math.floor((FRAME_W - 2 * PADDING - 32) / steps.length);
  steps.forEach((step, i) => {
    const sx = PADDING + 16 + i * stepW;
    makeText(frame, sx, cursorY + 32, step, 10, "regular", TOKEN.gray700);
    if (i < steps.length - 1) makeText(frame, sx + stepW - 16, cursorY + 32, "→", 10, "regular", TOKEN.gray400);
  });
  return 80;
}

function drawStatusLegend(frame, comp, cursorY) {
  const items = comp.items || [];
  roundedRect(frame, PADDING, cursorY, FRAME_W - 2 * PADDING, 80, TOKEN.gray50, 12, "status-legend");
  makeText(frame, PADDING + 16, cursorY + 12, comp.title || "Keterangan Status", 12, "bold", TOKEN.gray700);
  const itemW = Math.floor((FRAME_W - 2 * PADDING - 32) / Math.min(items.length, 6));
  items.slice(0, 6).forEach((item, i) => {
    const ix = PADDING + 16 + i * itemW;
    const labelTxt = typeof item === "string" ? item : item.status;
    roundedRect(frame, ix, cursorY + 34, labelTxt.length * 7 + 16, 22, TOKEN.gray200, 6, `legend-badge-${i}`);
    makeText(frame, ix + 8, cursorY + 39, labelTxt, 10, "medium", TOKEN.gray700);
  });
  return 96;
}

function drawQuickAccess(frame, comp, cursorY) {
  roundedRect(frame, PADDING, cursorY, FRAME_W - 2 * PADDING, 72, TOKEN.gray100, 12, "quick-access");
  makeText(frame, PADDING + 16, cursorY + 12, "Quick Access", 12, "bold", TOKEN.gray700);
  const btns = comp.buttons || [];
  let bx = PADDING + 16;
  btns.forEach(btn => {
    const bw = Math.max(140, btn.text.length * 8 + 32);
    roundedRect(frame, bx, cursorY + 36, bw, 24, TOKEN.gray900, 6, `qa-btn-${btn.id}`);
    makeText(frame, bx + 12, cursorY + 41, btn.text, 11, "medium", TOKEN.white);
    bx += bw + 12;
  });
  return 88;
}

function drawTwoColumnForm(frame, comp, infoPanelComp, formComp, cursorY) {
  const panelW = Math.floor((FRAME_W - 2 * PADDING - 24) * 0.3);
  const formW  = Math.floor((FRAME_W - 2 * PADDING - 24) * 0.7);
  const formX  = PADDING + panelW + 24;
  if (infoPanelComp) drawInfoPanel(frame, infoPanelComp, cursorY, PADDING, panelW);
  if (formComp) {
    let fy = cursorY;
    fy = drawForm(frame, formComp, fy);
    return fy - cursorY + 40;
  }
  return 320;
}

// ============================================================
// MAIN DRAW PAGE FUNCTION
// ============================================================

async function drawPage(spec) {
  await loadFonts();

  const frame = figma.createFrame();
  frame.name = `[${spec.role}] ${spec.name}`;
  frame.resize(spec.width || FRAME_W, spec.height || FRAME_H);
  frame.fills = solid(TOKEN.gray50);
  frame.clipsContent = false;

  let cy = 0;
  let infoPanelComp = null;

  // Navbar
  if (spec.layout && spec.layout.navbar) {
    cy += drawNavbar(frame, spec.navbar_items, cy);
  }

  // Header
  if (spec.layout && spec.layout.header && spec.header) {
    cy += drawHeader(frame, spec.header.title, spec.header.subtitle, spec.header.buttons, cy);
  }

  // Main content area starts
  cy += 24;

  // Components
  const comps = spec.components || [];
  let pendingInfoPanel = null;
  let pendingTwoCol = false;

  for (let i = 0; i < comps.length; i++) {
    const comp = comps[i];

    if (comp.type === "two-column-layout") {
      pendingTwoCol = true;
      continue;
    }
    if (comp.type === "info-panel") {
      pendingInfoPanel = comp;
      continue;
    }

    if (comp.type === "hero-banner") {
      cy += drawHeroBanner(frame, comp, cy);

    } else if (comp.type === "stat-cards") {
      cy += drawStatCards(frame, comp, cy);

    } else if (comp.type === "section-title") {
      makeText(frame, PADDING, cy, comp.text || "", 18, "bold", TOKEN.gray900);
      cy += 32;

    } else if (comp.type === "step-cards") {
      const steps = comp.steps || [];
      const stepW = Math.floor((FRAME_W - 2 * PADDING - (steps.length - 1) * 16) / steps.length);
      steps.forEach((s, i) => {
        roundedRect(frame, PADDING + i * (stepW + 16), cy, stepW, 64, TOKEN.white, 12, `step-card-${i}`);
        makeText(frame, PADDING + i * (stepW + 16) + 16, cy + 10, s.step || String(i + 1), 20, "bold", TOKEN.gray300);
        makeText(frame, PADDING + i * (stepW + 16) + 16, cy + 38, s.title || "", 12, "medium", TOKEN.gray700, stepW - 32);
      });
      cy += 80;

    } else if (comp.type === "menu-cards") {
      cy += drawMenuCards(frame, comp, cy);

    } else if (comp.type === "info-cards") {
      const cards = comp.cards || [];
      const cols = comp.columns || cards.length;
      const cw = Math.floor((FRAME_W - 2 * PADDING - (cols - 1) * 16) / cols);
      cards.forEach((card, i) => {
        const cx = PADDING + i * (cw + 16);
        roundedRect(frame, cx, cy, cw, 100, TOKEN.white, 12, `info-card-${i}`);
        makeText(frame, cx + 16, cy + 14, card.number || String(i + 1), 18, "bold", TOKEN.gray300);
        makeText(frame, cx + 16, cy + 44, card.title || "", 13, "bold", TOKEN.gray900, cw - 32);
        if (card.desc) makeText(frame, cx + 16, cy + 68, card.desc, 11, "regular", TOKEN.gray500, cw - 32);
      });
      cy += 116;

    } else if (comp.type === "shortcut-panel") {
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, 80, TOKEN.white, 12, "shortcut-panel");
      makeText(frame, PADDING + 20, cy + 16, comp.title || "Shortcut", 14, "bold", TOKEN.gray900);
      if (comp.button) {
        const bw = Math.max(140, comp.button.text.length * 8 + 32);
        roundedRect(frame, FRAME_W - PADDING - bw - 20, cy + 20, bw, 40, TOKEN.gray900, 10, `shortcut-btn`);
        makeText(frame, FRAME_W - PADDING - bw - 8, cy + 30, comp.button.text, 13, "medium", TOKEN.white);
      }
      cy += 96;

    } else if (comp.type === "form") {
      if (pendingTwoCol && pendingInfoPanel) {
        const panelW = Math.floor((FRAME_W - 2 * PADDING - 24) * 0.3);
        const formW  = Math.floor((FRAME_W - 2 * PADDING - 24) * 0.7);
        drawInfoPanel(frame, pendingInfoPanel, cy, PADDING, panelW);
        const savedCy = cy;
        const fxStart = PADDING + panelW + 24;
        // Shift form to right column manually
        let fy = cy;
        if (comp.title) {
          makeText(frame, fxStart, fy, comp.title, 14, "bold", TOKEN.gray900);
          fy += 32;
        }
        const fields = comp.fields || [];
        fields.forEach(field => {
          makeText(frame, fxStart, fy, field.label || "Field", 12, "medium", TOKEN.gray700);
          fy += 20;
          const inputH = field.type === "textarea" ? 72 : 40;
          roundedRect(frame, fxStart, fy, formW, inputH, TOKEN.white, 10, `field-${field.id}`);
          fy += inputH + 16;
        });
        cy = Math.max(savedCy + 300, fy);
        pendingTwoCol = false;
        pendingInfoPanel = null;
      } else {
        cy = drawForm(frame, comp, cy);
      }

    } else if (comp.type === "filter-bar") {
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, 52, TOKEN.white, 10, "filter-bar");
      makeText(frame, PADDING + 16, cy + 16, "Filter:", 12, "medium", TOKEN.gray700);
      const filters = comp.filters || [];
      let fx = PADDING + 80;
      filters.forEach(f => {
        roundedRect(frame, fx, cy + 10, 180, 32, TOKEN.gray100, 8, `filter-${f.id}`);
        makeText(frame, fx + 12, cy + 18, `${f.label || "Filter"}: Semua ▼`, 12, "regular", TOKEN.gray500);
        fx += 196;
      });
      cy += 68;

    } else if (comp.type === "table") {
      const newY = drawTable(frame, comp, cy);
      cy = newY;

    } else if (comp.type === "button-group") {
      cy += drawButtonGroup(frame, comp.buttons, cy);

    } else if (comp.type === "button") {
      const bw = Math.max(160, comp.text.length * 9 + 32);
      const fill = comp.variant === "primary" ? TOKEN.gray900 : TOKEN.gray200;
      const tc = comp.variant === "primary" ? TOKEN.white : TOKEN.gray700;
      roundedRect(frame, comp.full_width ? PADDING : PADDING, cy, comp.full_width ? FRAME_W - 2 * PADDING : bw, 44, fill, 10, `btn-${comp.id}`);
      makeText(frame, PADDING + 16, cy + 14, comp.text, 14, "medium", tc);
      cy += 60;

    } else if (comp.type === "chat-header") {
      cy = drawChat(frame, comp, cy);

    } else if (comp.type === "chat-messages") {
      // handled in drawChat above with chat-header
      continue;

    } else if (comp.type === "textarea" || comp.type === "input") {
      if (comp.label) makeText(frame, PADDING, cy, comp.label, 12, "medium", TOKEN.gray700);
      cy += 20;
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, comp.type === "textarea" ? 72 : 40, TOKEN.white, 8, `input-${comp.id || "field"}`);
      if (comp.placeholder) makeText(frame, PADDING + 14, cy + 12, comp.placeholder, 12, "regular", TOKEN.gray400);
      cy += (comp.type === "textarea" ? 72 : 40) + 16;

    } else if (comp.type === "checkbox") {
      roundedRect(frame, PADDING, cy, 18, 18, TOKEN.white, 4, "checkbox");
      makeText(frame, PADDING + 4, cy + 2, "✓", 10, "bold", TOKEN.gray500);
      makeText(frame, PADDING + 26, cy + 2, comp.label || "Checkbox", 13, "regular", TOKEN.gray700);
      cy += 32;

    } else if (comp.type === "link") {
      makeText(frame, PADDING, cy, comp.text || "Link", 13, "medium", TOKEN.gray500);
      cy += 24;

    } else if (comp.type === "detail-section") {
      if (comp.title) {
        makeText(frame, PADDING, cy, comp.title, 15, "bold", TOKEN.gray900);
        cy += 28;
      }
      const fields = comp.fields || [];
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, Math.max(80, fields.length * 28 + 24), TOKEN.white, 12, "detail-section");
      const colW = Math.floor((FRAME_W - 2 * PADDING - 40) / 2);
      fields.forEach((field, fi) => {
        const col = fi % 2;
        const row = Math.floor(fi / 2);
        makeText(frame, PADDING + 20 + col * colW, cy + 14 + row * 28, `${field}:`, 11, "medium", TOKEN.gray500);
        makeText(frame, PADDING + 20 + col * colW + 100, cy + 14 + row * 28, `[${field} value]`, 11, "regular", TOKEN.gray700);
      });
      cy += Math.max(80, fields.length * 14 + 32) + 16;

    } else if (comp.type === "file-upload") {
      if (comp.label) makeText(frame, PADDING, cy, comp.label, 12, "medium", TOKEN.gray700);
      cy += 20;
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, 56, TOKEN.gray50, 10, "file-upload-area");
      makeText(frame, PADDING + 16, cy + 18, `📎 ${comp.label || "Upload file..."} (klik untuk pilih)`, 12, "regular", TOKEN.gray400);
      cy += 72;

    } else if (comp.type === "image-placeholder") {
      makeText(frame, PADDING, cy, comp.label || "Foto", 12, "medium", TOKEN.gray700);
      cy += 20;
      roundedRect(frame, PADDING, cy, 200, 160, TOKEN.gray200, 10, "img-placeholder");
      makeText(frame, PADDING + 60, cy + 68, "[FOTO]", 14, "regular", TOKEN.gray400);
      cy += 176;

    } else if (comp.type === "image-gallery") {
      makeText(frame, PADDING, cy, comp.label || "Gallery", 12, "medium", TOKEN.gray700);
      cy += 20;
      const count = comp.placeholder_count || 3;
      for (let pi = 0; pi < count; pi++) {
        roundedRect(frame, PADDING + pi * 176, cy, 160, 120, TOKEN.gray200, 10, `gallery-img-${pi}`);
        makeText(frame, PADDING + pi * 176 + 48, cy + 48, "[FOTO]", 12, "regular", TOKEN.gray400);
      }
      cy += 136;

    } else if (comp.type === "timeline") {
      cy += drawTimeline(frame, comp, cy);

    } else if (comp.type === "workflow-steps") {
      cy += drawWorkflowSteps(frame, comp, cy);

    } else if (comp.type === "status-legend") {
      cy += drawStatusLegend(frame, comp, cy);

    } else if (comp.type === "quick-access-panel") {
      cy += drawQuickAccess(frame, comp, cy);

    } else if (comp.type === "report-header") {
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, 80, TOKEN.gray100, 12, "report-header");
      makeText(frame, PADDING + 20, cy + 12, comp.title || "LAPORAN", 16, "bold", TOKEN.gray900);
      const fields = comp.fields || [];
      let rx = PADDING + 20;
      fields.forEach((f, fi) => {
        makeText(frame, rx, cy + 44, `${f}: [...]`, 11, "regular", TOKEN.gray700, 200);
        rx += 200;
      });
      cy += 96;

    } else if (comp.type === "branding-panel") {
      roundedRect(frame, 0, 0, FRAME_W / 2, FRAME_H, TOKEN.dark, 0, "branding-panel");
      makeText(frame, 60, 60, comp.title || "PT PAL", 28, "bold", TOKEN.white, FRAME_W / 2 - 120);
      if (comp.subtitle) makeText(frame, 60, 100, comp.subtitle, 13, "regular", TOKEN.gray400, FRAME_W / 2 - 120);
      if (comp.stats) {
        comp.stats.forEach((s, i) => {
          roundedRect(frame, 60 + i * 200, 160, 176, 80, TOKEN.gray700, 12, `stat-card-br-${i}`);
          makeText(frame, 76, 180, s.value, 24, "bold", TOKEN.white);
          makeText(frame, 76, 212, s.label, 11, "regular", TOKEN.gray400);
        });
      }

    } else if (comp.type === "hero") {
      roundedRect(frame, 0, 0, FRAME_W, FRAME_H, TOKEN.dark, 0, "welcome-bg");
      makeText(frame, FRAME_W / 2 - 280, 200, comp.title || "Sistem", 36, "bold", TOKEN.white, 560);
      if (comp.subtitle) makeText(frame, FRAME_W / 2 - 200, 260, comp.subtitle, 16, "regular", TOKEN.gray400, 400);

    } else if (comp.type === "checkbox") {
      roundedRect(frame, PADDING, cy, 18, 18, TOKEN.white, 4, "checkbox-box");
      makeText(frame, PADDING + 26, cy + 2, comp.label || "Option", 13, "regular", TOKEN.gray700);
      cy += 32;

    } else if (comp.type === "pagination") {
      roundedRect(frame, PADDING, cy, FRAME_W - 2 * PADDING, 40, TOKEN.white, 8, "pagination");
      makeText(frame, PADDING + 16, cy + 12, "← Sebelumnya  1  2  3 ... 10  Berikutnya →", 12, "regular", TOKEN.gray500);
      cy += 56;
    }
  }

  // Resize frame to content
  const finalH = Math.max(FRAME_H, cy + 40);
  frame.resize(FRAME_W, finalH);

  return frame;
}

// ============================================================
// MESSAGE HANDLER
// ============================================================

figma.ui.onmessage = async (msg) => {
  if (msg.type === "generate-all") {
    const spec = msg.spec;
    const pages = spec.pages || [];
    let generated = 0;
    let x = 0;

    figma.ui.postMessage({ type: "progress", current: 0, total: pages.length });

    for (const page of pages) {
      try {
        const frame = await drawPage(page);
        frame.x = x;
        frame.y = 0;
        x += (frame.width || FRAME_W) + 80;
        generated++;
        figma.ui.postMessage({ type: "progress", current: generated, total: pages.length });
      } catch (err) {
        console.error(`Error generating ${page.name}:`, err);
      }
    }

    figma.viewport.scrollAndZoomIntoView(figma.currentPage.children);
    figma.ui.postMessage({ type: "done", generated, total: pages.length });
  }

  if (msg.type === "generate-single") {
    const page = msg.page;
    try {
      const frame = await drawPage(page);
      figma.viewport.scrollAndZoomIntoView([frame]);
      figma.ui.postMessage({ type: "done", generated: 1, total: 1 });
    } catch (err) {
      figma.ui.postMessage({ type: "error", message: String(err) });
    }
  }

  if (msg.type === "cancel") {
    figma.closePlugin();
  }
};
