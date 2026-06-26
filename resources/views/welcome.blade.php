<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alshamel WMS Demo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="container">
        <header>
            <h1 data-i18n="title">Alshamel Medical</h1>
            <p data-i18n="subtitle">Warehouse Management System (WMS) - Inventory Control</p>
            <a href="https://github.com/johnzgit/alshamel-inventory-demo" target="_blank" class="github-btn" data-i18n="github_btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                View on GitHub
            </a>
        </header>

        <main class="grid-layout">
            <!-- Left Side: Inventory List -->
            <section class="glass-panel inventory-section">
                <div class="panel-header" style="justify-content: space-between;">
                    <h2><span class="icon">📦</span> <span data-i18n="inventory_title">Current Inventory</span></h2>
                    <input type="text" id="searchInput" placeholder="Search SKU or Batch..." class="search-box" data-i18n="search_placeholder">
                </div>
                
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th data-i18n="th_product">Product / SKU</th>
                                <th data-i18n="th_warehouse">Warehouse</th>
                                <th data-i18n="th_batch">Batch</th>
                                <th data-i18n="th_qty">Qty</th>
                                <th data-i18n="th_action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryList">
                            <tr><td colspan="5" style="text-align: center;" data-i18n="loading_data">Loading inventory data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Right Side: API Playground -->
            <section class="glass-panel api-playground">
                <div class="panel-header">
                    <h2><span class="icon">⚡</span> <span data-i18n="api_monitor_title">System Terminal (API Monitor)</span></h2>
                </div>
                
                <div class="api-docs" style="margin-bottom: 1rem;">
                    <!-- GET Batches -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/batches</span>
                            <span class="api-desc" data-i18n="api_desc_batches">List all available batches</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/batches')" data-i18n="fetch_batches">Send Request</button>
                        </div>
                    </div>
                    
                    <!-- GET Reasons -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/reasons</span>
                            <span class="api-desc" data-i18n="api_desc_reasons">List adjustment reasons</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/reasons')" data-i18n="fetch_reasons">Send Request</button>
                        </div>
                    </div>

                    <!-- GET History -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method get">GET</span>
                            <span class="api-path">/api/inventory-adjustments</span>
                            <span class="api-desc" data-i18n="api_desc_history">View adjustment history</span>
                        </div>
                        <div class="api-body">
                            <button class="btn-secondary" onclick="testEndpoint('GET', '/api/inventory-adjustments')" data-i18n="fetch_history">Send Request</button>
                        </div>
                    </div>

                    <!-- POST Adjustment -->
                    <div class="api-endpoint">
                        <div class="api-header" onclick="this.nextElementSibling.classList.toggle('active')">
                            <span class="api-method post">POST</span>
                            <span class="api-path">/api/inventory-adjustments</span>
                            <span class="api-desc" data-i18n="api_desc_post">Create new adjustment</span>
                        </div>
                        <div class="api-body">
                            <textarea id="mockPayload" class="payload-input">{
  "batch_id": 1,
  "reason_id": 1,
  "new_quantity": 95,
  "note": "Mock test from API docs"
}</textarea>
                            <button class="btn-secondary" onclick="testPostEndpoint('/api/inventory-adjustments', document.getElementById('mockPayload').value)" data-i18n="post_adjustment">Send Request</button>
                        </div>
                    </div>
                </div>
                <div class="terminal">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                        <span class="terminal-title" data-i18n="terminal_header">Network Response</span>
                    </div>
                    <pre><code id="apiResponse">// Real-time JSON payloads will appear here during adjustments...</code></pre>
                </div>
            </section>
        </main>
    </div>

    <!-- Adjustment Modal -->
    <div class="modal-backdrop hidden" id="adjustModal">
        <div class="glass-panel modal-content">
            <div class="modal-header">
                <h3><span data-i18n="modal_title">Adjust Batch</span>: <span id="modalBatchNum" style="color: var(--accent-color);"></span></h3>
                <button class="close-btn" id="closeModal">&times;</button>
            </div>
            
            <div class="product-info-card">
                <div class="info-row">
                    <span class="label" data-i18n="lbl_product">Product:</span>
                    <span class="value" id="modalProductName"></span>
                </div>
                <div class="info-row">
                    <span class="label" data-i18n="lbl_warehouse">Location:</span>
                    <span class="value" id="modalWarehouse"></span>
                </div>
                <div class="info-row highlight">
                    <span class="label" data-i18n="lbl_current">System Qty:</span>
                    <span class="value" id="modalCurrentStock"></span>
                </div>
            </div>

            <form id="adjustmentForm" class="form-layout">
                <input type="hidden" id="batchIdInput">
                
                <div class="form-group">
                    <label for="reasonSelect" data-i18n="lbl_reason">Reason for Adjustment</label>
                    <select id="reasonSelect" required>
                        <option value="">Loading reasons...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="newQuantity" data-i18n="lbl_new_qty">Actual Counted Qty</label>
                    <input type="number" id="newQuantity" min="0" required placeholder="Enter the exact physical count" data-i18n="placeholder_qty">
                    <div class="diff-indicator" id="diffIndicator">Variance: --</div>
                </div>

                <div class="form-group">
                    <label for="noteInput" data-i18n="lbl_note">Inspector Notes (Optional)</label>
                    <textarea id="noteInput" rows="2" placeholder="Explain the discrepancy" data-i18n="placeholder_note"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" id="cancelBtn" data-i18n="btn_cancel">Cancel</button>
                    <button type="submit" class="btn-primary" id="submitBtn" data-i18n="btn_confirm">Confirm Adjustment</button>
                </div>
                
                <div id="statusMessage" class="status-message hidden"></div>
            </form>
        </div>
    </div>

    <script src="/js/i18n.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
