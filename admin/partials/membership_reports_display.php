<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://mydevitsolutions.com
 * @since      1.0.0
 *
 * @package    Membership
 * @subpackage Membership/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap members-cm members-report">
  <h1>Membership Reports</h1>

  <!-- Summary cards -->
  <div class="grid">
    <div class="card">
      <p class="kicker">Active Subscribers</p>
      <p class="metric">110</p>
      <p class="badge success">+5 this week</p>
    </div>

    <div class="card">
      <p class="kicker">Revenue (MTD)</p>
      <p class="metric currency" id="revenueMtd">$12,500</p>
      <p class="badge">Avg. order $45</p>
    </div>

    <div class="card">
      <p class="kicker">Total Members</p>
      <p class="metric" id="totalMembers">150</p>
    </div>

    <div class="card">
      <p class="kicker">Expired Members</p>
      <p class="metric" id="allMembers">40</p>
      <p class="badge warn">Renewals due</p>
    </div>
  </div>


<!-- Revenue Dashboard -->
<div class="dash-wrap">
  <!-- Readability Panel -->
  <div class="card">
    <div class="card-hd">
      <h3>Readability Overview</h3>
    </div>
    <div class="card-body rbdy">
      <ul class="score-list" id="scoreList">
        <li>
          <span class="dot all-members"></span>
          <span class="label">Total Members</span>
          <span class="badge" data-badge="allMembers">0</span>
        </li>
        <li>
          <span class="dot act-members"></span>
          <span class="label">Active Members</span>
          <span class="badge" data-badge="good">0</span>
        </li>        
        <li>
          <span class="dot expired-members"></span>
          <span class="label">Expired Members</span>
          <span class="badge" data-badge="ok">0</span>
        </li>        
      </ul>
      <div class="score-chart">
        <canvas id="readabilityChart" width="230" height="230" aria-label="Readability donut"></canvas>
      </div>
    </div>
  </div>

  <!-- Sales + Goal Panel -->
  <div class="card">
    <div class="card-hd">
      <h3>Sales Overview</h3>
      <small><a href="#" style="text-decoration:none;">5% more in 2024</a></small>
    </div>
    <div class="card-body">
      <!-- parent needs height for responsive canvas -->
      <div id="salesWrap" style="height:260px;">
        <canvas id="salesChart" aria-label="Sales Overview (with goal line)"></canvas>
      </div>
    </div>
  </div>
</div>


<div class="report-table-bx">
  <form method="get" action="">
    <div class="report-filters">
      <div>
        <label>Plan</label>
        <select id="fPlan">
          <option value="">All</option>
          <option>Gold</option>
          <option>Silver</option>
          <option>Bronze</option>
        </select>
      </div>
      <div>
        <label>Status</label>
        <select id="fStatus">
          <option value="">All</option>
          <option value="Active">Active</option>
          <option value="Expired">Expired</option>
          <option value="Paused">Paused</option>
        </select>
      </div>
      <div>
        <label>Start From</label>
        <input type="date" id="fStart">
      </div>
      <div style="flex:1 1 220px">
        <label>End To</label>
        <input type="date" id="fEnd">
      </div>
      <div style="display:flex;gap:8px">
        <button class="btn" id="applyBtn">Apply Filters</button>
        <button class="btn secondary" id="resetBtn">Reset</button>
      </div>
    </div>
  </form>
  

<!-- Table -->
<table class="wp-list-table widefat fixed striped table-view-list roles">
  <thead>
    <tr>
      <td id="cb" class="check-column">
        <input id="cb-select-all-1" type="checkbox">
        <label for="cb-select-all-1">
          <span class="screen-reader-text">Select All</span>
        </label>
      </td>
      <th id="title" class="sortable asc">Username</th>
      <th id="email" >Email</th>
      <th id="users">Membership Plan</th>
      <th id="access-start">Access Starts</th>
      <th id="access-end">Access End</th>
      <th id="account-state">Account Status</th>
      <th id="amount">Amount</th>
    </tr>
  </thead>

  <tbody id="the-list">
    <tr>
      <th scope="row" class="check-column">
        <input type="checkbox" name="roles[client]" value="client">
      </th>
      <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
        <strong>Zsmith</strong>
        <div class="row-actions">
          <span class="edit"><a href="#">Edit</a> | </span>
          <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
        </div>
      </td>
      <td>Zsmith1212@gmail.com</td>
      <td><a href="#">Gold</a></td>
      <td>2025-05-05</td>
      <td>2025-06-05</td>
      <td>Pending</td>
      <td>$49.99</td>
    </tr>

    <tr>
      <th scope="row" class="check-column">
        <input type="checkbox" name="roles[client]" value="client">
      </th>
      <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
        <strong>Hanery</strong>
        <div class="row-actions">
          <span class="edit"><a href="#">Edit</a> | </span>
          <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
        </div>
      </td>
      <td>Hanery2211@gmail.com</td>
      <td><a href="#">Silver</a></td>
      <td>2025-06-02</td>
      <td>2025-07-02</td>
      <td>Inactive</td>
      <td>$29.99</td>
    </tr>

    <tr>
      <th scope="row" class="check-column">
        <input type="checkbox" name="roles[client]" value="client">
      </th>
      <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
        <strong>Larry</strong>
        <div class="row-actions">
          <span class="edit"><a href="#">Edit</a> | </span>
          <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
        </div>
      </td>
      <td>Larry1255@gmail.com</td>
      <td><a href="#">Bronze</a></td>
      <td>2025-07-08</td>
      <td>2025-08-08</td>
      <td>Pending</td>
      <td>$45.99</td>
    </tr>

    <tr>
      <th scope="row" class="check-column">
        <input type="checkbox" name="roles[client]" value="client">
      </th>
      <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
        <strong>Rammpa</strong>
        <div class="row-actions">
          <span class="edit"><a href="#">Edit</a> | </span>
          <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
        </div>
      </td>
      <td>Rammpa912@gmail.com</td>
      <td><a href="#">Gold</a></td>
      <td>2025-05-05</td>
      <td>2025-06-05</td>
      <td>Active</td>
      <td>$49.99</td>
    </tr>       

    <tr>
      <th scope="row" class="check-column">
        <input type="checkbox" name="roles[client]" value="client">
      </th>
      <td class="title column-title has-row-actions column-primary" data-colname="Role Name">
        <strong>Laura</strong>
        <div class="row-actions">
          <span class="edit"><a href="#">Edit</a> | </span>
          <span class="delete"><a class="members-delete-role-link" href="#">Delete</a> | </span>
        </div>
      </td>
      <td>Laura422@gmail.com</td>
      <td><a href="#">Silver</a></td>
      <td>2025-05-05</td>
      <td>2025-06-05</td>
      <td>Pending</td>
      <td>$89.99</td>
    </tr>
  </tbody>
</table>
</div>
</div>



<!-- ===== Chart.js ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  /* ---------------- READABILITY DONUT (no-crop hover) ---------------- */
  const rState = {
    good: 110, ok: 40, allMembers: 150, notAnalyzed: 0,
    links: {
      good:  '/wp-admin/edit.php?post_status=publish&post_type=post&readability_filter=good',
      ok:    '/wp-admin/edit.php?post_status=publish&post_type=post&readability_filter=ok',
      allMembers: '/wp-admin/edit.php?post_status=publish&post_type=post&readability_filter=bad',
      notAnalyzed:      '/wp-admin/edit.php?post_status=publish&post_type=post&readability_filter=na'
    }
  };
  function paintBadges(){
    ['good','ok','allMembers','notAnalyzed'].forEach(k=>{
      const b = document.querySelector(`[data-badge="${k}"]`); if(b) b.textContent = rState[k];
      const a = document.querySelector(`[data-link="${k}"]`);  if(a) a.href = rState.links[k] || '#';
    });
  }
  paintBadges();

  const rCtx = document.getElementById('readabilityChart').getContext('2d');
  const rChart = new Chart(rCtx, {
    type: 'doughnut',
    data: {
    labels: ['Active Members','Expired Members','Total Members'],
      datasets: [{
        data: [rState.good, rState.ok, rState.allMembers, rState.notAnalyzed],
        backgroundColor: ['#68d391', '#f56565', '#f6ad55', '#cbd5e1'],
        borderWidth: 0, cutout: '68%', hoverOffset: 10
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      layout: { padding: 12 }, // space so hover slice never crops
      plugins: {
        legend: { display:false },
        tooltip:{ callbacks:{ label: (c)=> `${c.label}: ${c.formattedValue}` } }
      }
    }
  });

  // Public API: update readability dynamically
  window.setReadabilityStats = function(next){
    Object.assign(rState, next||{});
    paintBadges();
    rChart.data.datasets[0].data = [rState.good, rState.ok, rState.allMembers, rState.notAnalyzed];
    rChart.update();
  };

  /* ---------------- SALES LINE + GOAL LINE ---------------- */
  const sCtx = document.getElementById('salesChart').getContext('2d');

  // Custom plugin to draw a dashed horizontal goal line + label
  const GoalLine = {
    id: 'goalLine',
    afterDatasetsDraw(chart, args, pluginOptions){
      const {ctx, chartArea: {top,bottom,left,right}, scales:{y}} = chart;
      const goal = pluginOptions?.value ?? null;
      if(goal == null) return;
      const yPx = y.getPixelForValue(goal);
      ctx.save();
      ctx.setLineDash([6,6]);
      ctx.strokeStyle = pluginOptions.color || '#64748b';
      ctx.lineWidth = 1.5;
      ctx.beginPath();
      ctx.moveTo(left, yPx); ctx.lineTo(right, yPx); ctx.stroke();
      ctx.setLineDash([]);
      // label box
      const label = (pluginOptions.label || 'Goal') + ': ' + goal;
      ctx.fillStyle = '#ffffff';
      ctx.strokeStyle = '#cbd5e1';
      ctx.lineWidth = 1;
      ctx.font = '12px system-ui,-apple-system,Segoe UI,Roboto';
      const pad = 6;
      const w = ctx.measureText(label).width + pad*2;
      const h = 20;
      const x = right - w - 6, yBox = yPx - h - 6;
      ctx.fillRect(x, yBox, w, h);
      ctx.strokeRect(x, yBox, w, h);
      ctx.fillStyle = '#111827';
      ctx.fillText(label, x+pad, yBox+14);
      ctx.restore();
    }
  };

  // Register plugin globally or pass in chart options.plugins
  Chart.register(GoalLine);

  // Guarded gradient
  function makeGradient(chart){
    const {ctx, chartArea} = chart;
    if(!chartArea) return 'rgba(77, 104, 255, .20)';
    const g = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
    g.addColorStop(0, 'rgba(77, 104, 255, .25)');
    g.addColorStop(1, 'rgba(77, 104, 255, 0)');
    return g;
  }

  const sState = {
    labels: ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    series: [40, 20, 300, 220, 520, 260, 410, 240, 520],
    goal: 500
  };

  const sChart = new Chart(sCtx, {
    type: 'line',
    data: {
      labels: sState.labels,
      datasets: [{
        label: 'Mobile apps',
        data: sState.series,
        borderColor: '#4d68ff',
        backgroundColor: (c)=> makeGradient(c.chart),
        fill: true,
        pointRadius: 3,
        pointHoverRadius: 6,
        pointBackgroundColor: '#4d68ff',
        tension: 0.35,
        borderWidth: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false, // obey #salesWrap height
      interaction: { intersect:false, mode:'index' },
      layout: { padding: {left:8,right:8,top:8,bottom:8} },
      plugins: {
        legend: { display:false },
        tooltip: {
          displayColors:false,
          callbacks: {
            title: (items)=> items[0].label,
            label: (ctx)=> ` Mobile apps: ${ctx.parsed.y}`
          }
        },
        goalLine: { value: sState.goal, label:'Goal', color:'#94a3b8' } // plugin options
      },
      scales: {
        x: { grid: { display:false }, ticks: { color:'#64748b' } },
        y: { beginAtZero: true, grid: { color:'#e9eef5', borderDash:[4,4] }, ticks:{ color:'#94a3b8' } }
      }
    }
  });

  // Public API: update sales/goal dynamically
  window.setSalesOverview = function({ labels, series, goal }){
    if(labels) sChart.data.labels = labels;
    if(series) sChart.data.datasets[0].data = series;
    if(typeof goal === 'number'){
      sChart.options.plugins.goalLine.value = goal;
    }
    sChart.update();
  };

  // Example dynamic update:
  // setTimeout(()=> setSalesOverview({ series:[60,40,320,230,540,300,420,260,560], goal:520 }), 2500);
});
</script>


<script>
  // Enhanced Sorting Logic
  document.querySelectorAll("th.sortable").forEach(header => {
    header.addEventListener("click", () => {
      const table = header.closest("table");
      const tbody = table.querySelector("tbody");
      const headers = Array.from(header.parentNode.children);
      const index = headers.indexOf(header);
      const rows = Array.from(tbody.querySelectorAll("tr"));

      const isAsc = header.classList.contains("asc");
      document.querySelectorAll("th").forEach(th => th.classList.remove("asc", "desc"));
      header.classList.add(isAsc ? "desc" : "asc");

      const isNumeric = !isNaN(rows[0].children[index].textContent.trim());

      rows.sort((a, b) => {
        const A = a.children[index].textContent.trim();
        const B = b.children[index].textContent.trim();
        return isAsc
        ? (isNumeric ? B - A : B.localeCompare(A))
        : (isNumeric ? A - B : A.localeCompare(B));
      });

      rows.forEach(row => tbody.appendChild(row));
    });
  });    
</script>